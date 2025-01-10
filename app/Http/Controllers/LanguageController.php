<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class LanguageController extends Controller
{

    public function __construct()
    {
        $this->middleware(['pverify']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = translate('Languages');

        $languages = Language::paginate(10);
        return view('backend.language.index', compact('languages', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = translate('Language Information');

        return view('backend.language.create', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Validation */

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'code' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $languages = new Language;
        $languages->name = $request->name;
        $languages->code = $request->code;
        $languages->save();
        return redirect()->route('languages.list')->with('success', translate('Languages saved successfully'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page_title = translate('Update Language Information');

        $languageSingle  = Language::findOrFail($id);
        return view('backend.language.edit', compact('page_title', 'languageSingle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /** Validation */

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'code' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $languages = Language::findOrFail($id);
        $languages->name = $request->name;
        $languages->code = $request->code;
        $languages->update();
        return redirect()->route('languages.list')->with('success', translate('Languages updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $languages = Language::findOrFail($id);
        if (get_setting('DEFAULT_LANGUAGE', 'en') == $languages->code) {
            return back()->with('error', 'Default language can not be deleted.');
        } else {
            if ($languages->code == Session::get('locale')) {
                Session::put('locale', get_setting('DEFAULT_LANGUAGE', 'en'));
            }
            Language::destroy($id);
            return back()->with('success', translate('Language deleted successfully'));
        }
    }

    /**
     * changeStatus
     *
     * @param  mixed $request
     * @return Response
     */
    public function changeStatus(Request $request)
    {
        $languages = Language::find($request->languageId);
        $languages->rtl = $request->status;
        if ($languages->update()) {
            $response = array('output' => 'success', 'statusId' => $languages->rtl);
            return response()->json($response);
        }
    }

    /**
     * translations
     *
     * @param  mixed $request
     * @param  int $id
     * @return Response
     */
    public function translations(Request $request, $id)
    {
        $page_title = translate('Translation');
        $sort_search = null;
        $language = Language::findOrFail($id);
        $lang_keys = Translation::where('lang', get_setting('DEFAULT_LANGUAGE', 'en'));
        if ($request->has('search')) {
            $sort_search = $request->search;
            $lang_keys = $lang_keys->where('lang_key', 'like', '%' . $sort_search . '%');
        }
        $lang_keys = $lang_keys->paginate(50);
        return view('backend.language.translation', compact('language', 'lang_keys', 'sort_search', 'page_title'));
    }

    /**
     * key_value_store
     *
     * @param  mixed $request
     * @param  int $id
     * @return Response
     */
    public function key_value_store(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        foreach ($request->values as $key => $value) {
            $translation_def = Translation::where('lang_key', $key)->where('lang', $language->code)->latest()->first();
            if ($translation_def == null) {
                $translation_def = new Translation;
                $translation_def->lang = $language->code;
                $translation_def->lang_key = $key;
                $translation_def->lang_value = $value;
                $translation_def->save();
            } else {
                $translation_def->lang_value = $value;
                $translation_def->save();
            }
        }
        Cache::forget('translations-' . $language->code);
        return back()->with('success', translate('Translations updated for ') . $language->name);
    }

    /**
     * changeLanguage
     *
     * @param  mixed $request
     * @return Response
     */
    public function changeLanguage(Request $request)
    {
        $request->session()->put('locale', $request->locale);
        $language = Language::where('code', $request->locale)->first();
        $response = array('output' => 'success', 'message' => translate('Language changed to ') . $language->name);
        return response()->json($response);
    }
}
