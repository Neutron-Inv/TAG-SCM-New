<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Vendors, Log, VendorContact};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\VendorContactRepository;
use Illuminate\Support\Facades\Gate;
class VendorContactController extends Controller
{
    protected $model;
    public function __construct(VendorContact $contact)
    {
        // set the model
        $this->model = new VendorContactRepository($contact);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Client|Employer|HOD']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($vendor_id)
    {
        if(Vendors::where('vendor_id', $vendor_id)->exists()){
            $ven = Vendors::where('vendor_id', $vendor_id)->first();
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $contact = VendorContact::where('vendor_id', $ven->vendor_id)->orderBy('first_name', 'asc')->get();
                $company = Companies::orderBy('company_name','asc')->get();
                return view('dashboard.supplier.contact')->with([
                    'contact' => $contact, "company" => $company, "ven" => $ven
                ]);
            }elseif(Auth::user()->hasRole('Admin')){

                $company = Companies::where('email', Auth::user()->email)->first();
                $contact = VendorContact::where('vendor_id', $ven->vendor_id)->orderBy('first_name', 'asc')->get();
                return view('dashboard.supplier.contact')->with([
                    'contact' => $contact, "company" => $company, "ven" => $ven
                ]);
            }elseif(Auth::user()->hasRole('Employer')){

                $company = Companies::where('email', Auth::user()->email)->first();
                $contact = VendorContact::where('vendor_id', $ven->vendor_id)->orderBy('first_name', 'asc')->get();
                return view('dashboard.supplier.contact')->with([
                    'contact' => $contact, "company" => $company, "ven" => $ven
                ]);
            }elseif(Auth::user()->hasRole('HOD')){

                $company = Companies::where('email', Auth::user()->email)->first();
                $contact = VendorContact::where('vendor_id', $ven->vendor_id)->orderBy('first_name', 'asc')->get();
                return view('dashboard.supplier.contact')->with([
                    'contact' => $contact, "company" => $company, "ven" => $ven
                ]);
            }elseif(Auth::user()->hasRole('Client')){

                $client = Vendors::where('email', Auth::user()->email)->first();
                $company = Companies::where('company_id', $client->vendor_id)->first();
                $contact = VendorContact::where('vendor_id', $ven->vendor_id)->orderBy('first_name', 'asc')->get();
                return view('dashboard.supplier.contact')->with([
                    'contact' => $contact, "company" => $company, "ven" => $ven
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$vendor_id does not Exist for any Client Contact",
            ]);
        }
    }

    public function list()
    {

        if (Gate::allows('SuperAdmin', auth()->user())) {
            $contact = VendorContact::orderBy('first_name', 'asc')->get();
            return view('dashboard.supplier.contact_list')->with([
                'contact' => $contact,
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
    public function store(Request $request)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer')) OR (Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('Client'))){

            $this->validate($request, [
                'vendor_id' => ['required', 'string', 'max:199'],
                'first_name' => ['required', 'string', 'max:199'],
                'last_name' => ['required', 'string', 'max:199'],
                'job_title' => ['required', 'string', 'max:199'],
                'office_tel' => ['required', 'string', 'max:199'],
                // 'mobile_tel' => ['string', 'max:199'],
                'email' => ['nullable', 'email', 'max:199', 'unique:vendor_contacts'],
                // 'email_other' => ['email', 'max:199', ],
                'address' => ['required', 'string', 'max:199'],
                'state' => ['nullable', 'string', 'max:199'],
                'city' => ['nullable', 'string', 'max:200'],
            ]);

            if(VendorContact::where('email', $request->input('email'))->exists()){
                return redirect()->back()->with([
                    'error' => $request->input('email') ." is in use by another user on the system",
                ]);
            }else{

                if(empty($request->input("email_other"))){
                    $other = $request->input("email");
                }else{
                    $other = "";
                }

                if(empty($request->input("mobile_tel"))){
                    $phone = $request->input("office_tel");
                }else{
                    $phone = $request->input("mobile_tel");
                }

                $data = new VendorContact([
                    "vendor_id" => $request->input("vendor_id"),
                    "first_name" => $request->input("first_name"),
                    "last_name" => $request->input("last_name"),
                    "job_title" => $request->input("job_title"),
                    "office_tel" => $request->input("office_tel"),
                    "mobile_tel" => $phone,
                    "email" => $request->input("email"),
                    "email_other" => $other,
                    "country_code" => $request->input("country"),
                    "state" => $request->input("state"),
                    "city" => $request->input("city"),
                    "address" => $request->input("address"),

                ]);
                $vendor = Vendors::where('vendor_id', $request->input("vendor_id"))->first();
                $role = 'Contact';

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Added ' . $request->input('email') . ' details as a Vendor Contact for '. $vendor->vendor_name,
                ]);

                // $datum = new User([

                //     "email" => $request->input("email"),
                //     "last_name" => $request->input('last_name'),
                //     "password" => Hash::make($request->input("email")),
                //     "first_name" => $request->input('first_name'),
                //     "phone_number" => $request->input("office_tel"),
                //     "user_activation_code" => 1, "role" => $role
                // ]);

                // if ($data->save() and ($log->save()) AND ($datum->save())) {
                if ($data->save() and ($log->save())) {
                    //$datum->assignRole($role);
                    return redirect()->back()->with([
                        // "email" => $client->email,
                        "success" => "You Have Added " . $request->input("first_name") . " as a Vendor Contact Successfully"
                    ]);
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
    public function edit($contact_id)
    {
        if(VendorContact::where('contact_id', $contact_id)->exists()){
            $conc = $this->model->show($contact_id);
            $vendor_id = $conc->vendor_id;
            $list = Vendors::where('vendor_id', $vendor_id)->first();
            $email = $list->email;
            $ven = Vendors::where('vendor_id', $vendor_id)->first();
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $contact = VendorContact::where('vendor_id', $ven->vendor_id)->orderBy('first_name', 'asc')->get();;
                $company = Companies::where('email', Auth::user()->email)->first();
                return view('dashboard.supplier.edit_contact')->with([
                    'contact' => $contact, "company" => $company, "ven" => $ven, 'conc' => $conc
                ]);
            }elseif(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Employer') || Auth::user()->hasRole('HOD')){

                $company = Companies::where('email', Auth::user()->email)->first();
                $contact = VendorContact::where('vendor_id', $ven->vendor_id)->orderBy('first_name', 'asc')->get();
                return view('dashboard.supplier.edit_contact')->with([
                    'contact' => $contact, "company" => $company, "ven" => $ven,  'conc' => $conc
                ]);
            }elseif(Auth::user()->hasRole('Supplier')){


                $client = Vendors::where('email', Auth::user()->email)->first();
                $company = Companies::where('company_id', $client->vendor_id)->first();
                $contact = VendorContact::where('vendor_id', $ven->vendor_id)->orderBy('first_name', 'asc')->get();
                return view('dashboard.supplier.edit_contact')->with([
                    'contact' => $contact, "company" => $company, "ven" => $ven,  'conc' => $conc
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$contact_id does not Exist for any Client Contact",
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
    public function update(Request $request, $contact_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasRole('Employer')) OR (Auth::user()->hasRole('HOD')) OR (Auth::user()->hasRole('vensor'))){

            $this->validate($request, [
                'vendor_id' => ['required', 'string', 'max:199'],
                'first_name' => ['required', 'string', 'max:199'],
                'last_name' => ['required', 'string', 'max:199'],
                'job_title' => ['required', 'string', 'max:199'],
                'office_tel' => ['required', 'string', 'max:199'],
                // 'mobile_tel' => ['required', 'string', 'max:199'],
                'email' => ['required', 'email', 'max:199',],
                // 'email_other' => ['email', 'max:199', ],
                'address' => ['required', 'string', 'max:199'],
                'state' => ['nullable', 'string', 'max:199'],
                'city' => ['nullable', 'string', 'max:200'],
            ]);

            if(empty($request->input("email_other"))){
                $other = $request->input("email");
            }else{
                $other = $request->input("email_other");
            }

            if(empty($request->input("mobile_tel"))){
                $phone = $request->input("office_tel");
            }else{
                $phone = $request->input("mobile_tel");
            }

            $data = ([
                "contact" => $this->model->show($contact_id),
                "vendor_id" => $request->input("vendor_id"),
                "first_name" => $request->input("first_name"),
                "last_name" => $request->input("last_name"),
                "job_title" => $request->input("job_title"),
                "office_tel" => $request->input("office_tel"),
                "mobile_tel" => $phone,
                "email" => $request->input("email"),
                "email_other" => $request->input("email_other"),
                "country_code" => $request->input("country"),
                "state" => $request->input("state"),
                "city" => $request->input("city"),
                "address" => $request->input("address"),

            ]);

            $vendor = Vendors::where('vendor_id', $request->input("vendor_id"))->first();
            $email = $vendor->email;
            $role = 'Contact';
            $ven = Vendors::where('vendor_id', $request->input("vendor_id"))->first();

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Added ' . $request->input('email') . ' details as a Vendor Contact for '. $vendor->vendor_name,
            ]);

            if(User::where('email', $request->input('email'))->exists()){

                $user = User::where('email',$request->input('email'))->first();
                $user_id = $user->user_id;
                $datu = User::where('user_id', $user_id)->update([
                    "email" => $request->input("email"),
                    "last_name" => $request->input('last_name'),
                    "password" => Hash::make($request->input("email")),
                    "first_name" => $request->input('first_name'),
                    "phone_number" => $request->input("office_tel"),
                    "user_activation_code" => 1, "role" => $role
                ]);

                if ($this->model->update($data, $contact_id) and ($log->save()) AND (!empty($datu))) {
                    
                    if (Gate::allows('SuperAdmin', auth()->user())) {
                        return redirect()->back()->with([
                            "success" => "You Have Updated " . $request->input("first_name") . " Details Successfully",
                        ]);

                    }else{

                        return redirect()->back()->with([
                            "success" => "You Have Updated " . $request->input("first_name") . " Details Successfully",

                        ]);

                    }

                } else {
                    return redirect()->back()->with("error", "Operation failed, Please Try again later");

                }


            }else{

                $datum = new User([

                    "email" => $request->input("email"),
                    "last_name" => $request->input('last_name'),
                    "password" => Hash::make($request->input("email")),
                    "first_name" => $request->input('first_name'),
                    "phone_number" => $request->input("office_tel"),
                    "user_activation_code" => 1, "role" => $role
                ]);

                if ($this->model->update($data, $contact_id) and ($log->save()) AND ($datum->save())) {
                    $datum->assignRole($role);

                    if (Gate::allows('SuperAdmin', auth()->user())) {
                        
                        return redirect()->back()->with([
                            "success", "You Have Updated " . $request->input("first_name") . " Details Successfully",

                        ]);

                    }else{

                        return redirect()->back()->with([
                            "success", "You Have Updated " . $request->input("first_name") . " Details Successfully"
                        ]);

                    }
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
    public function destroy($contact_id)
    {
        if(VendorContact::where('contact_id', $contact_id)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

                $conc = $this->model->show($contact_id);
                $vendor_id = $conc->vendor->vendor_id;
                $user = User::where('email', $conc->email)->get();
                if(count($user)>0){

                    // Delete from both tables
                   
                    $user = User::where('email', $conc->email)->first();
                    if (($conc->delete($contact_id)) and ($conc->trashed()) AND ($user->delete($user->user_id)) and ($user->trashed())) {
                         
                         $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Deleted Supplier Contact ' . $conc->email,
                        ]);
                        
                        return redirect()->route('vcontact.index',$vendor_id)->with([
                            'success' => "You Have Deleted Supplier Contact $conc->email Successfully",
                        ]);
                    } else {
                        return redirect()->back()->with([
                            'error' => "Network Failure, Please Try again Later",
                        ]);
                    }
                }else{

                    //Delete from Single Table
                    if (($conc->delete($contact_id)) and ($conc->trashed())) {
                        return redirect()->route('vcontact.index',$vendor_id)->with([
                            'success' => "You Have Deleted Supplier Contact $conc->email Successfully",
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
            'error' => "$contact_id does not Exist for any Supplier Contact",
            ]);
        }
    }

    public function loading()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $client = VendorContact::orderBy('first_name', 'asc')->get();
            $role = 'Contact';
            foreach ($client as $Vendors) {
                if(empty($Vendors->email)){
                    $first_name = $Vendors->first_name;
                    $last_name = $Vendors->last_name;
                    $email = "lorem-ipsum-contact-" . substr(str_shuffle("0123456789"), 0, 4);
                    $cont = VendorContact::where('contact_id', $Vendors->contact_id)->update([
                        "email" => $email,
                    ]);

                    if(User::where('email', $email)->exists()){
                        $user = User::where('email', $email)->first();
                        $datu = User::where('user_id', $user->user_id)->update([
                            "email" => $email,
                            "role" => $user->role,
                            "last_name" => $last_name,
                            "first_name" => $first_name,
                            "status" => $user->status,
                            "phone_number" => $user->phone_number,
                        ]);
                        $user->assignRole($role);
                        $log = new Log([
                            "user_id" => Auth::user()->user_id,
                            "activities" => 'Updated ' . $email . ' details in the user table',
                        ]);
                    }else{

                        $log = new Log([
                            "user_id" => Auth::user()->user_id,
                            "activities" => 'Added ' . $email . ' details in the user table',
                        ]);

                        $first_name = $Vendors->first_name;
                        $last_name = $Vendors->last_name;
                        $create = new User([
                            "email" => $email,
                            "last_name" => $last_name,
                            "password" => Hash::make('password'),
                            "first_name" => $first_name,
                            "phone_number" => $Vendors->office_tel,
                            "user_activation_code" =>0,
                            "status" => 0,
                            "role" => $role
                        ]);
                        $create->save();
                        $create->assignRole($role);
                    }

                }else{

                    $first_name = $Vendors->first_name;
                    $last_name = $Vendors->last_name;
                    if(User::where('email', $Vendors->email)->exists()){
                        $user = User::where('email', $Vendors->email)->first();
                        $datu = User::where('user_id', $user->user_id)->update([
                            "email" => $Vendors->email,
                            "role" => $user->role,
                            "last_name" => $last_name,
                            "first_name" => $first_name,
                            "status" => $user->status,
                            "phone_number" => $user->phone_number,
                        ]);
                        $user->assignRole($role);
                        $log = new Log([
                            "user_id" => Auth::user()->user_id,
                            "activities" => 'Updated ' . $Vendors->email . ' details in the user table',
                        ]);
                    }else{

                        $log = new Log([
                            "user_id" => Auth::user()->user_id,
                            "activities" => 'Added ' . $Vendors->email . ' details in the user table',
                        ]);

                        $create = new User([
                            "email" => $Vendors->email,
                            "last_name" => $last_name,
                            "password" => Hash::make('password'),
                            "first_name" => $first_name,
                            "phone_number" => $Vendors->office_tel,
                            "user_activation_code" =>0,
                            "status" => 0,
                            "role" => $role
                        ]);
                        $create->save();
                        $create->assignRole($role);
                    }
                }

            }
            return redirect()->back()->with([
                'success' => "Details Populated Successfully",
            ]);

        } else {

            return view('errors.403');
        }
    }
}
