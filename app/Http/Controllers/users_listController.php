<?php

namespace App\Http\Controllers;
use App\User;
use App\salary_list;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Stevebauman\EloquentTable\TableTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class users_listController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
        return view('home');
    }*/
    
    public function index(Request $request)
    {
        if (Gate::allows('manager')) 
            {
                $distinct=User::where('status','=',1)
                ->select('id')
                ->get();

                

                foreach ($distinct as $ds) {
                    $ldt=salary_list::where('f_id','=',$ds->id)->select('from_date')->get();
                   
                   
                    $ldtz=date_create("1992-12-27");
                                     
                    foreach ($ldt as $ldtx) {
                        $ldty=$ldtx->from_date;
                    
                        $ldtyc=date_create($ldty);
                        
                       $diff=date_diff($ldtz,$ldtyc);
                        if($diff->format("%R%")==='+')
                        $ldtz=$ldtyc;

                    }
                    
                    
                    $ds->from_date=$ldtz->format("Y-m");
                   // echo $ds->id."+".$ds->from_date."+";
                }
                foreach ($distinct as $ds) {
                    $salary_amt=salary_list::where('f_id','=',$ds->id)
                    ->where('from_date','=',$ds->from_date)
                    ->select('salary_amt')
                    ->get();
                    foreach ($salary_amt as $key) {
                        $ds->salary_amt=$key->salary_amt;
                    }
                   
                   
                }
                foreach ($distinct as $ds) {
                    $unty=User::where('id','=',$ds->id)
                    ->select('username','type')
                    ->get();
                    foreach ($unty as $key) {
                        $ds->username=$key->username;
                        $ds->type=$key->type;
                    }
                    $long_date=date_create($ds->from_date);
                    $ds->from_date=$long_date->format("M Y");
                }

          

                  
                    
            return view('/users_list',['invx' => $distinct]);
            }
        else
            abort(403, 'Unauthorized action.');
    }
    
    public function store(Request $request)
    {
        if (Gate::allows('manager')) 
        {
           $id=$request->get('id');
           $username=$request->get('username');
           $type=$request->get('type');
           $salary_amt=$request->get('salary_amt');
           $from_date=$request->get('from_date');

           if($salary_amt===NULL&&$from_date===NULL)
            {
                $oldtype=User::where('id','=',$id)->select('type')->get();
                foreach ($oldtype as $key) {
                    $oldtypex=$key->type;
                }
                if($oldtypex!==$type)
                {
                    User::where('id','=',$id)->update(['type'=>$type]);
                    return \Redirect::route('users_list.index')        
                                ->with('iadd', 'Post of Employee "'.$username.'" Changed To: '.$type);  
                }
                else
                    return \Redirect::route('users_list.index')        
                                ->with('ierror', 'New Post Is Same As Old Post!');
            }
            elseif($salary_amt!==NULL&&$from_date!==NULL)
            {

                $check_from_date=salary_list::select('from_date')
                ->where('f_id','=',$id)
                ->where('from_date','=',$from_date)
                ->get();

                foreach($check_from_date as $k)
                    $lfd=$k->from_date;

                              

                if(!isset($lfd))
                {

                    User::where('id','=',$id)->update(['type'=>$type]);                 


                   $salary_list=new salary_list;
                   $salary_list->f_id=$id;
                   $salary_list->salary_amt=$salary_amt;
                   $salary_list->from_date=$from_date;
                   $salary_list->save();

                   $from_d=date_create($from_date);
                   $from_date=$from_d->format("M Y");

                   return \Redirect::route('users_list.index')        
                                ->with('iadd', 'Type = '.$type.', New Salary = '.$salary_amt.' effective from New Date: '.$from_date.' Set For Employee / User "'.$username.'"');
                }
                else
                {
                    User::where('id','=',$id)->update(['type'=>$type]); 
                    salary_list::where('f_id','=',$id)
                    ->where('from_date','=',$from_date)
                    ->update(['salary_amt'=>$salary_amt]); 

                    $from_d=date_create($from_date);
                    $from_date=$from_d->format("M Y");
                    return \Redirect::route('users_list.index')        
                                ->with('iadd', 'Type = '.$type.', New Salary = '.$salary_amt.' effective from Already Set Date: '.$from_date.' Set For Employee / User "'.$username.'"');
                }
            }
            else
                return \Redirect::route('users_list.index')        
                                ->with('ierror', 'Please Enter Values For Both Salary & From Date!');   
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }
    public function destroy($q)
    {
        if (Gate::allows('manager')) 
        {
            User::where('username','=',$q)->update(['status' => 0]);
        
            return \Redirect::route('users_list.index')        
                        ->with('idel', 'Employee / User '.'"'.$q.'"'.' Deleted!');
        }
        else
            abort(403, 'Unauthorized action.');
    }

  
}
