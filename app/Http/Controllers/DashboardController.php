<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\{User, ClientContact, Clients, Companies, Industries, Shippers, Vendors, Employers, ClientRfq, ClientPo, LineItem, ShippingRatings, ShipperQuote, Inventory, Log};
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $company = Companies::all();
            $shipper = Shippers::all();
            $vendor = Vendors::all();
            // $client = Clients::orderBy('client_name', 'asc')->get();
            $client = DB::table('client_rfqs')->select('client_id')->distinct('client_id')->orderBy('client_id', 'asc')->get();
            // dd($client);
            $employee = Employers::all();
            $rfq = ClientRfq::orderBy('rfq_id', 'desc')->limit(400)->get();
            $rfqcount = ClientRfq::orderBy('rfq_id', 'desc')->get();
            $po = ClientPo::orderBy('po_id', 'desc')->get();
            // $comp = Clients::orderBy('client_name', 'asc')->get();
            $filter = DB::table('client_rfqs')->select('product')->distinct('product')->orderBy('product', 'asc')->get();
            return view("dashboard.index")->with([ 'filter' => $filter,
                'client' => $client, "company" => $company, 'shipper' => $shipper, 'vendor' => $vendor, "employee" => $employee,
                'rfq' => $rfq, 'rfqcount' => $rfqcount, 'po' => $po,
            ]);

        }elseif(auth()->user()->hasRole('Admin')){
            $company = Companies::where('email', Auth::user()->email)->first();
            $shipper = Shippers::where('company_id', $company->company_id)->get();
            $vendor = Vendors::where('company_id', $company->company_id)->orderBy('vendor_name', 'asc')->get();
            // $client = Clients::where('company_id', $company->company_id)->get();
            $client = DB::table('client_rfqs')->where('company_id', $company->company_id)->select('client_id')->distinct('client_id')->orderBy('client_id', 'asc')->get();
            $employee = Employers::where('company_id', $company->company_id)->get();
            $rfq = ClientRfq::where('company_id', $company->company_id)->orderBy('rfq_id', 'desc')->limit(400)->get();
            $rfqcount = ClientRfq::where('company_id', $company->company_id)->orderBy('rfq_id', 'desc')->get();
            $po = ClientPo::where('company_id', $company->company_id)->orderBy('po_id', 'desc')->get();
            // $comp = Clients::where('company_id', $company->company_id)->orderBy('client_name', 'asc')->get();
            $filter = DB::table('client_rfqs')->where('company_id', $company->company_id)->select('product')->distinct('product')->orderBy('product', 'asc')->get();
            return view("dashboard.index")->with([ 'filter' => $filter,
                'client' => $client, "company" => $company, 'shipper' => $shipper, 'vendor' => $vendor, "employee" => $employee,
                'rfq' => $rfq, 'rfqcount' => $rfqcount, 'po' => $po
            ]);
        }elseif(auth()->user()->hasRole('Employer') OR (auth()->user()->hasRole('HOD'))){
            $user = User::where('email', Auth::user()->email)->first();
            // $permission = Permission::create(['name' => 'Add Client', 'name' => 'Edit Client']);
            if(auth()->user()->hasAnyDirectPermission(['Add Client', 'Edit Client'])){
            }else{
                auth()->user()->givePermissionTo([
                    'Add Client', 'Edit Client'
                ]);
            }
            $employee = Employers::where('email', Auth::user()->email)->first();
            $company = Companies::where('company_id', $employee->company_id)->first();

            $rfq = ClientRfq::where('company_id', $employee->company_id)->orderBy('created_at','desc')->limit(400)->get();
            $rfqcount = ClientRfq::where('company_id', $employee->company_id)->orderBy('created_at','desc')->get();
            // $client = Clients::where('company_id', $company->company_id)->orderBy('client_name', 'asc')->get();
            $client = DB::table('client_rfqs')->where('company_id', $company->company_id)->select('client_id')->distinct('client_id')->orderBy('client_id', 'asc')->get();
            $po = ClientPo::where('company_id', $company->company_id)->orderBy('po_id', 'desc')->get();
            // $comp =  Clients::where('company_id', $company->company_id)->orderBy('client_name', 'asc')->get();
            $vendor = Vendors::where('company_id', $company->company_id)->orderBy('vendor_name', 'asc')->get();
            $shipper = Shippers::where('company_id', $company->company_id)->orderBy('shipper_name', 'asc')->get();
            $filter = DB::table('client_rfqs')->where('company_id', $company->company_id)->select('product')->distinct('product')->orderBy('product', 'asc')->get();
            return view("dashboard.index")->with([ 'filter' => $filter,
                "rfq" => $rfq, "employee" => $employee, 'client' => $client, 'po' => $po, 'company' => $company, 
                'vendor' => $vendor, 'rfqcount' => $rfqcount, 'shipper' => $shipper
            ]);
        }elseif(auth()->user()->hasRole('Contact')){
            $contact = ClientContact::where('email', Auth::user()->email)->first();
            $rfq = ClientRfq::where('contact_id', $contact->contact_id)->orderBy('created_at','desc')->get();
            return redirect()->back()->with([
                "error" => "Ooops!! We are working on your dashboard",
            ]);

        }elseif(auth()->user()->hasRole('Client')){

            $client = Clients::where('email', Auth::user()->email)->first();
            $rfq = ClientRfq::where('client_id', $client->client_id)->orderBy('created_at','desc')->get();
            $po = ClientPo::where('client_id', $client->client_id)->orderBy('created_at','desc')->get();
            $contact = ClientContact::where('client_id', $client->client_id)->orderBy('created_at','desc')->get();
            $line_items = LineItem::where('client_id', $client->client_id)->orderBy('created_at','desc')->get();
            $ratings = ShippingRatings::where('client_id', $client->client_id)->orderBy('created_at','desc')->get();
            return view("dashboard.index")->with([
                "rfq" => $rfq, "client" => $client, "po" => $po, "contact" => $contact, 'line_items' => $line_items, 'ratings' => $ratings
            ]);
        }elseif(auth()->user()->hasRole('Shipper')){
            $shipper = Shippers::where('contact_email', Auth::user()->email)->first();
            $rfq = ClientRfq::where('shipper_id', $shipper->shipper_id)->orderBy('created_at','desc')->get();

            return view("dashboard.index")->with([
                "rfq" => $rfq, "shipper" => $shipper,
            ]);

        }elseif(auth()->user()->hasRole('Supplier')){

            $vendor = Vendors::where('contact_email', Auth::user()->email)->first();
            $line_item = LineItem::where('vendor_id', $vendor->vendor_id)->select('rfq_id')->groupBy('rfq_id')->get();
            $rfq = ClientRfq::where('company_id', $vendor->company_id)->orderBy('created_at','desc')->get();
            return view("dashboard.index")->with([

                "vendor" => $vendor, 'rfq' => $rfq, "line_item" => $line_item
            ]);
        }elseif(Auth::user()->hasRole('Warehouse User')){
            $deed = getUserWareHouse(Auth::user()->user_id);
            $warehouse_id = $deed->warehouse_id;
            $rest = getWareHouse($warehouse_id);
            $inventory= Inventory::where('warehouse_id', $warehouse_id)->orderBy('created_at', 'desc')->get();
            return view("dashboard.index")->with([
                'inventory' => $inventory, 'rest' => $rest
            ]);
        }else{
            return redirect()->back()->with([
                "error" => "Ooops!! No Account Was Found for you",
            ]);
        }
    }

    public function changePassword()
    {
        if(User::where('email', Auth::user()->email)->exists()){
            $user = User::where('email', Auth::user()->email)->first();
            return view("dashboard.users.changePassword")->with([
                'user' => $user,
            ]);
        }else{
            return redirect()->back()->with([
                'error' => " Invalid Email",
            ]);
        }
    }

    public function updatePassword(Request $request, $user_id)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'min:4', 'max:10', 'confirmed'],
        ]);
        $datu = User::where('user_id', $user_id)->update([
            "password" => Hash::make($request->input("password")),
        ]);

        if(!empty($datu)){
            $log = new Log([
                "user_id" => Auth::user()->user_id,
                "activities" => 'Changed Password',
            ]);
            $log->save();
            return redirect()->route("dashboard.index")->with([
                "success" =>  "Password Changed Successfully"
            ]);
        }else{
            return redirect()->back()->with("error", "Network Failure");
        }


    }

    public function activityLog()
    {
        if (Gate::allows('SuperAdmin', auth()->user())) {
            $log = Log::orderBy('log_id', 'desc')->get();
        }else{
            $log = Log::where('user_id' , Auth::user()->user_id)->orderBy('log_id', 'desc')->get();
        }
        return view("dashboard.activity.index")->with([
            'log' => $log,
        ]);
    }


}
