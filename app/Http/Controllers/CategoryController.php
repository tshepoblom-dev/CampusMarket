<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoryTranslation;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
        $page_title = translate('Categories');
        $categories = Category::latest()->paginate(10);
        return view('backend.category.index', compact('page_title', 'categories', 'lang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = new Category;

        if( $request->hasFile('image')){
            $image = $request->file('image');
            $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $image_name);
            $category->image = $image_name;
        }

        $category->name = prelaceScript(html_entity_decode($request->name)) ;
        $slug = Str::slug(prelaceScript(html_entity_decode($request->name)), '-');
        $same_slug_count = Category::where('slug', 'LIKE', $slug . '%')->count();
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
        $page_title = translate('Category');
        $lang = $request->lang;
        $categorySingle = Category::findOrFail($id);
        return view('backend.category.edit', compact('page_title', 'categorySingle', 'lang'));
    }

    /**
     * update a existing resource in storage.
     */
    public function update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name,'.$id,
        ]);

        if( $request->hasFile('image')){
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp'
            ]);

        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = Category::findOrFail($id);

        if ($request->lang == get_setting("DEFAULT_LANGUAGE", "en")) {
            $category->name = prelaceScript(html_entity_decode($request->name)) ;

        }
        if( $request->hasFile('image')){
            $image = $request->file('image');
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp'
            ]);

            if ($category->image != null) {
                unlink(public_path('uploads/category/' . $category->image));
            }
            $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category'), $image_name);
            $category->image = $image_name;
        }

        $slug = Str::slug(prelaceScript(html_entity_decode($request->name)), '-');
        $same_slug_count = Category::where('slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;
        $category->slug = $slug;
        $category->update();

        $category_translation = CategoryTranslation::firstOrNew(['lang' => $request->lang, 'category_id' => $category->id]);
        $category_translation->name = prelaceScript(html_entity_decode($request->name));
        $category_translation->save();

        return redirect()->route('category.list')->with('success', translate('Category has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // Category Translations Delete
        foreach ($category->category_translations as $key => $category_translation) {
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
            $category = Category::findOrFail($categoryId);
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
