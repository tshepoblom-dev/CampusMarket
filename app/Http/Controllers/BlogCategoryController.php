<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Models\BlogCategoryTranslation;
use Illuminate\Support\Facades\Validator;


class BlogCategoryController extends Controller
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
        $page_title = translate('Blog Categories');
        $lang = $request->lang;
        $categories = BlogCategory::latest()->paginate(10);
        return view('backend.blog.category', compact('page_title', 'categories', 'lang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:blog_categories,name',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $category = new BlogCategory;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image != '') {
                $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/blog'), $image_name);
                $category->image = $image_name;
            }
        }

        $category->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $same_slug_count = BlogCategory::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        $category->slug = $slug;
        $category->save();
        return redirect()->back()->with('success', translate('Category saved successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $page_title = translate('Edit Category');
        $lang = $request->lang;
        $categorySingle = BlogCategory::findOrFail($id);
        return view('backend.blog.category_edit', compact('page_title', 'categorySingle', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:blog_categories,name,' . $id,
        ]);


        if ($request->hasFile('image')) {
            $validator = Validator::make($request->all(), [

                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp'
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $category = BlogCategory::findOrFail($id);

        if ($request->lang == get_setting("DEFAULT_LANGUAGE", "en")) {
            $category->name = $request->name;
        }


        if ($request->hasFile('image')) {
            /** image upload */
            $image = $request->file('image');
            if ($image != '') {
                if ($category->image != null) {
                    unlink(public_path('uploads/blog/' . $category->image));
                }
                $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/blog'), $image_name);
                $category->image = $image_name;
            }
        }
        $category->update();

        $category_translation = BlogCategoryTranslation::firstOrNew(['lang' => $request->lang, 'blog_category_id' => $category->id]);
        $category_translation->name = $request->name;
        $category_translation->save();

        return redirect()->route('blog.category.list')->with('success', translate('Category has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = BlogCategory::findOrFail($id);
        // Category Translations Delete
        foreach ($category->blog_category_translations as $key => $category_translation) {
            $category_translation->delete();
        }
        $category->delete();
        return back()->with('success', translate('Category deleted successfully'));
    }

    /**
     * Change Category status.
     */

    public function changeStatus()
    {
        $status         = $_POST['status'];
        $categoryId     = $_POST['categoryId'];

        if ($status && $categoryId) {
            $category = BlogCategory::findOrFail($categoryId);
            if ($status == 1) {
                $category->status = 2;
                $message = translate('Category Inactive');
            } else {
                $category->status = 1;
                $message = translate('Category Active');
            }
            if ($category->update()) {
                $response = array('output' => 'success', 'statusId' => $category->status, 'catId' => $category->id, 'message' => $message, 'active' => translate('Active'), 'inactive' => translate('Inactive'));
                return response()->json($response);
            }
        }
    }
}
