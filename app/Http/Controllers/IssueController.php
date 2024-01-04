<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Issue, User, Employers, Companies, Log};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use App\Mail\{NewIssue, IssueUpdate};

class IssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:SuperAdmin|Admin|Employer|HOD']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = Issue::where('company_id', '>', '0')->orderby('created_at', 'desc')->get();
        return view('dashboard.helpdesk.index')->with(compact('issues'));
    }

    public function show($id)
    {
        $issue = Issue::findorfail($id);
        return $issue;
    }

    public function issueDetails($id)
    {
        $issue = $this->show($id);
        if (Auth::user()->hasRole('SuperAdmin') OR (Auth::user()->hasRole('Admin'))){
            $assigned = $issue->assigned_to;
            $user_email = User::where('user_id', $assigned)->pluck('email');
            $staffs = Employers::where([['company_id', '<', '4'], ['email', '<>', $user_email]])->get();
        }elseif(Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('HOD'))){
            $user_email = Auth::user()->email;
            $company = Employers::where('email', $user_email)->pluck('company_id');
            $staffs = Employers::where([['company_id', $company[0]], ['email', '<>', $user_email]])->get();
        }
        return view('dashboard.helpdesk.issueDetails')->with(compact('issue', 'staffs'));
    }

    public function create(Request $request)
    {
        if (Auth::user()->hasRole('SuperAdmin') OR (Auth::user()->hasRole('Admin'))){
            $staffs = Employers::where('company_id', '<', '4')->get();
            return view('dashboard.helpdesk.create')->with(compact('staffs'));
        }elseif(Auth::user()->hasRole('Employer') OR (Auth::user()->hasRole('HOD'))){
            $user_email = Auth::user()->email;
            $company = Employers::where('email', $user_email)->pluck('company_id');
            $staffs = Employers::where('company_id', $company[0])->get();
            return view('dashboard.helpdesk.create')->with(compact('staffs'));
        }else{
            return view('errors.403');
        }
        
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'sender_name' => 'required|min:3|max:191',
            'sender_email' => 'required|email|max:191',
            'priority' => 'required|string|max:191',
            'category' => 'required|string|max:191',
            'assigned_to' => 'required|string|max:191',
            'message'    => 'required|min:15|max:2000',
            'completion_time' => 'required'
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $data = $request->all();

        $messagernn = stripslashes (str_replace('&quot;', '"', $request->input("message")));
        $messagern = str_replace("r\n",'', $messagernn);
        $message = nl2br($messagern);

        $data['message'] = $message;

        $assigned_email = $request->input("assigned_to");
        $user_id = User::where('email', $assigned_email)->pluck('user_id');
        $data['assigned_to'] = $user_id[0];

        if (Auth::user()->hasRole('SuperAdmin') OR (Auth::user()->hasRole('Admin'))){
            $data['company_id'] = 1;
        }else{
            $user_email = Auth::user()->email;
            $company = Employers::where('email', $user_email)->pluck('company_id');
            $data['company_id'] = $company[0];
        }

        $issue = Issue::create($data);

        $log = new Log([
            "user_id" => Auth::user()->user_id,
            "activities" => 'Submitted a complaint with ID ' . $issue->id,
        ]);

        $log->save();

        $to = config('app.help');
        $cc1 = $issue->sender_email;
        $cc2 = $assigned_email;

        try{
            Mail::to($to)->cc([$cc1, $cc2])->send( new NewIssue ($issue));
        }catch(\Exception $e){
            $error = ' Email not sent, please check your network connectivity.';
        } 

        return redirect()->route('get-issues')->with(["success" => "Issue Created and Assigned Successfully"]);
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $issue = $this->show($id);
        $this->id = $issue->id;

        $this->validate($request, [
            'comment'    => 'required|min:10|max:2000'
        ]);

        $commentrnn = stripslashes (str_replace('&quot;', '"', $request->input("comment")));
        $commentrn = str_replace("r\n",'', $commentrnn);
        $comment = nl2br($commentrn);

        $input['comment'] = $comment;

        if(empty($request->input("reassign"))){
            $old_assigned = $issue->assigned_to;
            $user_email = User::where('user_id', $old_assigned)->pluck('email');
            $assigned_email = $user_email[0];
        }else{
            $assigned_email = $request->input("reassign");
        }

        if(empty($request->input("completion_time"))){
            $input['completion_time'] = $issue->completion_time;
        }else{
            $input['completion_time'] = $request->input("completion_time");
        }

        $user_id = User::where('email', $assigned_email)->pluck('user_id');
        $input['assigned_to'] = $user_id[0];

        $log = new Log([
            "user_id" => Auth::user()->user_id,
            "activities" => 'Issue with ID ' . $id . ' was updated',
        ]);

        $issue->fill($input)->save();

        // dd($issue);
        $log->save();

        $to = config('app.help');
        $cc1 = $issue->sender_email;
        $cc2 = $assigned_email;

        $by = Auth::user()->first_name.' '.Auth::user()->last_name;

        if($request->input('send_mail') == 'Yes'){
            try{
                Mail::to($to)->cc([$cc1, $cc2])->send( new IssueUpdate ($issue, $by));
            }catch(\Exception $e){
                $error = ' Email not sent, please check your network connectivity.';
            } 
            return redirect()->route('get-issues')->with(["success" => "Issue Updated Successfully"]);
        }else{
            return redirect()->route('get-issues')->with(["success" => "Issue Updated Successfully"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('issue_id');
        if(Issue::where('id', $id)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))){
                $issue = $this->show($id);
                if(($issue->delete($id)) and ($issue->trashed())) {
                    return redirect()->route('get-issues')->with([
                        'success' => "Issue Trashed Successfully",
                    ]);
                }else {
                    return redirect()->back()->with([
                        'error' => "Oh Snap! An error occured.",
                    ]);
                }
            }else{
                return view('errors.403');
            }
        }else{
            return redirect()->back()->with([
                'error' => "$id does not Exist for any Issue",
            ]);
        }
    }

    public function restore($issue_id)
    {
        if(Issue::where('id', $issue_id)->exists()){
            if (Gate::allows('SuperAdmin', auth()->user()) OR (Auth::user()->hasRole('Admin'))) {
                Issue::withTrashed()->where('id', $issue_id)->restore();
                $indo = $this->show($issue_id);
                $id = $issue->id;

                $log = new Log([
                    "user_id" => Auth::user()->user_id,
                    "activities" => 'Restored issue with ID $id ',
                ]);
                $log->save();

                return redirect()->back()->with([
                    'success' => " You Have Restored Issue With ID $id Successfully",
                ]);
            } else {
                return view('errors.403');
            }
        }else{
            return redirect()->back()->with([
                'error' => "$unit_id does not Exist for any Industry",
            ]);
        }
    }
}
