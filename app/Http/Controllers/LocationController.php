<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LocationController extends Controller
{

    public function __construct()
    {
        //$this->middleware(['auth', 'admin','pverify']);
        $this->middleware(['auth', 'pverify']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = translate('Country');
        if ($request->search) {
            $countries = Location::whereNull('country_id')->whereNull('state_id')->where('name', 'LIKE', '%' . $request->search . '%')->orWhere('country_code', 'LIKE', '%' . $request->search . '%')->orderBy('name', 'asc')->paginate(10);
        } else {
            $countries = Location::whereNull('country_id')->whereNull('state_id')->orderBy('name', 'asc')->paginate(10);
        }

        return view('backend.location.index', compact('page_title', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'country_code' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $country = new Location;
        $country->name = $request->name;
        $country->country_code = $request->country_code;
        $country->save();

        return redirect()->back()->with('success', translate('Country saved successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $page_title = translate('Country');
        $countrySingle = Location::findOrFail($id);
        if ($request->search) {
            $countries = Location::whereNull('country_id')->whereNull('state_id')->where('name', 'LIKE', '%' . $request->search . '%')->orWhere('country_code', 'LIKE', '%' . $request->search . '%')->orderBy('name', 'asc')->paginate(10);
        } else {
            $countries = Location::whereNull('country_id')->whereNull('state_id')->orderBy('name', 'asc')->paginate(10);
        }

        return view('backend.location.country_edit', compact('page_title', 'countries', 'countrySingle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'country_code' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $country = Location::findOrFail($id);
        $country->name = $request->name;
        $country->country_code = $request->country_code;
        $country->update();

        return redirect()->back()->with('success', translate('Country updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Location::where('country_id', $id)->delete();
        Location::where('id', $id)->delete();

        return redirect()->back()->with('success', translate('Country deleted successfully'));
    }

    /**
     * get_state
     *
     * @param  mixed $request
     * @return Response
     */
    public function get_state(Request $request)
    {
        $data['states'] = Location::where('country_id', $request->country_id)->where('state_id', null)->get(['name', 'id']);
        $data['option'] = translate('Select Option');

        return response()->json($data);
    }

    /**
     * get_city
     *
     * @param  mixed $request
     * @return Response
     */
    public function get_city(Request $request)
    {
        $data['city'] = Location::whereNotNull('country_id')->where('state_id', $request->state_id)->get(['name', 'id']);
        $data['option'] = translate('Select Option');

        return response()->json($data);
    }


    /**
     * state_create
     *
     * @param  mixed $request
     * @param  int $id
     * @return view
     */
    public function state_create(Request $request, $id)
    {
        $page_title = translate('Create State');
        $countrySingle = Location::findOrFail($id);
        if ($request->search) {
            $states = Location::where('country_id', $id)->whereNull('state_id')->where('name', 'LIKE', '%' . $request->search . '%')->orderBy('name', 'asc')->paginate(10);
        } else {
            $states = Location::where('country_id', $id)->whereNull('state_id')->orderBy('name', 'asc')->paginate(10);
        }

        return view('backend.location.state_create', compact('page_title', 'states', 'countrySingle'));
    }


    /**
     * state_store
     *
     * @param  mixed $request
     * @param  int $id
     * @return Response
     */
    public function state_store(Request $request, $id)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $states = new Location;
        $states->name = $request->name;
        $states->country_id = $id;
        $states->save();

        return redirect()->back()->with('success', translate('State saved successfully'));
    }

    /**
     * Show the form for editing the specified state.
     */
    public function state_edit(Request $request, $id)
    {
        $page_title = translate('State');
        $stateSingle = Location::findOrFail($id);
        if ($request->search) {
            $states = Location::where('country_id', $stateSingle->country_id)->whereNull('state_id')->where('name', 'LIKE', '%' . $request->search . '%')->orderBy('name', 'asc')->paginate(10);
        } else {
            $states = Location::where('country_id', $stateSingle->country_id)->whereNull('state_id')->orderBy('name', 'asc')->paginate(10);
        }

        return view('backend.location.state_edit', compact('page_title', 'states', 'stateSingle'));
    }

    /**
     * Update the specified state in storage.
     */
    public function state_update(Request $request, $id)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $states = Location::findOrFail($id);
        $states->name = $request->name;
        $states->update();

        return redirect()->back()->with('success', translate('State updated successfully'));
    }

    /**
     * Remove the specified state from storage.
     */
    public function state_destroy($id)
    {
        Location::where('state_id', $id)->delete();
        Location::where('id', $id)->delete();

        return redirect()->back()->with('success', translate('State deleted successfully'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function city_create(Request $request, $id)
    {
        $page_title = translate('Create City');
        $stateSingle = Location::findOrFail($id);
        if ($request->search) {
            $cities = Location::where('state_id', $id)->where('name', 'LIKE', '%' . $request->search . '%')->orderBy('name', 'asc')->paginate(10);
        } else {
            $cities = Location::where('state_id', $id)->orderBy('name', 'asc')->paginate(10);
        }

        return view('backend.location.city_create', compact('page_title', 'cities', 'stateSingle'));
    }

    /**
     * Store a newly created city in storage.
     */
    public function city_store(Request $request, $id)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $states = Location::findOrFail($id);
        $city = new Location;
        $city->name = $request->name;
        $city->country_id = $states->country_id;
        $city->state_id = $id;
        $city->save();

        return redirect()->back()->with('success', translate('City saved successfully'));
    }

    /**
     * Show the form for editing the specified city.
     */
    public function city_edit(Request $request, $id)
    {
        $page_title = translate('City');
        $citySingle = Location::findOrFail($id);
        if ($request->search) {
            $cities = Location::where('state_id', $citySingle->state_id)->where('name', 'LIKE', '%' . $request->search . '%')->orderBy('name', 'asc')->paginate(10);
        } else {
            $cities = Location::where('state_id', $citySingle->state_id)->orderBy('name', 'asc')->paginate(10);
        }

        return view('backend.location.city_edit', compact('page_title', 'cities', 'citySingle'));
    }

    /**
     * Update the specified city in storage.
     */
    public function city_update(Request $request, $id)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $city = Location::findOrFail($id);
        $city->name = $request->name;
        $city->update();

        return redirect()->back()->with('success', translate('City updated successfully'));
    }

    /**
     * Remove the specified city from storage.
     */
    public function city_destroy($id)
    {
        Location::where('id', $id)->delete();

        return redirect()->back()->with('success', translate('City deleted successfully'));
    }
}
