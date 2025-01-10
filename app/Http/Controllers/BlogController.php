<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Models\BlogTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin','pverify']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lang = $request->lang;
        $page_title = translate('All Blogs');

        if ($request->search) {
            $blogs = Blog::where('title', 'LIKE', '%' . $request->search . '%')->latest()->paginate(10);
        } else {
            $blogs = Blog::latest()->paginate(10);
        }
        return view('backend.blog.index', compact('page_title', 'blogs', 'lang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = translate('Create Blog');
        $categories = BlogCategory::where('status', 1)->orderBy('name', 'asc')->get();
        return view('backend.blog.create', compact('categories', 'page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        /** Validation */
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:blogs,title',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp',
            'category_id' => 'required|max:255',
            'tags' => 'nullable',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $blogs = new Blog;



         if($request->hasFile('image')){
            $featues_image = $request->file('image');
            if ($featues_image != '') {
                $featues_image_name = pathinfo($featues_image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $featues_image->getClientOriginalExtension();
                $featues_image->move(public_path('uploads/blog'), $featues_image_name);
                $blogs->image = $featues_image_name;
            }

         }


        $blogs->title = $request->title;
        $blogs->meta_title = $request->meta_title;
        $blogs->meta_keyward = $request->meta_keyward;

        $blogs->meta_description =str_replace('script' , '', prelaceScript(html_entity_decode($request->meta_description)));
        $blogs->description =str_replace('script' , '', prelaceScript(html_entity_decode( $request->description)));

        $blogs->tags = $request->tags;
        $blogs->category_id = $request->category_id;
        $blogs->user_id = $user->id;


        if ($user->role == 2) {
            $blogs->status = 2;
        }

        $slug = Str::slug($request->title, '-');
        $same_slug_count = Blog::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        $blogs->slug = $slug;
        $blogs->enable_seo = $request->enable_seo == "on" ? 1 : null;
        $blogs->save();

        return redirect()->route('blog.list')->with('success', translate('Blog saved successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $page_title = translate('Edit Blog');
        $lang = $request->lang;
        $blogSingle = Blog::findOrFail($id);
        $categories = BlogCategory::where('status', 1)->orderBy('name', 'asc')->get();
        return view('backend.blog.edit', compact('page_title', 'categories', 'blogSingle', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $blogs = Blog::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:blogs,title,'.$id,
            'description' => 'required',
            'category_id' => 'required|max:255',
            'tags' => 'nullable',
        ]);



        if($request->hasFile('image')){
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp',
            ]);
         }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        if ($request->lang == get_setting("DEFAULT_LANGUAGE", "en")) {
            $blogs->title = $request->title;
            $blogs->description = str_replace('script' , '', prelaceScript(html_entity_decode( $request->description)));
            $blogs->tags = $request->tags;
        }


        if($request->hasFile('image')){
            $image = $request->file('image');
            if ($image != '') {
                if ($blogs->image != null) {
                    unlink(public_path('uploads/blog/' . $blogs->image));
                }
                $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/blog'), $image_name);
                $blogs->image = $image_name;
            }
        }

        $blogs->category_id = $request->category_id;
        $blogs->meta_title = $request->meta_title;
        $blogs->meta_keyward = $request->meta_keyward;

        $blogs->enable_seo = $request->enable_seo == "on" ? 1 : null;
        $blogs->update();

        $blog_translation = BlogTranslation::firstOrNew(['lang' => $request->lang, 'blog_id' => $blogs->id]);
        $blog_translation->title = $request->title;
        $blog_translation->description = str_replace('script' , '', prelaceScript(html_entity_decode( $request->description)));
        $blog_translation->tags = $request->tags;
        $blog_translation->save();

        return redirect()->route('blog.list')->with('success', translate('Blog has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blogs = Blog::findOrFail($id);
        // Blog Translations Delete
        foreach ($blogs->blog_translations as $key => $blog_translation) {
            $blog_translation->delete();
        }
        $blogs->delete();
        return back()->with('success', translate('Blog deleted successfully'));
    }

    /**
     * Change Blog status.
     */

    public function changeStatus()
    {
        $status         = $_POST['status'];
        $blogId     = $_POST['blogId'];

        if ($status && $blogId) {
            $blogs = Blog::findOrFail($blogId);
            if ($status == 1) {
                $blogs->status = 2;
                $message = translate('Blog Inactive');
            } else {
                $blogs->status = 1;
                $message = translate('Blog Active');
            }
            if ($blogs->update()) {
                $response = array('output' => 'success', 'statusId' => $blogs->status, 'blogId' => $blogs->id, 'message' => $message, 'active' => translate('Active'), 'inactive' => translate('Inactive'));
                return response()->json($response);
            }
        }
    }
}
