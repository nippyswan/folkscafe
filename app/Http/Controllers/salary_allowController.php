<?php

namespace App\Http\Controllers;
use App\salary;
use App\allowance;

use App\User;
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


class salary_allowController extends Controller
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
    public function index()
    {
        if (Gate::allows('manager')) 
            {
           
            $inv = User::where('status','=',1)->get();
            return view('/salary_allow',['invx' => $inv]);
            
            }
        else
            abort(403, 'Unauthorized action.');
               
    }
 


   public function store(Request $request)
    {
        if (Gate::allows('manager')) 
        {
            date_default_timezone_set("Asia/Kathmandu");
            $inv=$request->get('inv');
            $amt=$request->get('amt');
            $ty=$request->get('ty');

            if($ty==="Salary")
            {
                $investor=User::where('username','=',$inv)->get();
                foreach ($investor as $invstr) {
                    $inv_id=$invstr->id;
                }
                $cu_amt=salary::max('cu_amt');
                $cu_amt+=$amt;
                
                
                           
                $investments=new salary;
                $investments->date=date("Y-m-d");
                $investments->f_id=$inv_id;
                $investments->amt=$amt;           
                $investments->cu_amt=$cu_amt; 
                $investments->save();

                return \Redirect::route('salary_allowReport.index')        
                            ->with('invadded', 'Rs. '.$amt.' Paid To: '.$inv.' As '.$ty.'!');
            }
            else
            {
                $investor=User::where('username','=',$inv)->get();
                foreach ($investor as $invstr) {
                    $inv_id=$invstr->id;
                }
                $cu_amt=allowance::max('cu_amt');
                $cu_amt+=$amt;
                
                
                           
                $investments=new allowance;
                $investments->date=date("Y-m-d");
                $investments->f_id=$inv_id;
                $investments->amt=$amt;           
                $investments->cu_amt=$cu_amt; 
                $investments->save();

                return \Redirect::route('salary_allowReport.index')        
                            ->with('invadded', 'Rs. '.$amt.' Paid To: '.$inv.' As '.$ty.'!');
                    
            }   
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }

    
}

