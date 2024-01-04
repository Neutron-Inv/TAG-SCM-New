<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Companies, User, Employers,Log};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\EmployerRepository;
use Illuminate\Support\Facades\Gate;
use DB;

class EmployerControllers extends Controller
{
    protected $model;
    public function __construct(Employers $employer)
    {
        // set the model
        $this->model = new EmployerRepository($employer);
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Employer']);
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
            // $employer = Employers::orderBy('full_name', 'asc')->get();
            $employer = User::where('role', 'Employer')->orWhere('role', 'HOD')->orderBy('first_name', 'asc')->get();
            return view('dashboard.employers.create')->with([
                'company' => $company, 'employer' => $employer
            ]);
        }elseif(Auth::user()->hasRole('Admin')){
            $company = Companies::where('email', Auth::user()->email)->first();
            $employer = Employers::where('company_id', $company->company_id)->orderBy('full_name', 'asc')->get();
            return view('dashboard.employers.create')->with([
                'company' => $company, 'employer' => $employer
            ]);
        }elseif(Auth::user()->hasRole('Employer')){

            $emp = Employers::where('email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $emp->company_id)->first();
            $employer = Employers::where('email', Auth::user()->email)->get();

            return view('dashboard.employers.create')->with([
                'company' => $company, 'employer' => $employer
            ]);

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
            $employer = Employers::orderBy('email', 'desc')->get();
            // dd($employer);
            $role = 'Employer';
            foreach ($employer as $clients) {
                $cut = explode(" ", $clients->full_name);
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
                        "phone_number" => 'N/A',
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
        if (Gate::allows('SuperAdmin', auth()->user()) OR (auth()->user()->hasRole('Admin'))) {

            $this->validate($request, [
                'first_name' => ['required', 'string', 'max:199'],
                'password' => ['required', 'string', 'min:4', 'max:225', 'confirmed'],
                'phone_number' => ['required', 'string', 'max:199', 'unique:users'],
                'email' => ['required', 'email', 'max:199', 'unique:users'],
                'last_name' => ['required', 'string', 'max:199'],
            ]);

            if(Employers::where('email', $request->input("email"))->exists()){
                return redirect()->back()->with([
                    'error' => $request->input('email') ." is in use by another employer on the system",
                ]);
            }else{

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Added ' . $request->input("email") . ' details ',
                ]);

                $datum = new User([

                    "email" => $request->input("email"),
                    "last_name" => $request->input("last_name"),
                    "password" => Hash::make($request->input("password")),
                    "first_name" => $request->input("first_name"),
                    "phone_number" => $request->input("phone_number"),
                    "user_activation_code" => 1, "role" => $request->input("role")
                ]);

                $data = new Employers([
                    "email" => $request->input("email"),
                    "company_id" => $request->input("company_id"),
                    "full_name" =>  $request->input("first_name") .' '. $request->input("last_name"),
                ]);

                if ($data->save() and ($log->save()) AND ($datum->save())) {
                    $datum->assignRole($request->input("role"));
                    return redirect()->route("employer.create")->with("success", "You Have Added "
                        . $request->input("first_name") . " Successfully");
                } else {
                    return redirect()->back()->with("error", "Network Failure");
                }
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
    public function edit($employee_id)
    {
        if(Employers::where('employee_id', $employee_id)->exists()){
            $emp = $this->model->show($employee_id);
            $user = User::where('email', $emp->email)->first();
            if (Gate::allows('SuperAdmin', auth()->user())) {

                $company = Companies::orderBy('company_name', 'asc')->get();
                $employer = Employers::orderBy('full_name', 'asc')->get();
                return view('dashboard.employers.edit')->with([
                    'company' => $company, 'employer' => $employer, 'emp' => $emp, 'user' => $user
                ]);

            }elseif(auth()->user()->hasRole('Admin')){
                $company = Companies::where('email', Auth::user()->email)->first();
                $employer = Employers::where('company_id', $company->company_id)->orderBy('full_name', 'asc')->get();

                return view('dashboard.employers.edit')->with([
                    'company' => $company, 'employer' => $employer, 'emp' => $emp, 'user' => $user
                ]);
            }elseif(Auth::user()->hasRole('Employer')){

                //$emp = Employers::where('email', Auth::user()->email)->first();
                $company = Companies::where('company_id', $emp->company_id)->first();
                $employer = Employers::where('email', Auth::user()->email)->get();
                return view('dashboard.employers.edit')->with([
                    'company' => $company, 'employer' => $employer, 'emp' => $emp, 'user' => $user
                ]);
            } else {
                
                return view('errors.403');
            }
        }else{
            return redirect()->back()->with([
            'error' => "$employee_id does not Exist for any Employee",
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
    public function update(Request $request, $employer_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (auth()->user()->hasRole('Admin')) OR (auth()->user()->hasRole('Employer')) OR (auth()->user()->hasRole('HOD'))) {

            $this->validate($request, [
                'first_name' => ['required', 'string', 'max:199'],
                'phone_number' => ['required', 'string', 'max:199',],
                'email' => ['required', 'email', 'max:199',],
                'last_name' => ['required', 'string', 'max:199'],
            ]);

            $emp = $this->model->show($employer_id);
            $user = User::where('email', $emp->email)->first();

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Updated ' . $request->input("email") . ' details ',
            ]);

            $datum = User::where('user_id', $user->user_id)->update([

                "email" => $request->input("email"),
                "last_name" => $request->input("last_name"),
                "password" => Hash::make($request->input("password")),
                "first_name" => $request->input("first_name"),
                "phone_number" => $request->input("phone_number"),
                "user_activation_code" => $user->user_activation_code, "role" => $request->input("role")
            ]);

            $data =([
                "employer" => $this->model->show($employer_id),
                "email" => $request->input("email"),
                "company_id" => $request->input("company_id"),
                "full_name" =>  $request->input("last_name") .' '. $request->input("first_name"),
            ]);
            DB::table('model_has_roles')->where('model_id', $user->user_id)->delete();

            if ($this->model->update($data, $employer_id) and ($log->save()) AND (!empty($datum))) {
                $user->assignRole($request->input("role"));
                return redirect()->route("employer.create")->with("success", "You Have Updated the details Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure");
            }

        } else {
            
            return view('errors.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($employer_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){

            $employee = $this->model->show($employer_id);
            $user = User::where('email', $employee->email)->get();
            if(count($user)>0){

                // Delete from both tables
                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Deleted Employer ' . $employee->email,
                ]);
                $user = User::where('email', $employee->email)->first();
                if (($employee->delete($employer_id)) and ($employee->trashed()) AND ($user->delete($user->user_id)) and ($user->trashed())) {
                    return redirect()->back()->with([
                        'success' => "You Have Deleted User $employee->email Successfully",
                    ]);
                } else {
                    return redirect()->back()->with([
                        'error' => "Network Failure, Please Try again Later",
                    ]);
                }
            }else{

                //Delete from Single Table
                if (($cli->delete($employer_id)) and ($cli->trashed())) {
                    return redirect()->back()->with([
                        'success' => "You Have Deleted User $employee->email Successfully",
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

    public function suspend($email)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (auth()->user()->hasRole('Admin'))) {
            $use = User::where([
                "email" => $email,
            ])->first();

            $details = $use->first_name;
            $updat = User::where('email', $email)
                ->update([
                    "user_activation_code" => 0,
                ]);
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Suspended ' . $use->email . ' Account ',
            ]);
            if (($updat) and ($log->save())) {

                return redirect()->back()->with([
                    'success' => "You Have Suspend  $details Account Successfully",
                ]);
            }
        } else {
            
            return view('errors.403');
        }
    }

    public function unsuspend($email)
    {
        if (Gate::allows('SuperAdmin', auth()->user()) OR (auth()->user()->hasRole('Admin'))) {
            $use = User::where([
                "email" => $email,
            ])->first();

            $details = $use->first_name;
            $updat = User::where('email', $email)
                ->update([
                    "user_activation_code" => 1,
                ]);
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Un Suspended ' . $use->email . ' Account ',
            ]);
            if (($updat) and ($log->save())) {
                return redirect()->back()->with([
                    'success' => "You Have Un Suspend  $details Account Successfully",
                ]);
            }
        } else {
            
            return view('errors.403');
        }
    }
}
