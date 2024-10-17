<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Industries,Log, CompanyLogo};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\CompanyRepository;
use Illuminate\Support\Facades\Gate;
use DB;
class CompanyController extends Controller
{
    protected $model;
    public function __construct(Companies $company)
    {
        // set the model
        $this->model = new CompanyRepository($company);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $company = Companies::orderBy('company_name', 'asc')->get();
            return view('dashboard.companies.index')->with([
                'company' => $company,
            ]);
        } else {
            
            return view('errors.403');
        }

    }

    // $cli = $this->model->show($company_id);
    public function bin()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $company = Companies::orderBy('company_name', 'asc')->onlyTrashed()->get();
            return view('dashboard.companies.recyclebin')->with([
                'company' => $company,
            ]);
        } else {
            
            return view('errors.403');
        }
    }

    public function restore($company_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $cli = $this->model->show($company_id);
            $user = User::where('email', $cli->email)->get();
            if(count($user)>0){

                // Restore from both tables
                $user = User::where('email', $cli->email)->first();
                $us = User::withTrashed()->where('user_id', $user->user_id)->restore();
                $comp = Companies::where('company_id', $company_id)->restore();
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Restored Company ' . $cli->company_name,
                ]);

                if (!empty($comp) AND (!empty($us))) {
                    return redirect()->back()->with([
                        'success' => "You Have Restored Company $cli->company_name Successfully",
                    ]);
                } else {
                    return redirect()->back()->with([
                        'error' => "Network Failure, Please Try again Later",
                    ]);
                }
            }else{

                //Restore from Single Table
                $comp = Companies::where('company_id', $company_id)->restore();
                if (!empty($comp)){
                    return redirect()->back()->with([
                        'success' => "You Have Restored Company $cli->company_name Successfully",
                    ]);
                } else {
                    return redirect()->back()->with([
                        'error' => "Operation Failed, Please Try again Later",
                    ]);
                }

            }

        } else {
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
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $industry = Industries::orderBy('industry_name', 'asc')->get();
            return view('dashboard.companies.create')->with([
                'industry' => $industry,
            ]);
        } else {
            
            return view('errors.403');
        }


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
            $company = Companies::orderBy('company_name', 'asc')->get();
            $role = 'Admin';
            foreach ($company as $clients) {
                $cut = explode(" ", $clients->company_name);
                $first_name = $cut[0];
                $last_name = (isset($cut[1])) ? $cut[1] : $cut[0];
                if(User::where('email', $clients->email)->exists()){
                    $user = User::where('email', $clients->email)->first();
                    $datu = User::where('user_id', $user->user_id)->update([
                        "email" => $clients->email,
                        "role" => $user->role,
                        "last_name" => $last_name,
                        "first_name" => $first_name,
                        "status" => $user->status,
                        "phone_number" => $user->phone_number,
                    ]);
                    $user->assignRole($role);
                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Updated ' . $clients->email . ' details in the user table',
                    ]);
                }else{

                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Added ' . $clients->email . ' details in the user table',
                    ]);

                    $create = new User([
                        "email" => $clients->email,
                        "last_name" => $last_name,
                        "password" => Hash::make('password'),
                        "first_name" => $first_name,
                        "phone_number" => $clients->phone,
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
        if (Gate::allows('SuperAdmin', auth()->user())) {

            $this->validate($request, [
                'company_name' => ['required', 'string', 'max:199', 'unique:companies'],
                'company_code' => ['required', 'string', 'max:199'],
                'industry_id' => ['required', 'string', 'max:199'],
                'address' => ['required', 'string', 'max:199'],
                // 'lgaId' => ['required', 'string', 'max:199'],
                'contact' => ['required', 'string', 'max:199'],
                'contact_phone' => ['required', 'string', 'max:199'],
                'contact_email' => ['required', 'string', 'max:199'],
                'phone' => ['required', 'string', 'max:20', 'unique:companies'],
                'email' => ['required', 'string', 'max:199', 'unique:companies'],
                'password' => ['required', 'string', 'min:4', 'max:225', 'confirmed'],
                'webadd' => ['required', 'string', 'max:199'],
                'company_description' => ['required', 'string', 'max:199'],

            ]);

            function generateRandomHash($length)
			{
				return strtoupper(substr(md5(uniqid(rand())), 0, (-32 + $length)));
			}

            $data = new Companies([
                "company_name" => $request->input("company_name"),
                "company_code" => $request->input("company_code"),
                "industry_id" => $request->input("industry_id"),
                "address" => $request->input("address"),

                'lgaId' => 0,

                "contact" => $request->input("contact"),
                "contact_phone" => $request->input("contact_phone"),
                "contact_email" => $request->input("contact_email"),
                "phone" => $request->input("phone"),
                "email" => $request->input("email"),

                "webadd" => $request->input("webadd"),
                "company_description" => $request->input("company_description"),

                "no_agents" => 0,
                "no_cust" => 0,
                "inactive" =>1,

                "activation_count" => 0,
                "status_dt" => date('Y-m-d'),
                // "lang_yr" => 'English',
                "servplan_allowed" => 1,
                "status"=> 1,
                "lang_year" => 'test'

            ]);
            $role = 'Admin';
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Added ' . $data->company_code . ' details ',
            ]);

            $cut = explode(" ", $request->input("contact"));
            $first_name = $cut[0];
            $last_name = $cut[0];

            $datum = new User([
                "email" => $request->input("email"),
                "last_name" => $last_name,
                "password" => Hash::make($request->input("password")),
                "first_name" => $first_name,
                "phone_number" => $request->input("phone"),
                "user_activation_code" => 1, "role" => $role
            ]);

            if ($data->save() and ($log->save()) AND ($datum->save())) {
                $company_id= $data->company_id;
                if($request->hasFile('company_logo')){
                    $filenameWithExt = $request->file('company_logo')->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file('company_logo')->getClientOriginalExtension();
                    $cut = str_replace(" ", "_", $filename);
                    $fileNameToStore = 'logo_picture_s'.'.'.$extension;
                    if (!file_exists('company-logo/'.$company_id.'/')) {
                        $dir = mkdir('company-logo/'.$company_id.'/');
                    }else{
                        $dir = 'company-logo/'.$company_id.'/';
                    }
                    $logo = new CompanyLogo([
                        'company_id' => $company_id,
                        'company_logo' => $fileNameToStore,
                        'signature' => 'signature',
                    ]); $logo->save();
                    $path=$request->file('company_logo')->move(('company-logo/'.$company_id.'/'), $fileNameToStore);
                }
                if($request->hasFile('signature')){
                    $filenameWithExt2 = $request->file('signature')->getClientOriginalName();
                    $filename2 = pathinfo($filenameWithExt2, PATHINFO_FILENAME);
                    $extension2 = $request->file('signature')->getClientOriginalExtension();
                    $cut2 = str_replace(" ", "_", $filename2);
                    $cutting2 = str_replace("-", "_", $cut2);
                    $fileNameToStore2 = 'signature_picture_s'.'.'.$extension2;
                    if (!file_exists('company-logo/'.$company_id.'/')) {
                        $dir = mkdir('company-logo/'.$company_id.'/');
                    }else{
                        $dir = 'company-logo/'.$company_id.'/';
                    }

                    $logo = CompanyLogo::where('company_id', $company_id)->update([
                        'signature' => $fileNameToStore2,
                    ]);
                    $path=$request->file('signature')->move(('company-logo/'.$company_id.'/'), $fileNameToStore2);
                }
                $datum->assignRole($role);
                return redirect()->route("company.index")->with("success", "You Have Added "
                    . $request->input("company_name") . " Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure");
            }

        } else {
            
            return view('errors.403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        $check = Companies::where('email', $email)->get();
        if(count($check)< 1){

            return redirect()->back()->with([
                'error' => "$email does not exist for any companys",
            ]);
        }else{
            $com = Companies::where('email', $email)->first();
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $company = Companies::orderBy('company_name', 'asc')->get();
                $comp = $this->model->show($com->company_id);
                return view('dashboard.companies.details')->with([
                    'company' => $company, 'comp' => $comp
                ]);
            }elseif(auth()->user()->hasRole('Admin')){

                $comp = $this->model->show($company_id);
                return view('dashboard.companies.details')->with([
                'comp' => $comp
                ]);
            } else {
                return view('errors.403');
            }
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($email)
    {
        $check = Companies::where('email', $email)->get();
        if(count($check)< 1){
            return redirect()->back()->with([
                'error' => "$email does not exist for any company",
            ]);
        }else{
            $com = Companies::where('email', $email)->first();
            $comp = $this->model->show($com->company_id);
            if (Gate::allows('SuperAdmin', auth()->user())) {

                $company = Companies::orderBy('company_name', 'asc')->get();
                $industry = Industries::orderBy('industry_name', 'asc')->get();
                return view('dashboard.companies.edit')->with([
                    'company' => $company, 'comp' => $comp, 'industry' => $industry
                ]);

            }elseif(auth()->user()->hasRole('Admin')){
                $industry = Industries::orderBy('industry_name', 'asc')->get();

                return view('dashboard.companies.edit')->with([
                'comp' => $comp, 'industry' => $industry
                ]);
            } else {
                return view('errors.403');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $email)
    {
        $check = Companies::where('email', $email)->get();

        if(count($check)< 1){

            return redirect()->back()->with([
                'error' => "$email does not exist for any company",
            ]);
        }else{
            $com = Companies::where('email', $email)->first();
            $company_id = $com->company_id;
            if (Gate::allows('SuperAdmin', auth()->user())) {

                $this->validate($request, [
                    'company_name' => ['required', 'string', 'max:199'],
                    'industry_id' => ['required', 'string', 'max:199'],
                    // 'industry_id' => ['required', 'integer', 'max:199'],
                    'address' => ['required', 'string',],
                    // 'lgaId' => ['required', 'string', 'max:199'],
                    'contact' => ['required', 'string', 'max:199'],
                    'contact_phone' => ['required', 'string', 'max:199'],
                    'contact_email' => ['required', 'string', 'max:199'],
                    'phone' => ['required', 'string', 'max:20', ],
                    'email' => ['required', 'string', 'max:199',],
                    'webadd' => ['required', 'string', 'max:199'],
                    'company_description' => ['required', 'string'],
                    
                ]);
                
                $comp = $this->model->show($company_id);
               
                if(User::where('email',$request->input('email'))->exists()){

                    $user = User::where('email',$request->input('email'))->first();
                    $user_id = $user->user_id;

                    $data = ([
                        "company" => $this->model->show($company_id),
                        "company_name" => $request->input("company_name"),
                        // "company_code" => $comp->company_code,
                        "company_code" => $request->input("company_code"),
                        "industry_id" => $request->input("industry_id"),
                        "address" => $request->input("address"),
                        "lgaId" => 0,
                        "contact" => $request->input("contact"),
                        "contact_phone" => $request->input("contact_phone"),
                        "contact_email" => $request->input("contact_email"),
                        "phone" => $request->input("phone"),
                        "email" => $request->input("email"),
                        "webadd" => $request->input("webadd"),
                        "company_description" => $request->input("company_description"),
                        "no_agents" => 0,
                        "no_cust" => 0,
                        "inactive" =>1,
                        "activation_count" => 0,
                        "status_dt" => NULL,
                        "lang_year" => 'English',
                        "servplan_allowed" => 1,
                        "status"=> 1,

                    ]);
                    
                    if (empty($request->input("password"))) {
                        $password = $user->password;
                    } else {
                        if($request->input("password") != ($request->input("password_confirmation"))){
                            return redirect()->back()->with("error", "Password does not match");
                        }
                        $password = Hash::make($request->input("password"));
                    }

                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Updated ' . $comp->company_code . ' details ',
                    ]);

                    $cut = explode(" ", $request->input("contact"));
                    $first_name = $cut[0];
                    $last_name = $cut[0];
                    $datum = User::where('user_id', $user_id)->update([
                        "email" => $request->input("email"),
                        "last_name" => $last_name,
                        "password" => $password,
                        "first_name" => $first_name,
                        "phone_number" => $request->input("phone"),
                        "user_activation_code" => 1,
                    ]);

                    if ($this->model->update($data, $company_id) and ($log->save()) AND (!empty($datum))) {
                        if($request->hasFile('company_logo')){
                            $filenameWithExt = $request->file('company_logo')->getClientOriginalName();
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension = $request->file('company_logo')->getClientOriginalExtension();
                            $cut = str_replace(" ", "_", $filename);
                            $fileNameToStore = 'logo_picture_s'.'.'.$extension;
                            if (!file_exists('company-logo/'.$company_id.'/')) {
                                $dir = mkdir('company-logo/'.$company_id.'/');
                            }else{
                                $dir = 'company-logo/'.$company_id.'/';
                            }
                            $path=$request->file('company_logo')->move(('company-logo/'.$company_id.'/'), $fileNameToStore);
                            if(count(getLogo($company_id)) > 0){
                                $logo = CompanyLogo::where('company_id', $company_id)->update([
                                    'company_logo' => $fileNameToStore,
                                ]);
                            }else{
                                $logo = new CompanyLogo([
                                    'company_id' => $company_id,
                                    'company_logo' => $fileNameToStore,
                                    'signature' => 'signature',
                                ]); $logo->save();
                            }

                        }
                        if($request->hasFile('signature')){
                            $filenameWithExt2 = $request->file('signature')->getClientOriginalName();
                            $filename2 = pathinfo($filenameWithExt2, PATHINFO_FILENAME);
                            $extension2 = $request->file('signature')->getClientOriginalExtension();
                            $cut2 = str_replace(" ", "_", $filename2);
                            $cutting2 = str_replace("-", "_", $cut2);
                            $fileNameToStore2 = 'signature_picture_s'.'.'.$extension2;
                            if (!file_exists('company-logo/'.$company_id.'/')) {
                                $dir = mkdir('company-logo/'.$company_id.'/');
                            }else{
                                $dir = 'company-logo/'.$company_id.'/';
                            }
                            $logo = CompanyLogo::where('company_id', $company_id)->update([
                                'signature' => $fileNameToStore2,
                            ]);
                            $path=$request->file('signature')->move(('company-logo/'.$company_id.'/'), $fileNameToStore2);
                        }
                        return redirect()->route("company.index")->with("success", "You Have Added "
                            . $request->input("company_name") . " Successfully");
                    } else {
                        return redirect()->back()->with("error", "Network Failure");
                    }

                }else{
                    $role = 'Admin';
                    if($request->input("password") != $request->input("password_confirmation")){
                        return redirect()->back()->with("error", "Password does not match");
                    }
                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Updated ' . $comp->company_code . ' details ',
                    ]);
                    $cut = explode(" ", $request->input("contact"));
                    $first_name = $cut[0];
                    $last_name = (isset($cut[1])) ? $cut[1] : $cut[0];
                    $datum = new User([
                        "email" => $request->input("email"),
                        "last_name" => $last_name,
                        "password" => Hash::make($request->input("password")),
                        "first_name" => $first_name,
                        "phone_number" => $request->input("phone"),
                        "user_activation_code" => 1, "role" => $role
                    ]);
                    
                    function generateRandomHash($length)
                    {
                        return strtoupper(substr(md5(uniqid(rand())), 0, (-32 + $length)));
                    }
                    $company_code = strtoupper(generateRandomHash(5));

                    if(User::where('email', $request->input('email'))->exists()){

                        return redirect()->back()->with("error", $request->input('email'). " is in use by another company");
                    }else{

                        $data = ([
                            "company" => $this->model->show($company_id),
                            "company_name" => $request->input("company_name"),
                            "company_code" => $company_code,
                            "industry_id" => $request->input("industry_id"),
                            "address" => $request->input("address"),
                            "lgaId" => 1,
                            "contact" => $request->input("contact"),
                            "contact_phone" => $request->input("contact_phone"),
                            "contact_email" => $request->input("contact_email"),
                            "phone" => $request->input("phone"),
                            "email" => $request->input("email"),
                            "webadd" => $request->input("webadd"),
                            "company_description" => $request->input("company_description"),
                            "no_agents" => 0,
                            "no_cust" => 0,
                            "inactive" =>1,
                            "activation_count" => 0,
                            "status_dt" => 0,
                            "lang_yr" => 'English',
                            "servplan_allowed" => 1,
                            "status"=> 1,

                        ]);

                        if ($this->model->update($data, $company_id) and ($log->save()) AND ($datum->save())) {
                            $datum->assignRole($role);
                            if($request->hasFile('company_logo')){
                                $filenameWithExt = $request->file('company_logo')->getClientOriginalName();
                                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                                $extension = $request->file('company_logo')->getClientOriginalExtension();
                                $cut = str_replace(" ", "_", $filename);
                                $fileNameToStore = 'logo_picture_s'.'.'.$extension;
                                if (!file_exists('company-logo/'.$company_id.'/')) {
                                    $dir = mkdir('company-logo/'.$company_id.'/');
                                }else{
                                    $dir = 'company-logo/'.$company_id.'/';
                                }
                                $logo = CompanyLogo::where('company_id', $company_id)->update([
                                    'company_logo' => $fileNameToStore,
                                ]);
                                $path=$request->file('company_logo')->move(('company-logo/'.$company_id.'/'), $fileNameToStore);
                            }
                            if($request->hasFile('signature')){
                                $filenameWithExt2 = $request->file('signature')->getClientOriginalName();
                                $filename2 = pathinfo($filenameWithExt2, PATHINFO_FILENAME);
                                $extension2 = $request->file('signature')->getClientOriginalExtension();
                                $cut2 = str_replace(" ", "_", $filename2);
                                $cutting2 = str_replace("-", "_", $cut2);
                                $fileNameToStore2 = 'signature_picture_s'.'.'.$extension2;
                                if (!file_exists('company-logo/'.$company_id.'/')) {
                                    $dir = mkdir('company-logo/'.$company_id.'/');
                                }else{
                                    $dir = 'company-logo/'.$company_id.'/';
                                }
                                $logo = CompanyLogo::where('company_id', $company_id)->update([
                                    'signature' => $fileNameToStore2,
                                ]);
                                $path=$request->file('signature')->move(('company-logo/'.$company_id.'/'), $fileNameToStore2);
                            }
                            return redirect()->route("company.index")->with("success", "You Have Added "
                                . $request->input("company_name") . " Successfully");
                        } else {
                            return redirect()->back()->with("error", "Network Failure");
                        }
                    }

                }
            } else {
                return view('errors.403');
            }
        }
    }

    public function removeImage($company_id, $filename){
        if(!empty(unlink('company-logo/'.$company_id.'/'.$filename))){
             return redirect()->back()->with(['success' => "Image Deleted Successfully "]);
        }else{
             return redirect()->back()->with(['error' => "Unable to delete the image at the moment, Please try again later"  ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($company_id)
    {
        $check = Companies::where('company_id', $company_id)->get();
        if(count($check)< 1){

            return redirect()->back()->with([
                'error' => "$company_id does not exist for any company",
            ]);
        }else{
            $com = Companies::where('company_id', $company_id)->first();
            $company_id = $com->company_id;
            $email = $com->email;
            if (Gate::allows('SuperAdmin', auth()->user())){

                $cli = $this->model->show($company_id);
                $user = User::where('email', $cli->email)->get();
                if(count($user)>0){

                    // Delete from both tables
                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Deleted Company ' . $cli->company_name,
                    ]);
                    $user = User::where('email', $cli->email)->first();
                    //Delete RFQ  Delete Client Contact  Delete Client, Delete PO, Delete Employee
                    if (($cli->delete($company_id)) AND ($user->delete($user->user_id))) {
                        $client = DB::table('clients')->where(['company_id' => $company_id])->get();
                        if(count($client)>0){
                            $clients = DB::table('clients')->where(['company_id' => $company_id])->first();
                            DB::table('clients')->where(['company_id' => $company_id])->delete();
                            DB::table('client_pos')->where(['company_id' => $company_id])->delete();
                            DB::table('client_rfqs')->where(['company_id' => $company_id])->delete();
                            DB::table('client_contacts')->where(['client_id' => $clients->client_id])->delete();
                            DB::table('line_items')->where(['client_id' => $clients->client_id])->delete();
                            DB::table('employers')->where(['company_id' => $company_id])->delete();
                            DB::table('vendors')->where(['company_id' => $company_id])->delete();
                            DB::table('shippers')->where(['company_id' => $company_id])->delete();
                        }else{
                            DB::table('clients')->where(['company_id' => $company_id])->delete();
                            DB::table('client_pos')->where(['company_id' => $company_id])->delete();
                            DB::table('client_rfqs')->where(['company_id' => $company_id])->delete();
                            DB::table('employers')->where(['company_id' => $company_id])->delete();
                            DB::table('vendors')->where(['company_id' => $company_id])->delete();
                            DB::table('shippers')->where(['company_id' => $company_id])->delete();


                        }
                        return redirect()->back()->with([
                            'success' => "You Have Deleted Company $cli->company_name Successfully",
                        ]);
                    } else {
                        return redirect()->back()->with([
                            'error' => "Network Failure, Please Try again Later",
                        ]);
                    }
                }else{

                    //Delete from Single Table
                    if (($cli->delete($company_id)) and ($cli->trashed())) {
                        return redirect()->back()->with([
                            'success' => "You Have Deleted The Company $cli->company_name Successfully",
                        ]);
                    } else {
                        return redirect()->back()->with([
                            'error' => "Operation Failed, Please Try again Later",
                        ]);
                    }

                }

            }else{
                return view('errors.403');
            }
        }
    }
}
