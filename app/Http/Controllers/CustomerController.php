<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
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
        $page_title = translate('Customer List');
        if ($request->search) {
            $customers = User::where('role', 1)->where(DB::raw("concat(fname, ' ', lname)"), 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                ->orWhere('custom_id', $request->search)
                ->latest()->paginate(12);
        } else {
            $customers = User::where('role', 1)->latest()->paginate(12);
        }
        $data['total_customers'] = $this->getUserByRole(1)->count();
        $data['total_deposit'] =  $this->walletSubByStatus($type = 1, $status = 2, $userType = null);
        $data['total_pay'] =  $this->walletMultiTypeByStatus($type = [2, 3, 7], $status = 2, $userType = null);
        $data['total_pending'] =  $this->walletSubByStatus($type = 2, $status = 1, $userType = null);
        return view('backend.customer.index', compact('page_title', 'customers', 'data'));
    }

    /**
     * create Show the form for creating a new resource
     *
     * @return view
     */
    public function create()
    {
        $page_title = translate('Create Customer');
        $countries = Location::where('country_id', null)->where('state_id', null)->get();
        return view('backend.customer.create', compact('page_title', 'countries'));
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param  mixed $request
     * @return Response
     */
    public function store(Request $request)
    {
        /** Validation */
        $validator = Validator::make($request->all(), [
            'fname' => 'required|max:255',
            'lname' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email',
            'phone' => 'required|max:255|unique:users,phone',
            'address' => 'required|max:255',
            'country_id' => 'required|max:255',
            'state_id' => 'required|max:255',
            'city_id' => 'required|max:255',
            'zip_code' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username',
            'password' => 'required|confirmed|min:8',
            'image' => 'nullable|image'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customers = new User;
        /** image upload */
        $image = $request->file('image');
        if ($image != '') {
            $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/users'), $image_name);
            $customers->image = $image_name;
        }

        $users = User::where('role', 1)->orderBy('id', 'desc')->pluck('custom_id')->first();
        if ($users) {
            $numbers = substr($users, 2);
            $customer_id = 'C' . str_pad(($numbers +  1), 4, '0', STR_PAD_LEFT);
            $customers->custom_id = $customer_id;
        } else {
            $customers->custom_id = 'C0001';
        }
        $customers->fname = $request->fname;
        $customers->lname = $request->lname;
        $customers->email = $request->email;
        $customers->phone = $request->phone;
        $customers->address = $request->address;
        $customers->country_id = $request->country_id;
        $customers->state_id = $request->state_id;
        $customers->city_id = $request->city_id;
        $customers->zip_code = $request->zip_code;
        $customers->username = $request->username;
        $customers->password = Hash::make($request->password);
        $customers->save();

        return redirect()->route('customer.list')->with('success', translate('Customer saved successfully'));
    }


    /**
     * show
     *
     * @param  int $id
     * @return View
     */
    public function show($id)
    {
        $page_title = translate('Customer Profile');
        $customerSingle = User::findOrFail($id);
        $countries = Location::where('country_id', null)->where('state_id', null)->get();
        $deposits = Wallet::where('user_id', $id)->where('type', 1)->latest()->limit(15)->get();
        $orders = Order::where('user_id', $id)->latest()->limit(15)->get();
        return view('backend.customer.profile', compact('page_title', 'customerSingle', 'countries', 'deposits', 'orders'));
    }


    /**
     * edit
     *
     * @param  int $id
     * @return View
     */
    public function edit($id)
    {
        $page_title = translate('Edit Customer');
        $customerSingle = User::findOrFail($id);
        $countries = Location::where('country_id', null)->where('state_id', null)->get();
        return view('backend.customer.edit', compact('page_title', 'customerSingle', 'countries'));
    }


    /**
     * update
     *
     * @param  mixed $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $customers = User::findOrFail($id);
        /** Validation */
        $validator = Validator::make($request->all(), [
            'fname' => 'required|max:255',
            'lname' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,' . $customers->id,
            'phone' => 'required|max:255|unique:users,phone,' . $customers->id,
            'username' => 'required|max:255|unique:users,username,'.$customers->id,
            'address' => 'required|max:255',
            'country_id' => 'required|max:255',
            'state_id' => 'required|max:255',
            'city_id' => 'required|max:255',
            'zip_code' => 'required|max:255',
            'password' => 'nullable|confirmed|min:8',
            'image' => 'nullable|image'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /** image upload */
        $image = $request->file('image');
        if ($image != '') {
            if ($customers->image != null) {
                unlink(public_path('uploads/users/' . $customers->image));
            }
            $image_name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/users'), $image_name);
            $customers->image = $image_name;
        }
        $customers->fname = $request->fname;
        $customers->lname = $request->lname;
        $customers->address = $request->address;
        $customers->email = $request->email;
        $customers->phone = $request->phone;
        $customers->country_id = $request->country_id;
        $customers->state_id = $request->state_id;
        $customers->city_id = $request->city_id;
        $customers->zip_code = $request->zip_code;
        if ($request->password) {
            $customers->password = Hash::make($request->password);
        }
        $customers->update();
        return redirect()->route('customer.list')->with('success', translate('Customer has been updated successfully'));
    }


    /**
     * destroy
     *
     * @param  Int $id
     * @return Response
     */
    public function destroy($id)
    {
        $customers = User::findOrFail($id);
        if ($customers->image != null) {
            unlink(public_path('uploads/users/' . $customers->image));
        }
        $customers->delete();
        return back()->with('success', translate('Customer deleted successfully'));
    }



    /**
     * changeStatus
     *
     * @return Response
     */
    public function changeStatus()
    {
        $status         = $_POST['status'];
        $customerId     = $_POST['customerId'];

        if ($status && $customerId) {
            $customers = User::findOrFail($customerId);
            if ($status == 1) {
                $customers->status = 2;
                $message = translate('Customer Deactive');
            } else {
                $customers->status = 1;
                $message = translate('Customer Active');
            }
            if ($customers->update()) {
                $response = array('output' => 'success', 'statusId' => $customers->status, 'cusId' => $customers->id, 'message' => $message, 'active' => translate('Active'), 'deactive' => translate('Deactive'));
                return response()->json($response);
            }
        }
    }

    /**
     * login
     *
     * @param  Int $id
     * @return Response
     */
    public function login($id)
    {
        $customer = User::findOrFail(decrypt($id));
        auth()->login($customer, true);
        return redirect()->route('customer.dashboard');
    }

    /**
     * getUserByRole
     *
     * @param  mixed $role
     * @return Response
     */
    public function getUserByRole($role)
    {
        return User::where('role', $role)->get();
    }

    /**
     * walletSubByStatus
     *
     * @param  String $type
     * @param  Int $status
     * @param  Int $userType
     * @return Response
     */
    public function walletSubByStatus($type = null, $status = null, $userType = null)
    {
        $wallet =  Wallet::where('type', $type)->where('status', $status);
        if (!empty($userType)) {
            return $wallet->where('user_id', $userType)->sum('amount');
        }
        return $wallet->sum('amount');
    }

    /**
     * walletMultiTypeByStatus
     *
     * @param String $type
     * @param Int $status
     * @param Int $userType
     * @return void
     */
    public function walletMultiTypeByStatus($type = null, $status = null, $userType = null)
    {
        $wallet =  Wallet::where('status', $status)->whereIn('type', $type);
        if (!empty($userType)) {
            return $wallet->where('user_id', $userType)->sum('amount');
        }
        return $wallet->sum('amount');
    }
}
