<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{User, Log, Warehouse, UserWarehouse};
use DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserActivation;
use App\Notifications\UserDeActivation;

class InventoryUserController extends Controller
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
            $user = User::where('role', 'Warehouse User')->orderBy('email', 'asc')->get();
            $warehouse = Warehouse::orderBy('name', 'asc')->get();
            return view('dashboard.inventory-users.index')->with([
                'user' => $user, 'warehouse' => $warehouse
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
    public function users($warehouse_id)
    {
        if(UserWarehouse::where('warehouse_id', $warehouse_id)->exists()){
            // if(Auth::user()->hasRole('Warehouse User')){
                $rest = getWareHouse($warehouse_id);
                $user = UserWarehouse::where('warehouse_id', $warehouse_id)->orderBy('created_at', 'desc')->get();
                return view('dashboard.warehouse.users')->with([
                    'user' => $user, 'rest' => $rest, 'warehouse_id' => $warehouse_id
                ]);
            // } else {
            //     return view('errors.403');
            // }
        }else{
            return redirect()->back()->with(['error' => "No User was found for The Warehouse"]);
        }
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
                'warehouse' => ['required', 'string', 'max:199'],
            ]);
            $role = 'Warehouse User';

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
                $newData = new UserWarehouse([
                    'user_id' => $data->user_id,
                    'warehouse_id' => $request->input("warehouse"),
                ]); $newData->save();
                return redirect()->route("inventory.user.index")->with("success", "You Have Added "
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
        if(User::where(['email' => $email, 'role' => 'Warehouse User'])->exists()){
            if (Gate::allows('Administrator', auth()->user())) {
                $user = User::where('role', 'Warehouse User')->orderBy('email', 'asc')->get();
                $details =User::where('email', $email)->first();
                // $house = UserWarehouse::where
                $warehouse = Warehouse::orderBy('name', 'asc')->get();
                return view('dashboard.inventory-users.edit')->with([
                    'user' => $user, 'warehouse' => $warehouse, 'details' => $details
                ]);
            } else {
                return view('errors.403');
            }
        }else{
            return redirect()->back()->with([
                'error' => "$email does not exists",
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
    public function update(Request $request, $user_id)
    {
        $this->validate($request, [
            'first_name' => ['required', 'string', 'max:199'],
            'phone_number' => ['required', 'string', 'max:199'],
            'email' => ['required', 'string', 'email', 'max:199'],
            'last_name' => ['required', 'string', 'max:199'],
            'warehouse' => ['required', 'string', 'max:199'],
        ]);
        $role = 'Warehouse User';
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
        DB::table('model_has_roles')->where('model_id', $user_id)->delete();
        if ($this->model->update($data, $user_id) and ($log->save())) {
            $user->assignRole($role);
            $datu = UserWarehouse::where('user_id', $user_id)->update(['warehouse_id' => $request->input("warehouse")]);
            return redirect()->route("inventory.user.index")->with("success", "You Have Updated "
                . $request->input("email") . " Details Successfully");
        } else {
            return redirect()->back()->with("error", "Network Failure");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
