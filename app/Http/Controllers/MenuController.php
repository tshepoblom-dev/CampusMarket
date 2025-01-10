<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MenuItemTranslation;
use Illuminate\Support\Facades\App;
use App\Http\Requests\MenuItemRequest;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin','pverify']);
    }

    /**
     * menu
     *
     * @param  mixed $request
     * @return Response
     */
    public function menu(Request $request)
    {

        try {

            $categories = Category::get();
            $pages = Page::get();
            $menus = Menu::get();
            $blogs = Blog::get();
            $selectedMenu = 0;
            $itemsWithChildrens = "";

            if (isset($request->id)) {
                $itemsWithChildrens = $this->getChildrens($request->id);
                $selectedMenu = $request->id;
            }
            return view('backend.menu.index', compact('categories', 'pages', 'menus', 'blogs', 'selectedMenu', 'itemsWithChildrens'));
        } catch (\Throwable $th) {
            //throw $th;

            // $th->getMessage()

            return 'Something Wrong!';
        }
    }

    /**
     * addToMenu
     *
     * @param  mixed $request
     * @return Response
     */
    public function addToMenu(Request $request)
    {
        try {

            $menuId = $request->menuId;
            if ($request->type == "custom") {
                $menuItem = MenuItem::where('menu_id', $menuId)->max('order');
                $data['title'] = $request->custom_name;
                $data['slug'] = Str::slug($request->custom_name);
                $data['menu_type'] = $request->type;
                $data['menu_id'] = $menuId;
                $data['target'] = $request->custom_link;
                $data['new_tap'] = $request->new_tap == "on" ? 1 : 0;
                $data['order'] =  $menuItem ? $menuItem += 1 : 1;
                MenuItem::create($data);
            } else {
                $ids = $request->ids;
                foreach ($ids as $id) {
                    $item =  $this->getItem($request->type, $id);
                    $menuItem = MenuItem::where('menu_id', $menuId)->max('order');
                    $data['title'] = $item['title'];
                    $data['slug'] = $item['slug'];
                    $data['menu_item_name'] = $item['title'];
                    $data['menu_type'] = $request->type;
                    $data['menu_id'] = $menuId;
                    $data['order'] =  $menuItem ? $menuItem += 1 : 1;
                    MenuItem::create($data);
                }
            }

            return response()->json(['status' => true, 'message' =>  translate('Add  Successfully')]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    /**
     * getItem
     *
     * @param  string $type
     * @param  int $id
     * @return Response
     */
    public function getItem($type, $id)
    {
        $data = [];
        switch ($type) {
            case 'category':
                $category = Category::where('id', $id)->select('id', 'name', 'slug')->first();
                $data['title'] = $category->name;
                $data['slug'] = $category->slug;

                break;
            case 'blog':

                $blog = Blog::where('id', $id)->select('title', 'slug')->first();
                $data['title'] = $blog->title;
                $data['slug'] = $blog->slug;

                break;

            case 'page':

                $page = Page::where('id', $id)->select('page_name', 'page_slug')->first();
                $data['title'] = $page->page_name;
                $data['slug'] = $page->page_slug;
                break;
        }

        return $data;
    }

    /**
     *
     * @param MenuItemRequest
     * @return Response
     */
    public function updateMenuItem(MenuItemRequest $request)
    {


        try {
            $menuItem = MenuItem::where('id', $request->id)->first();
            $menuItem->title = $request->title;

            if ($request->lang ==  get_setting("DEFAULT_LANGUAGE", "en") ||  $request->lang == "") {
                if ($menuItem->menu_type == 'custom') {
                    $menuItem->slug = Str::slug($request->title);
                }
                $menuItem->target = $request->custom_link;
                $menuItem->new_tap = $request->new_tap == "on" ? 1 : 0;
                $menuItem->update();
            } else {
                $this->translate($menuItem->id, $request);
            }

            return response()->json(['status' => true, 'message' =>  translate('Update Successfully'), 'menu' => 'menu']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'message' =>  $th->getMessage()]);
        }
    }

    /**
     * deleteMenuItem
     *
     * @param  int $id
     * @return Response
     */
    public function deleteMenuItem($id)
    {

        try {
            $menuitem = MenuItem::with('childrens')->findOrFail($id);
            if ($menuitem) {

                $menuitem->childrens()->delete();
                $menuitem->delete();
                return response()->json(['status' => true, 'message' =>  translate('Delete Successfully')]);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * storeMenuItem
     *
     * @param  mixed $request
     * @return Response
     */
    public function storeMenuItem(Request $request)
    {
        try {
            $array_menu = json_decode($request->menuItems, true);
            $count = 1;
            foreach ($array_menu as $value) {
                $menuItem = MenuItem::find($value['id']);
                $menuItem->order = $count++;
                $menuItem->parent_id = null;
                $menuItem->update();
                if (array_key_exists('children', $value))
                    $this->childMenu($value['children'],  $menuItem->id);
            }
            return response()->json(['status' => true, 'message' =>  translate('Update Successfully')]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => true, 'message' => $th->getMessage()]);
        }
    }

    /**
     * editMenuItem
     *
     * @param  int $id
     * @return Response
     */
    public function editMenuItem($id)
    {
        $menuItem =  MenuItem::find($id);
        return response(['status' => true, 'menuItem' => $menuItem]);
    }

    /**
     * childMenu
     *
     * @param  mixed $childrens
     * @param  int $parentId
     * @return Response
     */
    public function childMenu($childrens, $parentId)
    {
        $count = 1;
        foreach ($childrens as $children) {
            $menuItem = MenuItem::find($children['id']);
            $menuItem->order = $count++;
            $menuItem->parent_id = $parentId;
            $menuItem->update();

            if (array_key_exists('children', $children))
                $this->childMenu($children['children'],  $menuItem->id);
        }
    }

    /**
     * getChildrens
     *
     * @param int $menu_id
     * @param int $parent_id
     * @param string $orderBy
     * @return Response
     */
    public function getChildrens($menu_id, $parent_id = null, $orderBy = 'asc')
    {
        return MenuItem::with('childrens', 'page')
            ->where(['menu_id' => $menu_id, 'parent_id' => $parent_id])
            ->orderBy('order', $orderBy)
            ->get();
    }



    /**  menu tranlsate
     *
     *============ translate ============
     *
     * @param request
     * @return response
     */

    public function translate($id, $request)
    {
        return MenuItemTranslation::updateOrCreate(['menu_item_id' => $id, 'lang' => $request->lang], [
            'title' => $request->title,
            'lang' => App::getLocale(),
        ]);
    }
}
