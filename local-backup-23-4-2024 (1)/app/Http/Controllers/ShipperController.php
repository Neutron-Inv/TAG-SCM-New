<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Shippers, Log, NgState, Country, Employers};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ShipperRepository;
use Illuminate\Support\Facades\Gate;

class ShipperController extends Controller
{
    protected $model;
    public function __construct(Shippers $shipper)
    {
        // set the model
        $this->model = new ShipperRepository($shipper);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Shipper|Employer|HOD']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $shipper = Shippers::orderBy('shipper_name', 'asc')->get();
            $company = Companies::orderBy('company_name', 'asc')->get();
            $ng_states = NgState::orderby('name', 'asc')->get();
            $countries = Country::orderby('name', 'asc')->get();
            return view('dashboard.shippers.index')->with([
                'company' => $company, "shipper" => $shipper, "ng_states" => $ng_states, "countries" => $countries
            ]);
        }elseif(Auth::user()->hasRole('Admin')){

            $company = Companies::where('email', Auth::user()->email)->first();
            $shipper = Shippers::where('company_id', $company->company_id)->orderBy('shipper_name', 'asc')->get();
            $ng_states = NgState::orderby('name', 'asc')->get();
            $countries = Country::orderby('name', 'asc')->get();
            return view('dashboard.shippers.index')->with([
                'company' => $company, "shipper" => $shipper, "ng_states" => $ng_states, "countries" => $countries

            ]);
        }elseif(auth()->user()->hasRole('Employer') OR (auth()->user()->hasRole('HOD'))){

            $user = User::where('email', Auth::user()->email)->first();
            $employee = Employers::where('email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $employee->company_id)->first();
            $shipper = Shippers::where('company_id', $company->company_id)->orderBy('shipper_name', 'asc')->get();
            return view('dashboard.shippers.index')->with([
                'company' => $company, "shipper" => $shipper,

            ]);
        }elseif(Auth::user()->hasRole('Shipper')){


            // $shipper = Shippers::where('email',  Auth::user()->email)->first();
            $shipper = Shippers::where('contact_email',  Auth::user()->email)->get();
            // $company = Companies::where('company_id',$shipper->company_id)->get();
            return view('dashboard.shippers.index')->with([
               "shipper" => $shipper,
            //    "company" => $company

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
            $shipper = Shippers::orderBy('shipper_name', 'asc')->get();
            $role = 'Shipper';
            foreach ($shipper as $clients) {
                $cut = explode(" ", $clients->shipper_name);
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
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

            $this->validate($request, [
                'company_id' => ['required', 'string', 'max:199'],
                'shipper_name' => ['required', 'string', 'max:199', 'unique:shippers'],
                'address' => ['required', 'string', 'max:199'],
                'contact_name' => ['required', 'string', 'max:199'],
                'country_code' => ['required', 'string', 'max:199'],
                'contact_phone' => ['required', 'string', 'max:20', 'unique:shippers'],
                'contact_email' => ['required', 'email', 'max:199', 'unique:shippers'],
            ]);

            if(User::where('email', $request->input('contact_email'))->exists()){
                return redirect()->back()->with([
                    'error' => $request->input('email') ." is in use by another user on the system",
                ]);
            }else{

                $data = new Shippers([
                    "company_id" => $request->input("company_id"),
                    "shipper_name" => $request->input("shipper_name"),
                    "address" => $request->input("address"),
                    "contact_name" => $request->input("contact_name"),
                    "country_code" => strtoupper($request->input("country_code")),
                    "contact_phone" => $request->input("contact_phone"),
                    "contact_email" => $request->input("contact_email"),

                ]);

                $role = 'Shipper';

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Added ' . $request->input('contact_email') . ' details as a shipper ',
                ]);

                $cut = explode(" ", $request->input("shipper_name"));
                $first_name = $cut[0];
                $last_name = $cut[1];


                $datum = new User([

                    "email" => $request->input("contact_email"),
                    "last_name" => $last_name,
                    "password" => Hash::make($request->input("contact_email")),
                    "first_name" => $first_name,
                    "phone_number" => $request->input("contact_phone"),
                    "user_activation_code" => 1, "role" => $role
                ]);

                if ($data->save() and ($log->save()) AND ($datum->save())) {
                    $datum->assignRole($role);
                    return redirect()->route("shipper.index")->with("success", "You Have Added " . $request->input("shipper_name") . " Successfully");
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
    public function edit($shipper_id)
    {
        if(Shippers::where('shipper_id', $shipper_id)->exists()){
            $ship = $this->model->show($shipper_id);
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $shipper = Shippers::orderBy('shipper_name', 'asc')->get();

                $company = Companies::orderBy('company_name', 'asc')->get();
                return view('dashboard.shippers.edit')->with([
                    'company' => $company, "shipper" => $shipper, "ship" => $ship,
                ]);
            }elseif(Auth::user()->hasRole('Admin')){

                $company = Companies::where('email', Auth::user()->email)->first();
                $shipper = Shippers::where('company_id', $company->company_id)->orderBy('shipper_name', 'asc')->get();
                return view('dashboard.shippers.edit')->with([
                    'company' => $company, "shipper" => $shipper, "ship" => $ship,
                ]);
            }elseif(Auth::user()->hasRole('Shipper')){
                $ship = Shippers::where('contact_email',  Auth::user()->email)->first();
                $shipper = Shippers::where('contact_email',  Auth::user()->email)->get();
                $company = Companies::where('company_id',$ship->company_id)->first();
                return view('dashboard.shippers.edit')->with([
                    'company' => $company, "shipper" => $shipper, "ship" => $ship,
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$shipper_id does not Exist for any Shipper",
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
    public function update(Request $request, $shipper_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Shipper'))){

            $this->validate($request, [
                'company_id' => ['required', 'string', 'max:199'],
                'shipper_name' => ['required', 'string', 'max:199'],
                'address' => ['required', 'string', 'max:199'],
                'contact_name' => ['required', 'string', 'max:199'],
                'country_code' => ['required', 'string', 'max:199'],
                'contact_phone' => ['required', 'string', 'max:20',],
                'contact_email' => ['required', 'email', 'max:199',],
            ]);



            $data = ([
                "shipper" => $this->model->show($shipper_id),
                "company_id" => $request->input("company_id"),
                "shipper_name" => $request->input("shipper_name"),
                "address" => $request->input("address"),
                "contact_name" => $request->input("contact_name"),
                "country_code" => strtoupper($request->input("country_code")),
                "contact_phone" => $request->input("contact_phone"),
                "contact_email" => $request->input("contact_email"),

            ]);

            $role = 'Shipper';

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Added ' . $request->input('contact_email') . ' details as a shipper ',
            ]);

            $cut = explode(" ", $request->input("shipper_name"));
            $first_name = $cut[0];
            $last_name = $cut[0];

            if(User::where('email', $request->input('contact_email'))->exists()){

                $user = User::where('email',$request->input('contact_email'))->first();
                // $user_id = $user->user_id;
                $datu = User::where('user_id', $user->user_id)->update([
                    "email" => $request->input("contact_email"),
                    "last_name" => $last_name,
                    "password" => Hash::make($request->input("contact_email")),
                    "first_name" => $request->input('contact_name'),
                    "phone_number" => $request->input("contact_phone"),
                    "user_activation_code" => 1, "role" => $role
                ]);

                if ($this->model->update($data, $shipper_id) and ($log->save()) AND (!empty($datu))) {
                    return redirect()->route("shipper.index")->with("success", "You Have Updated "
                        . $request->input("shipper_name"));
                } else {
                    return redirect()->back()->with("error", "Operation failed, Please Try again later");
                }

            }else{
                $datum = new User([

                    "email" => $request->input("contact_email"),
                    "last_name" => $last_name,
                    "password" => Hash::make($request->input("contact_email")),
                    "first_name" => $request->input('contact_name'),
                    "phone_number" => $request->input("contact_phone"),
                    "user_activation_code" => 1, "role" => $role
                ]);

                if ($this->model->update($data, $shipper_id) and ($log->save()) AND ($datum->save())) {
                    $datum->assignRole($role);
                    return redirect()->route("shipper.index")->with("success", "You Have Updated " . $request->input("shipper_name") . " Successfully");
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($shipper_id)
    {
        if(Shippers::where('shipper_id', $shipper_id)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

                $cli = $this->model->show($shipper_id);
                $user = User::where('email', $cli->contact_email)->get();
                if(count($user)>0){

                    // Delete from both tables
                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Deleted Shipper ' . $cli->contact_email,
                    ]);
                    $user = User::where('email', $cli->contact_email)->first();
                    if (($cli->delete($shipper_id)) and ($cli->trashed()) AND ($user->delete($user->user_id)) and ($user->trashed())) {
                        return redirect()->back()->with([
                            'success' => "You Have Deleted Shipper $cli->contact_email Successfully",
                        ]);
                    } else {
                        return redirect()->back()->with([
                            'error' => "Network Failure, Please Try again Later",
                        ]);
                    }
                }else{

                    //Delete from Single Table
                    if (($cli->delete($shipper_id)) and ($cli->trashed())) {
                        return redirect()->back()->with([
                            'success' => "You Have Deleted Shipper $cli->contact_email Successfully",
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
            'error' => "$shipper_id does not Exist for any Shipper",
            ]);
        }
    }
}
