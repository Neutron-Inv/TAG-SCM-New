<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User, Log, Companies};
use DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserActivation;
use App\Notifications\UserDeActivation;

class UsersController extends Controller
{
    protected $model;
    public function __construct(User $user)
    {
        // set the model
        $this->middleware('auth');
        $this->model = new UserRepository($user);
        $this->middleware(['role:SuperAdmin|Admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('Administrator', auth()->user())) {
            $user = User::where('role', 'SuperAdmin')->orderBy('email', 'asc')->get();
            return view('dashboard.users.create')->with([
                'user' => $user,
            ]);
        }elseif(Auth::user()->hasRole('Admin')){
            $company = Companies::where('email', Auth::user()->email)->first();
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');


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
            $user = User::where('role', 'SuperAdmin')->onlyTrashed()->get();
            return view('dashboard.users.recyclebin')->with([
                'user' => $user,
            ]);
        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    public function restore($user_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            User::withTrashed()
                ->where('user_id', $user_id)
                ->restore();
            $categ = $this->model->show($user_id);
            $name = $categ->first_name;
            $email = $categ->email;
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Restored $email Account ',
            ]);
            $log->save();

            return redirect()->back()->with([
                'success' => " You Have Restored $email  Successfully",

            ]);
        } else {
            return redirect()->back()->with("error", "You Dont Have Access To this page");
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
        if (Gate::allows('SuperAdmin', auth()->user())) {

            $this->validate($request, [
                'first_name' => ['required', 'string', 'max:199'],
                'password' => ['required', 'string', 'min:4', 'max:225', 'confirmed'],
                'phone_number' => ['required', 'string', 'max:199', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:199', 'unique:users'],
                'last_name' => ['required', 'string', 'max:199'],
            ]);
            $role = 'SuperAdmin';

            $data = new User([
                "email" => $request->input("email"),
                "last_name" => $request->input("last_name"),
                "password" => Hash::make($request->input("password")),
                "first_name" => $request->input("first_name"),
                "phone_number" => $request->input("phone_number"),
                "role" => $role,
                'user_activation_code' => 1

            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Added ' . $request->input("email") . ' as ' . $role,
            ]);


            if ($data->save() and ($log->save())) {
                $data->assignRole($role);
                return redirect()->route("users.index")->with("success", "You Have Added "
                    . $request->input("email") . " Details Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure");
            }
        } else {
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
    public function edit($email)
    {
        $see = User::where('email', $email)->first();
        $user_id = $see->user_id;
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $user = User::where('role', 'SuperAdmin')->orderBy('email', 'asc')->get();

            $use = $this->model->show($user_id);
            $roles = Role::pluck('name', 'name')->all();
            $userRole = $use->roles->pluck('name', 'name')->all();
            $user_roles = Role::all();

            return view('dashboard.users.edit')->with([
                "user" => $user,
                "use" => $use,
                "userRole" => $userRole,
                "roles" => $roles,
                'user_roles' => $user_roles
            ]);
        }else{
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To This Page",
            // ]);
            return view('errors.403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {

            $this->validate($request, [
                'first_name' => ['required', 'string', 'max:199'],
                'phone_number' => ['required', 'string', 'max:199'],
                'last_name' => ['required', 'string', 'max:199'],
            ]);$role = 'SuperAdmin';
            $user =  $this->model->show($user_id);
            if (empty($request->input("password"))) {
                $password = $user->password;
            } else {
                $password = Hash::make($request->input("password"));
            }

            $data = ([
                "user" => $this->model->show($user_id),
                "email" => $request->input("email"),
                "last_name" => $request->input("last_name"),
                "password" => $password,
                "first_name" => $request->input("first_name"),
                "phone_number" => $request->input("phone_number"),
                "user_activation_code" => 1, "role" => $role
            ]);

            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Updated ' . $request->input("email") . ' details ',
            ]);
            DB::table('model_has_roles')->where('model_id', $user->user_id)->delete();

            if ($this->model->update($data, $user_id) and ($log->save())) {
                $user->assignRole($role);
                return redirect()->route("users.index")->with("success", "You Have Updated "
                    . $request->input("email") . " Details Successfully");
            } else {
                return redirect()->back()->with("error", "Network Failure");
            }
        } else {
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
    public function destroy($email)
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $see = User::where('email', $email)->first();
            $user_id = $see->user_id;
            $user =  $this->model->show($user_id);
            $use = User::where([
                "user_id" => $user_id,
            ])->first();

            $details = $use->first_name;
            $email = $use->email;
            $roles = $use->role;

            if (($user->delete($user_id)) and ($user->trashed())) {
                return redirect()->back()->with([
                    'success' => "You Have Deleted  $details From The User Details Successfully",
                ]);
            }else{
                return redirect()->back()->with([
                    'error' => "Operation failed, Please try again later",
                ]);
            }
        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To this page",
            // ]);
            return view('errors.403');
        }
    }

    public function suspend($email)
    {
        if (Gate::allows('Administrator', auth()->user())) {
            $use = User::where([
                "email" => $email,
            ])->first();
            $user =  $this->model->show($use->user_id);
            $details = $use->first_name;
            $updat = User::where('email', $email)
                ->update([
                    "user_activation_code" => 0, "status" => 0
                ]);
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Suspended ' . $use->email . ' Account ',
            ]);
            $arr = [
                "user" => $this->model->show($use->user_id)
            ];


            if (($updat) and ($log->save())) {
                $user->notify(new UserActivation($arr));
                return redirect()->back()->with([
                    'success' => "You Have Suspend  $details Account Successfully",
                ]);
            }
        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To this page",
            // ]);
            return view('errors.403');
        }
    }

    public function unsuspend($email)
    {
        if (Gate::allows('Administrator', auth()->user())) {
            $use = User::where([
                "email" => $email,
            ])->first();
            $user =  $this->model->show($use->user_id);
            $details = $use->first_name;
            $updat = User::where('email', $email)
                ->update([
                    "user_activation_code" => 1, "status" => 3
                ]);
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Un Suspended ' . $use->email . ' Account ',
            ]);
            $arr = [
                "user" => $this->model->show($use->user_id)
            ];

            if (($updat) and ($log->save())) {
                $user->notify(new UserDeActivation($arr));
                return redirect()->back()->with([
                    'success' => "You Have Un Suspend  $details Account Successfully",
                ]);
            }
        } else {
            // return redirect()->back()->with([
            //     'error' => "You Dont have Access To this page",
            // ]);
            return view('errors.403');
        }
    }
}
