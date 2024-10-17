<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Vendors, Log, Industries, NgState, Country, Employers};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\VendorRepository;
use Illuminate\Support\Facades\Gate;

class VendorController extends Controller
{
    protected $model;
    public function __construct(Vendors $vendor)
    {
        // set the model
        $this->model = new VendorRepository($vendor);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Supplier|Employer|HOD']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $industry = Industries::orderBy('industry_name', 'asc')->get();
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $vendor = Vendors::orderBy('vendor_name', 'asc')->get();
            $company = Companies::orderBy('company_name', 'asc')->get();
            $ng_states = NgState::orderby('name', 'asc')->get();
            $countries = Country::orderby('name', 'asc')->get();
            return view('dashboard.supplier.index')->with([
                'company' => $company, "vendor" => $vendor, 'industry' => $industry, "ng_states" => $ng_states, "countries" => $countries
            ]);
        }elseif(Auth::user()->hasRole('Admin')){

            $company = Companies::where('email', Auth::user()->email)->first();
            $vendor = Vendors::where('company_id', $company->company_id)->orderBy('vendor_name', 'asc')->get();
            $ng_states = NgState::orderby('name', 'asc')->get();
            $countries = Country::orderby('name', 'asc')->get();
            return view('dashboard.supplier.index')->with([
                'company' => $company, "vendor" => $vendor, 'industry' => $industry, "ng_states" => $ng_states, "countries" => $countries
            ]);
        }elseif(auth()->user()->hasRole('Employer') OR (auth()->user()->hasRole('HOD'))){

            $user = User::where('email', Auth::user()->email)->first();
            $employee = Employers::where('email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $employee->company_id)->first();
            $ng_states = NgState::orderby('name', 'asc')->get();
            $countries = Country::orderby('name', 'asc')->get();
            $vendor = Vendors::where('company_id', $company->company_id)->orderBy('vendor_name', 'asc')->get();
            return view('dashboard.supplier.index')->with([
                'company' => $company, "vendor" => $vendor, 'industry' => $industry, "ng_states" => $ng_states, "countries" => $countries

            ]);
        }elseif(Auth::user()->hasRole('Supplier')){
            $vendor = Vendors::where('contact_email', Auth::user()->email)->get();
            $ven = Vendors::where('contact_email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $ven->company_id)->first();
            $ng_states = NgState::orderby('name', 'asc')->get();
            $countries = Country::orderby('name', 'asc')->get();
            return view('dashboard.supplier.index')->with([
                'company' => $company, "vendor" => $vendor, 'industry' => $industry, "ng_states" => $ng_states, "countries" => $countries
            ]);
        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function load()
    {
        if (Gate::allows('SuperAdmin', auth()->user())){
            $vendor = Vendors::orderBy('vendor_name', 'asc')->get();
            $role = 'Supplier';
            foreach ($vendor as $clients) {
                $cut = explode(" ", $clients->vendor_name);
                $first_name = $cut[0];
                $last_name = (isset($cut[1])) ? $cut[1] : $cut[0];
                if(User::where('email', $clients->contact_email)->exists()){
                    $user = User::where('email', $clients->contact_email)->first();
                    $datu = User::where('user_id', $user->user_id)->update([
                        "email" => $clients->contact_email,
                        "role" => $user->role,
                        "last_name" => $last_name,
                        "first_name" => $first_name,
                        "status" => $user->status,
                        "phone_number" => $user->phone_number,
                    ]);
                    $user->assignRole($role);
                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Updated ' . $clients->contact_email . ' details in the user table',
                    ]);
                }else{

                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Added ' . $clients->contact_email . ' details in the user table',
                    ]);

                    $create = new User([
                        "email" => $clients->contact_email,
                        "last_name" => $last_name,
                        "password" => Hash::make('password'),
                        "first_name" => $first_name,
                        "phone_number" => $clients->contact_phone,
                        "user_activation_code" =>0,
                        "status" => 0,
                        "role" => $role
                    ]);
                    $create->save();
                    $create->assignRole($role);
                }
            }
            return redirect()->back()->with([
                'success' => "Details Populated Successfully",
            ]);

        }else{
            return view('errors.403');
        }
    }

    public function store(Request $request)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer')) OR (Auth::user()->hasRole('HOD'))){

            $this->validate($request, [
                'company_id' => ['required', 'string', 'max:199'],
                'vendor_name' => ['required', 'string', 'max:199', 'unique:vendors'],
                'vendor_code' => ['required', 'string', 'max:4', 'unique:vendors'],
                'industry_id' => ['required', 'integer', 'max:199'],
                'contact_name' => ['required', 'string', 'max:199'],
                'contact_phone' => ['string', 'max:20', 'unique:vendors'],
                'contact_email' => ['required', 'email', 'max:199', 'unique:vendors'],
                'country_code' => ['required', 'string', 'max:199'],
                'tamap' => ['required', 'string', 'max:199'],
                'agency' => ['required', 'string', 'max:199'],
                'description' => ['required', 'string', 'max:300'],
                'address' => ['required', 'string', 'max:199'],
            ]);

            if(User::where('email', $request->input('contact_email'))->exists()){
                return redirect()->back()->with([
                    'error' => $request->input('email') ." is in use by another user on the system",
                ]);
            }else{

                if(empty($request->input('contact_phone'))){
                    $phone = 123456789;
                }else{
                    $phone = $request->input('contact_phone');
                }

                $data = new Vendors([
                    "company_id" => $request->input("company_id"),
                    "industry_id" => strtoupper($request->input("industry_id")),
                    "vendor_name" => $request->input("vendor_name"),
                    "contact_name" => $request->input("contact_name"),
                    "contact_phone" => $phone,
                    "contact_email" => $request->input("contact_email"),
                    "country_code" => strtoupper($request->input("country_code")),
                    "tamap" => $request->input("tamap"),
                    "agency" => $request->input("agency"),
                    "description" => $request->input("description"),
                    "address" => $request->input("address"),
                    "vendor_code" => strtoupper($request->input("vendor_code")),

                ]);

                $role = 'Supplier';

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Added ' . $request->input('contact_email') . ' details as a Supplier ',
                ]);

                // Check if the input contains a space
                if (strpos($request->input("vendor_name"), ' ') !== false) {
                    // Split the input into first and last name
                    $cut = explode(" ", $request->input("vendor_name"), 2);
                    $first_name = $cut[0];
                    $last_name = $cut[1];
                } else {
                    // If no space is found, set the first name and leave the last name empty
                    $first_name = $request->input("vendor_name");
                    $last_name = ''; // Or you can set it to null or another default value
                }


                $datum = new User([

                    "email" => $request->input("contact_email"),
                    "last_name" => $last_name,
                    "password" => Hash::make($request->input("contact_email")),
                    "first_name" => $first_name,
                    "phone_number" => $phone,
                    "user_activation_code" => 1,
                    "role" => $role
                ]);

                if ($data->save() and ($log->save()) AND ($datum->save())) {
                    $datum->assignRole($role);
                    return redirect()->route("vendor.index")->with("success", "You Have Added " . $request->input("vendor_name") . " Successfully");
                } else {
                    return redirect()->back()->with("error", "Network Failure");
                }
            }



        }else{
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($vendor_id)
    {
        if(Vendors::where('vendor_id', $vendor_id)->exists()){
            $ven = Vendors::where('vendor_id', $vendor_id)->first();
            $industry = Industries::orderBy('industry_name', 'asc')->get();
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $vendor = Vendors::orderBy('vendor_name', 'asc')->get();
                $company = Companies::orderBy('company_name', 'asc')->get();

                return view('dashboard.supplier.edit')->with([
                    'company' => $company, "vendor" => $vendor, 'industry' => $industry, "ven" => $ven
                ]);
            }elseif(Auth::user()->hasRole('Admin')){

                $company = Companies::where('email', Auth::user()->email)->first();
                $vendor = Vendors::where('company_id', $company->company_id)->orderBy('vendor_name', 'asc')->get();
                return view('dashboard.supplier.edit')->with([
                    'company' => $company, "vendor" => $vendor, 'industry' => $industry, "ven" => $ven
                ]);
            }elseif(Auth::user()->hasRole('Supplier')){
                $vendor = Vendors::where('contact_email', Auth::user()->email)->get();
                $ven = Vendors::where('contact_email', Auth::user()->email)->first();
                $company = Companies::where('company_id', $ven->company_id)->first();
                return view('dashboard.supplier.edit')->with([
                    'company' => $company, "vendor" => $vendor, 'industry' => $industry, "ven" => $ven
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$vendor_id does not Exist for any Vendor",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vendor_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Supplier'))){
            $ven = Vendors::where('vendor_id', $vendor_id)->first();
            $this->validate($request, [
                'company_id' => ['required', 'string', 'max:199'],
                'vendor_name' => ['required', 'string', 'max:199'],
                'vendor_code' => ['required', 'string', 'max:4'],
                'industry_id' => ['required', 'string', 'max:199'],
                'contact_name' => ['required', 'string', 'max:199'],
                'contact_email' => ['required', 'email', 'max:199',],
                'country_code' => ['required', 'string', 'max:199'],
                'tamap' => ['required', 'string', 'max:199'],
                'agency' => ['required', 'string', 'max:199'],
                'description' => ['required', 'string', 'max:300'],
                'address' => ['required', 'string', 'max:199'],
            ]);

            if(empty($request->input('contact_phone'))){
                $phone = 123456789;
            }else{
                $phone = $request->input('contact_phone');
            }

            $data = ([
                "vendor" => Vendors::where('vendor_id', $vendor_id)->first(),
                "company_id" => $request->input("company_id"),
                "industry_id" => strtoupper($request->input("industry_id")),
                "vendor_name" => $request->input("vendor_name"),
                "contact_name" => $request->input("contact_name"),
                "contact_phone" => $phone,
                "contact_email" => $request->input("contact_email"),
                "country_code" => strtoupper($request->input("country_code")),
                "tamap" => $request->input("tamap"),
                "agency" => $request->input("agency"),
                "description" => $request->input("description"),
                "address" => $request->input("address"),
                "vendor_code" => strtoupper($request->input("vendor_code"))

            ]);

            $role = 'Supplier';

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Updated ' . $request->input('contact_email') . ' details ',
            ]);

            $cut = explode(" ", $request->input("vendor_name"));
            $first_name = $cut[0];
            $last_name = $cut[0];

            if(User::where('email', $request->input('contact_email'))->exists()){

                $user = User::where('email',$request->input('contact_email'))->first();
                $user_id = $user->user_id;
                $datu = User::where('user_id', $user_id)->update([
                    "email" => $request->input("contact_email"),
                    "last_name" => $last_name,
                    "password" => Hash::make($request->input("contact_email")),
                    "first_name" => $first_name,
                    "phone_number" => $phone,
                    "user_activation_code" => 1, "role" => $role
                ]);

                if ($this->model->update($data, $vendor_id) and ($log->save()) AND (!empty($datu))) {
                    return redirect()->route("vendor.index")->with("success", "You Have Updated "
                        . $request->input("vendor_name"));
                } else {
                    return redirect()->back()->with("error", "Operation failed, Please Try again later");
                }


            }else{

                $datum = new User([
                    "email" => $request->input("contact_email"),
                    "last_name" => $last_name,
                    "password" => Hash::make($request->input("contact_email")),
                    "first_name" => $first_name,
                    "phone_number" => $phone,
                    "user_activation_code" => 1, "role" => $role
                ]);

                if ($this->model->update($data, $vendor_id) and ($log->save()) AND ($datum->save())) {
                    $datum->assignRole($role);
                    return redirect()->route("vendor.index")->with("success", "You Have Updated "
                        . $request->input("vendor_name") . " Successfully");
                } else {
                    return redirect()->back()->with("error", "Network Failure");
                }
            }

            if ($data->save() and ($log->save()) AND ($datum->save())) {
                $datum->assignRole($role);
                return redirect()->route("vendor.index")->with("success", "You Have Added " . $request->input("vendor_name") . " Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure");
            }




        }else{
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vendor_id)
    {
        if(Vendors::where('vendor_id', $vendor_id)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

                $cli =  Vendors::where('vendor_id', $vendor_id)->first();
                $user = User::where('email', $cli->contact_email)->get();
                if(count($user)>0){

                    // Delete from both tables
                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Deleted Client Contact ' . $cli->contact_email,
                    ]);
                    $user = User::where('email', $cli->contact_email)->first();
                    if (($cli->delete($vendor_id)) and ($cli->trashed()) AND ($user->delete($user->user_id)) and ($user->trashed())) {
                        return redirect()->back()->with([
                            'success' => "You Have Deleted Vendor $cli->contact_email Successfully",
                        ]);
                    } else {
                        return redirect()->back()->with([
                            'error' => "Network Failure, Please Try again Later",
                        ]);
                    }
                }else{

                    //Delete from Single Table
                    if (($cli->delete($vendor_id)) and ($cli->trashed())) {
                        return redirect()->back()->with([
                            'success' => "You Have Deleted Vendor $cli->contact_email Successfully",
                        ]);
                    } else {
                        return redirect()->back()->with([
                            'error' => "Operation Failed, Please Try again Later",
                        ]);
                    }

                }

            }else{
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$vendor_id does not Exist for any Vendor",
            ]);
        }
    }
}
