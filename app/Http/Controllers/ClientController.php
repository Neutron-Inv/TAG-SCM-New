<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Clients, Log, Employers,ClientRfq, Shippers, ClientContact, ClientPo, NgState, Country, ClientDocuments};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ClientRepository;
use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    protected $model;
    public function __construct(Clients $client)
    {
        // set the model
        $this->model = new ClientRepository($client);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Employer|Contact|Client|HOD|Shipper']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $client = Clients::orderBy('client_name', 'asc')->get();
            $company = Companies::orderBy('company_name', 'asc')->get();
            $ng_states = NgState::orderby('name', 'asc')->get();
            $countries = Country::orderby('name', 'asc')->get();
            return view('dashboard.clients.index')->with([
                'client' => $client, "company" => $company, "ng_states" => $ng_states, "countries" => $countries
            ]);
        }elseif(Auth::user()->hasRole('Admin')){
            $company = Companies::where('email', Auth::user()->email)->first();
            $client = Clients::where('company_id', $company->company_id)->orderBy('client_name', 'asc')->get();
            $rfq = ClientRfq::where('company_id', $company->company_id)->orderBy('created_at','desc')->get();
            $po = ClientPo::where('company_id', $company->company_id)->orderBy('created_at','desc')->get();
            $ng_states = NgState::orderby('name', 'asc')->get();
            $countries = Country::orderby('name', 'asc')->get();
            return view('dashboard.clients.index')->with([
                'client' => $client, "company" => $company, 'rfq' => $rfq, 'po' => $po, "ng_states" => $ng_states, "countries" => $countries
            ]);

        }elseif(Auth::user()->hasRole('Client')){
            $client = Clients::where('email', Auth::user()->email)->get();
            return view('dashboard.clients.index')->with([
                "client" => $client
            ]);
        }elseif((Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('HOD')))){

            $employer = Employers::where('email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $employer->company_id)->first();
            $client = Clients::where('company_id', $company->company_id)->orderBy('client_name', 'asc')->get();
            $ng_states = NgState::orderby('name', 'asc')->get();
            $countries = Country::orderby('name', 'asc')->get();
            return view('dashboard.clients.index')->with([
                "client" => $client, 'company' => $company, 'ng_states' => $ng_states, 'countries' => $countries
            ]);


        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    public function list()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $client = Clients::orderBy('client_name', 'asc')->get();
            return view('dashboard.clients.list')->with([
                'client' => $client,
            ]);

        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    public function bin()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $client = Clients::onlyTrashed()->get();
            return view('dashboard.clients.recyclebin')->with([
                'client' => $client,
            ]);
        }elseif(Auth::user()->hasRole('Admin')){

            $company = Companies::where('email', Auth::user()->email)->first();
            $client = Clients::where('company_id', $company->company_id)->onlyTrashed()->get();

            return view('dashboard.clients.recyclebin')->with([
                'client' => $client,
            ]);

        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    public function restore($client_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

            $client = Clients::where('client_id', $client_id)->first();
            dd($client);
            $user = User::where('email', $client->email)->first();

            if((User::withTrashed()->where('user_id', $user->user_id)->restore()) AND (Client::withTrashed()->where('client_id', $client_id)->restore())){
                $name = $client->cleint_name;
                $email = $categ->email;
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Restored $email Account ',
                ]);$log->save();

                return redirect()->back()->with([
                    'success' => " You Have Restored $email  Successfully",

                ]);
            }else{
                return redirect()->back()->with([
                    'error' => "Operation Failed, Please Try again Later",
                ]);
            }
            echo "here";

        } else {
            return redirect()->back()->with("error", "You Dont Have Access To The Recycle Bin");
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

        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR (Auth::user()->hasPermissionTo('Add Client'))){

            $this->validate($request, [
                'company_id' => ['required', 'string', 'max:199'],
                'client_name' => ['required', 'string', 'max:199'],
                'address' => ['required', 'string', 'max:199'],
                'state' => ['required', 'string', 'max:199'],
                'city' => ['required', 'string', 'max:199'],
                'country_code' => ['required', 'string', 'max:199'],
                'phone' => ['required', 'string', 'max:20'],
                'email' => ['required', 'email', 'max:199'],
                'short_code' => ['required', 'string', 'max:6'],
                'company_vendor_code' => ['required', 'string', 'max:20']
            ]);

            if(User::where('email', $request->input('email'))->exists()){
                return redirect()->back()->with([
                    'error' => $request->input('email') ." is in use by another user on the system",
                ]);
            }else{
                function generateRandomHash($length)
                {
                    return strtoupper(substr(md5(uniqid(rand())), 0, (-32 + $length)));
                }
                $shortcode = strtoupper(generateRandomHash(4));
                if(empty($request->input("login_url"))){
                    $login_url = 'NULL';
                }else{
                    $login_url = $request->input("login_url");
                }

                if(empty($request->input("vendor_username"))){
                    $vendor_username = 'NULL';
                }else{
                    $vendor_username = $request->input("vendor_username");
                }

                if(empty($request->input("vendor_password"))){
                    $vendor_password = 'NULL';
                }else{
                    $vendor_password = $request->input("vendor_password");
                }

                $data = new Clients([
                    "company_id" => $request->input("company_id"),
                    "client_name" => $request->input("client_name"),
                    "address" => $request->input("address"),
                    "state" => $request->input("state") . " State",
                    "city" => $request->input("city"),
                    "country_code" => strtoupper($request->input("country_code")),
                    "phone" => $request->input("phone"),
                    "email" => $request->input("email"),
                    "short_code" => $request->input("short_code"),
                    "transfer" => 0,
                    "company_vendor_code" => $request->input("company_vendor_code"),
                    "login_url" => $login_url,
                    "vendor_username" => $vendor_username,
                    "vendor_password" => $vendor_password,
                ]);

                $role = 'Client';

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Added ' . $request->input('email') . ' details as a client ',
                ]);

                $cut = explode(" ", $request->input("client_name"));
                $first_name = $cut[0];
                $last_name = (isset($cut[1])) ? $cut[1] : $cut[0];


                // $datum = new User([

                //     "email" => $request->input("email"),
                //     "last_name" => $last_name,
                //     "password" => Hash::make($request->input("email")),
                //     "first_name" => $first_name,
                //     "phone_number" => $request->input("phone"),
                //     "user_activation_code" => 1, "role" => $role
                // ]);

                if ($data->save() and ($log->save())) {
                    //$datum->assignRole($role);
                    if($request->hasFile('client_file')) {
                        $file = $request->client_file;
                        foreach ($file as $images) {
                            $filenameWithExt = $images->getClientOriginalName();
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension = $images->getClientOriginalExtension();
                            $ext = array('PDF', 'pdf', 'doc', 'DOC', 'DOCX', 'docx',);
                            if (in_array($extension, $ext))
                            {
                                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                                $path=$images->move('client-files/', $fileNameToStore);
                                $image = new ClientDocuments(["client_id" => $data->client_id, "file" => $fileNameToStore, ]);
                                $image->save();
                            }else{
                                return back()->withInput()->with("error", "The Selected file $filenameWithExt is not a document");
                            }
                        }
                    }
                    return redirect()->route("client.index")->with("success", "You Have Added The Client Successfully");
                } else {
                    return redirect()->back()->with("error", "Network Failure");
                }
            }
        }else{
            return view('errors.403');
        }
    }

    public function load()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $client = Clients::orderBy('client_name', 'asc')->get();
            $role = 'Client';
            foreach ($client as $clients) {
                $cut = explode(" ", $clients->client_name);
                $first_name = $cut[0];
                $last_name = (isset($cut[1])) ? $cut[1] : $cut[0];
                if(User::where('email', $clients->email)->exists()){
                    $user = User::where('email', $clients->email)->first();
                    $datu = User::where('user_id', $user->user_id)->update([
                        "email" => $clients->email, "role" => $role,
                        "status" => $user->status,
                        "phone_number" => $clients->phone,
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
                        "password" => Hash::make($clients->email),
                        "first_name" => $first_name,
                        "phone_number" => $clients->phone,
                        "user_activation_code" =>0,
                        "status" => 0,
                        "role" => $role
                    ]); $create->save();
                    $create->assignRole($role);
                }
            }
            return redirect()->back()->with([
                'success' => "Details Populated Successfully",
            ]);

        }else{
            return redirect()->back()->with([
                'success' => "Details Populated Successfully",
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($client_id)
    {
        if(Clients::where('client_id', $client_id)->exists()){
            $cli = $this->model->show($client_id);
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $client = $this->model->show($client_id);
                $company = Companies::orderBy('company_name', 'asc')->get();
                return view('dashboard.clients.details')->with([
                    'client' => $client, "company" => $company,
                ]);
            }elseif(Auth::user()->hasRole('Admin')){

                $company = Companies::where('email', Auth::user()->email)->first();
                $client = Clients::where(['company_id' => $company->company_id, 'client_id' => $client_id])->first();
                return view('dashboard.clients.details')->with([
                    'client' => $client, "company" => $company,
                ]);
            // }elseif(Auth::user()->hasRole('Client')){
            //     $client = Clients::where('email', Auth::user()->email)->get();
            //     return view('dashboard.clients.edit')->with([
            //         'client' => $client,  'cli' => $cli
            //     ]);
            }elseif((Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('HOD')))){
                $employer = Employers::where('email', Auth::user()->email)->first();
                $company = Companies::where('company_id', $employer->company_id)->first();
                $client = Clients::where(['company_id' => $company->company_id, 'client_id' => $client_id])->first();

                return view('dashboard.clients.details')->with([
                    'client' => $client, "company" => $company,
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$client_id does not Exist for any Client",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($client_id)
    {
        if(Clients::where('client_id', $client_id)->exists()){
            $cli = $this->model->show($client_id);
            if (Gate::allows('SuperAdmin', auth()->user())) {
                $client = Clients::orderBy('client_name', 'asc')->get();
                $company = Companies::orderBy('company_name', 'asc')->get();
                return view('dashboard.clients.edit')->with([
                    'client' => $client, "company" => $company, 'cli' => $cli
                ]);
            }elseif(Auth::user()->hasRole('Admin')){

                $company = Companies::where('email', Auth::user()->email)->first();
                $client = Clients::where('company_id', $company->company_id)->orderBy('client_name', 'asc')->get();
                return view('dashboard.clients.edit')->with([
                    'client' => $client, "company" => $company, 'cli' => $cli
                ]);
            }elseif(Auth::user()->hasRole('Client')){
                $client = Clients::where('email', Auth::user()->email)->get();
                return view('dashboard.clients.edit')->with([
                    'client' => $client,  'cli' => $cli
                ]);
            }elseif((Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('HOD')))){
                $employer = Employers::where('email', Auth::user()->email)->first();
                $company = Companies::where('company_id', $employer->company_id)->first();
                $client = Clients::where('company_id', $company->company_id)->orderBy('client_name', 'asc')->get();
                $ng_states = NgState::orderby('name', 'asc')->get();
                $countries = Country::orderby('name', 'asc')->get();

                return view('dashboard.clients.edit')->with([
                    'client' => $client, "company" => $company, 'cli' => $cli
                ]);
            } else {
                return redirect()->back()->with([
                    'error' => "You Dont have Access To This Page",
                ]);
            }
        }else{
            return redirect()->back()->with([
            'error' => "$client_id does not Exist for any Client",
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
    public function update(Request $request, $client_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin')) OR(auth()->user()->hasRole('Client')) OR (Auth::user()->hasPermissionTo('Edit Client'))){

            $this->validate($request, [
                'company_id' => ['required', 'string', 'max:199'],
                'client_name' => ['required', 'string', 'max:199'],
                'address' => ['required', 'string', 'max:199'],
                'state' => ['required', 'string', 'max:199'],
                'city' => ['required', 'string', 'max:199'],
                'country_code' => ['required', 'string', 'max:199'],
                'phone' => ['required', 'string', 'max:20'],
                'email' => ['required', 'email', 'max:199'],
                'short_code' => ['required', 'string', 'max:6'],
                'company_vendor_code' => ['required', 'string', 'max:20']
            ]);
            $details = $this->model->show($client_id);
            if(empty($request->input("login_url"))){
                $login_url = $details->login_url;
            }else{
                $login_url = $request->input("login_url");
            }

            if(empty($request->input("vendor_username"))){
                $vendor_username = $details->vendor_username;
            }else{
                $vendor_username = $request->input("vendor_username");
            }

            if(empty($request->input("vendor_password"))){
                $vendor_password = $details->vendor_password;
            }else{
                $vendor_password = $request->input("vendor_password");
            }

            $data = ([
                "client" => $this->model->show($client_id),
                "company_id" => $request->input("company_id"),
                "client_name" => $request->input("client_name"),
                "address" => $request->input("address"),
                "state" => $request->input("state") . " State",
                "city" => $request->input("city"),
                "country_code" => strtoupper($request->input("country_code")),
                "phone" => $request->input("phone"),
                "email" => $request->input("email"),
                "short_code" => $request->input("short_code"),
                "transfer" => 0,
                "company_vendor_code" => $request->input("company_vendor_code"),

                "login_url" => $login_url,
                "vendor_username" => $vendor_username,
                "vendor_password" => $vendor_password,
            ]);

            $role = 'Client';

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Updated ' . $request->input('email') . ' details  ',
            ]);

            $cut = explode(" ", $request->input("client_name"));
            $first_name = $cut[0];
            $last_name = $cut[0];

            if(User::where('email', $request->input('email'))->exists()){

                $user = User::where('email',$request->input('email'))->first();
                $user_id = $user->user_id;
                $datu = User::where('user_id', $user_id)->update([
                    "email" => $request->input("email"),
                    "last_name" => $last_name,
                    "password" => Hash::make($request->input("email")),
                    "first_name" => $first_name,
                    "phone_number" => $request->input("phone"),
                    "user_activation_code" => 1, "role" => $role
                ]);

                if ($this->model->update($data, $client_id) and ($log->save()) AND (!empty($datu))) {
                    if($request->hasFile('client_file')) {
                        $file = $request->client_file;
                        foreach ($file as $images) {
                            $filenameWithExt = $images->getClientOriginalName();
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension = $images->getClientOriginalExtension();
                            $ext = array('PDF', 'pdf', 'doc', 'DOC', 'DOCX', 'docx',);
                            if (in_array($extension, $ext))
                            {
                                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                                $path=$images->move('client-files/', $fileNameToStore);
                                $image = new ClientDocuments(["client_id" => $details->client_id, "file" => $fileNameToStore, ]);
                                $image->save();
                            }else{
                                return back()->withInput()->with("error", "The Selected file $filenameWithExt is not a document");
                            }
                        }
                    }
                    return redirect()->route("client.index")->with("success", "You Have Updated The Client Details Successfuly");
                } else {
                    return redirect()->back()->with("error", "Operation failed, Please Try again later");
                }


            }else{

                $datum = new User([
                    "email" => $request->input("email"),
                    "last_name" => $last_name,
                    "password" => Hash::make($request->input("email")),
                    "first_name" => $first_name,
                    "phone_number" => $request->input("phone"),
                    "user_activation_code" => 1, "role" => $role
                ]);

                if ($this->model->update($data, $client_id) and ($log->save()) AND ($datum->save())) {
                    $datum->assignRole($role);
                    return redirect()->route("client.index")->with("success", "You Have Updated "
                        . $request->input("client_name") . " Successfully");
                } else {
                    return redirect()->back()->with("error", "Network Failure");
                }
            }


        }else{

            return view('errors.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($client_id)
    {
        if(Clients::where('client_id', $client_id)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

                $cli = $this->model->show($client_id);
                $user = User::where('email', $cli->email)->get();
                if(count($user)>0){

                    // Delete from both tables
                    $log = new Log([
                        "user_id" => Auth::user()->user_id,
                        "activities" => 'Deleted Client ' . $cli->client_email,
                    ]);
                    $user = User::where('email', $cli->email)->first();
                    if (($cli->delete($client_id)) and ($cli->trashed()) AND ($user->delete($user->user_id)) and ($user->trashed())) {
                        return redirect()->back()->with([
                            'success' => "You Have Deleted Client $cli->email Successfully",
                        ]);
                    } else {
                        return redirect()->back()->with([
                            'error' => "Network Failure, Please Try again Later",
                        ]);
                    }
                }else{

                    //Delete from Single Table
                    if (($cli->delete($client_id)) and ($cli->trashed())) {
                        return redirect()->back()->with([
                            'success' => "You Have Deleted Client $cli->email Successfully",
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
            'error' => "$client_id does not Exist for any Client",
            ]);
        }
    }



    public function see()
    {
        dd('Test');
    }
}
