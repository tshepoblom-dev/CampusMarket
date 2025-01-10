<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Widget;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WidgetContent;
use App\Models\PageTranslation;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Facades\File;
use App\Models\WidgetContentTranslation;
use Illuminate\Support\Facades\Validator;



class PageController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'admin','pverify']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::orderBy('id', 'desc')->paginate(10);
        $page_title = 'Page List';
        return view('backend.pages.index', compact('pages', 'page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'page_name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $pages = new Page;
        $pages->page_name = prelaceScript(html_entity_decode($request->page_name));
        $slug = Str::slug(prelaceScript(html_entity_decode($request->page_name)), '-');
        $same_slug_count = Page::where('page_slug', 'LIKE', $slug . '%')->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;

        $pages->page_slug = $slug;
        $pages->save();

        return redirect()->back()->with('success', translate('Page saved successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {

        $page = Page::with('widgetContents.widget', 'widgetContents.widgetTranslations')->find($id);
        $page_title = $page->page_name;
        $lang = $request->lang;
        $widgetList = Widget::orderBy('id', 'asc')->get();
        return view('backend.pages.edit', compact('page', 'widgetList', 'page_title', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'page_name' => 'required|max:255',
                'page_slug' => 'required|unique:pages,page_slug,' . $request->id,
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            if ($request->lang ==  get_setting("DEFAULT_LANGUAGE", "en") ||  $request->lang == "") {
                Page::updateOrCreate(
                    ['id' => isset($request->id) ?  $request->id : ''],
                    [
                        'page_name' => prelaceScript(html_entity_decode($request->page_name)),
                        'page_slug' => prelaceScript(html_entity_decode( $request->page_slug)),
                        'meta_title' => $request->meta_title,
                        'meta_description' => str_replace('script', '', prelaceScript(html_entity_decode($request->meta_description))) ,
                        'meta_keyward' => $request->meta_keyward,
                        'enable_seo' => $request->enable_seo == "on" ? 1 : "",
                        'is_bread_crumb' => $request->is_bread_crumb == "on" ? 1 : 0,
                    ]
                );
            } else {
                $this->translate($request);
            }


            return  response()->json(['status' => true, 'message' => 'Update Successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            return  response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pages = Page::with('widgetContents')->findOrFail($id);

        if ($pages->delete()) {
            $pages->widgetContents()->delete();
        }
        return back()->with('success', translate('Page deleted successfully'));
    }

    /**
     * changeStatus
     *
     * @return Response
     */
    public function changeStatus()
    {
        $status         = $_POST['status'];
        $pageId     = $_POST['pageId'];

        if ($status && $pageId) {
            $pages = Page::findOrFail($pageId);
            if ($status == 1) {
                $pages->status = 2;
                $message = translate('Page Inactive');
            } else {
                $pages->status = 1;
                $message = translate('Page Active');
            }
            if ($pages->update()) {
                $response = array('output' => 'success', 'statusId' => $pages->status, 'pageId' => $pages->id, 'message' => $message, 'active' => translate('Active'), 'inactive' => translate('Inactive'));
                return response()->json($response);
            }
        }
    }

    /**
     * getWidgetContent
     *
     * @return View
     */
    public function getWidgetContent()
    {

        $posts              = $_REQUEST;
        $random             = substr(md5(mt_rand()), 0, 7);
        $singlePageData     = Page::find($_REQUEST['pageId']);

        /*---Page Content Update------*/
        $widgetContentUpdate = $random;
        if ($singlePageData->widget_content_code) {
            $widgetContentUpdate = $singlePageData->widget_content_code . ',' . $random;
        }
        $singlePageData->widget_content_code = $widgetContentUpdate;
        $singlePageData->update();

        /*---Create content card------*/
        $singleWidgetContentModel = new WidgetContent;
        $singleWidgetContentModel->page_id          = $posts['pageId'];
        $singleWidgetContentModel->widget_slug      = $posts['slug'];
        $singleWidgetContentModel->ui_card_number   = $random;
        $singleWidgetContentModel->save();

        return view('backend.pages.widgets.' . $_REQUEST['slug'] . '', ['posts' => $posts, 'randomId' => $random]);
    }


    /** =========== widget added to page ===========
     * =========== widgetAddedToPage ===========
     *
     * @param string slug (widget_slug)
     * @return Response
     */

    public function widgetAddedToPage($slug)
    {

        $pageId = Request()->pageId;
        $widgetName = Request()->widgetName;
        $randomId = substr(md5(mt_rand()), 0, 7);;
        $content = view('backend.pages.widgets.' . $slug, compact('randomId', 'pageId', 'slug', 'widgetName'))->render();
        $this->storeWidgetByPage($pageId, $randomId, $slug);
        return  response()->json(['content' => $content, 'pageId' => $pageId, 'status' => true, 'message' => 'Add Successfully']);
    }


    /** widget update by page
     * ===========  widgetUpdateByPage =============
     *
     * @param mix Request
     * @return Response
     */
    public function widgetUpdateByPage(Request $request)
    {

        
        try {

            $widgetsContent = WidgetContent::where('ui_card_number', $request->ui_card_number)->where('widget_slug', $request->widget_slug)->first();

            if ($request->lang ==  get_setting("DEFAULT_LANGUAGE", "en") ||  $request->lang == "") {

                $widgetsContent->ui_card_number = $request->ui_card_number;
                $widgetsContent->widget_slug = $request->widget_slug;
                $widgetsContent->page_id = $request->page_id;
                $widgetsContent->widget_content = isset($request->content[0]) ? Purifier::clean( $request->content[0] , array('Attr.EnableID' => true)) : null;
                $widgetsContent->update();
            } else {
                $this->widgetTranslate($widgetsContent->id, $request);
            }



            return  response()->json(['status' => true, 'message' => 'Update Successfully']);
        } catch (\Throwable $th) {
            return  response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }


    /** status change
     * ======= statusChange ========
     *
     * @param  int id
     * @return Response
     */

    public function widgetStatusChange($id)
    {
        try {
            $result = WidgetContent::where('id', $id)->orWhere('ui_card_number', $id)->first();
            $result->status = $result->status == 1 ? 0 : 1;
            $result->update();
            return  response()->json(['status' => true,  'message' => translate('Status Change Successfully')]);
        } catch (\Throwable $th) {

            return  response()->json(['status' => false, 'message' => translate('Something Wrong!')]);
        }
    }

    /** widget delete by page
     * ======= statusChange ========
     *
     * @param  int id
     * @return Response
     */

    public function widgetDeleteByPage($id)
    {
        try {
            $result = WidgetContent::where('id', $id)->orWhere('ui_card_number', $id)->first();
            if ($result->delete()) {
                return  response()->json(['status' => true,  'message' => translate('Widget Delete Successfully')]);
            }
        } catch (\Throwable $th) {
            return  response()->json(['status' => false, 'message' => translate('Something Wrong!')]);
        }
    }


    /** sorted widget
     *======== widgetSortedByPage ==============
     *
     * @param Request
     * @return Response
     */

    public function widgetSortedByPage(Request $request)
    {

        try {
            if (isset($request->content)) {
                $count = 0;
                foreach ($request->content as  $slug) {
                    $key = key($slug);
                    $value = $slug[$key];
                    $count++;
                    if ($widgetsContent = WidgetContent::where('ui_card_number', $key)->where('widget_slug', $value)->first()) {
                        $widgetsContent->position = $count;
                        $widgetsContent->update();
                    } else {
                        $this->storeWidgetByPage($request->pageId, $key, $value);
                    }
                }
                return  response()->json(['status' => true,  'message' => translate('Update Successfully')]);
            }
        } catch (\Throwable $th) {
            return  response()->json(['status' => false, 'message' => translate('Something Wrong!')]);
        }
    }

    /** store widget to page
     * =========== storeWidgetByPage ============
     *
     * @param int PageId
     * @param string randomId
     * @param  string slug {widget slug}
     * @return Response
     */
    public function storeWidgetByPage($pageId, $randomId, $slug)
    {

        $widget =  WidgetContent::where("page_id", $pageId)->select('position')->orderBy('position', 'DESC')->latest()->first();
        $widgetsContent =  new  WidgetContent();
        $widgetsContent->ui_card_number = $randomId;
        $widgetsContent->widget_slug = $slug;
        $widgetsContent->page_id = $pageId;
        $widgetsContent->position = $widget ? $widget->position += 1 : 1;
        $widgetsContent->save();
    }



    /** base64 image upload
     * ============ imageUpload ========
     *
     * @param Request
     * @return Response
     */

    public function imageUpload(Request $request)
    {

        try {
            $fileName = $this->base64ImgUpload($request->image, $file = $request->old_file ? $request->old_file : "", $folder = $request->folder);
            return response()->json(['status' => true, 'image_name' => $fileName]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }


    /**
     * base64ImgUpload
     *
     * @param  mixed $requesFile
     * @param  mixed $file
     * @param  mixed $folder
     * @return Response
     */
    public static function base64ImgUpload($requesFile, $file, $folder)
    {
        str_replace('data:image/svg+xml;base64,', '', $requesFile, $count);
        if ($count > 0) {
            $image = base64_decode(str_replace('data:image/svg+xml;base64,', '', $requesFile));
            $imageName = "egens" . "-" . Str::random(10) . '.svg';
        } else {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $requesFile));
            $imageName = "egens" . "-" . Str::random(10) . '.webp';
        }
        if ($file != "") {

            if (File::exists(public_path($folder . $file))) {
                File::delete(public_path($folder . $file));
            }
        }
        file_put_contents(public_path() . $folder . $imageName, $image);
        return  $imageName;
    }



    /**  Page tranlsate
     *
     *============ translate ============
     *
     * @param request
     * @return response
     */

    public function translate($request)
    {
        return PageTranslation::updateOrCreate(['page_id' => $request->id, 'lang' => $request->lang], [
            'page_name' => prelaceScript(html_entity_decode($request->page_name)),
            'page_slug' => prelaceScript(html_entity_decode( $request->page_slug)),
            'meta_title' => $request->meta_title,
            'meta_description' => str_replace('script', '', prelaceScript(html_entity_decode($request->meta_description))) ,
            'meta_keyward' => $request->meta_keyward,

        ]);
    }


    /**  widget tranlsate
     *
     *============ translate ============
     *
     * @param request
     * @return response
     */

    public function widgetTranslate($id, $request)
    {
        return WidgetContentTranslation::updateOrCreate(['widget_content_id' => $id, 'lang' => $request->lang], [
            'page_id' => $request->page_id,
            'widget_content_id' => $id,
            'widget_content' => isset($request->content[0]) ? $request->content[0] : null,
        ]);
    }
}
