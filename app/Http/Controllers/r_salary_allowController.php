<?php

namespace App\Http\Controllers;
use App\salary;
use App\allowance;
use App\r_salary;
use App\r_allowance;
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


class r_salary_allowController extends Controller
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
            return view('/r_salary_allow',['invx' => $inv]);
            
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

                $inv_amt=salary::where('f_id','=',$inv_id)->get();

                $total_inv=0;
                foreach($inv_amt as $invamt)
                {
                    $total_inv+=$invamt->amt;
                }

                $rinv_amt=r_salary::where('f_id','=',$inv_id)->get();

                $total_rinv=0;
                foreach($rinv_amt as $rinvamt)
                {
                    $total_rinv+=$rinvamt->amt;
                }

                $new_total_rinv=$total_rinv+$amt;
                if($total_inv>=$new_total_rinv)
                {
                    $cu_amt=r_salary::max('cu_amt');
                    $cu_amt+=$amt;
                    
                    
                               
                    $investments=new r_salary;
                    $investments->date=date("Y-m-d");
                    $investments->f_id=$inv_id;
                    $investments->amt=$amt;           
                    $investments->cu_amt=$cu_amt; 
                    $investments->save();

                    return \Redirect::route('r_salary_allowReport.index')        
                                ->with('invadded', 'Rs. '.$amt.' Paid To: '.$inv.' As '.$ty.'!');
                }
                else
                    return \Redirect::route('r_salary_allow.index')        
                            ->with('rerror', 'Amount Returned For Salary To: '.$inv.' Will Be Greater Than Paid Salary Amount! Please Input Correct Value.');
            }
            else
            {
                $investor=User::where('username','=',$inv)->get();
                foreach ($investor as $invstr) {
                    $inv_id=$invstr->id;
                }
                $inv_amt=allowance::where('f_id','=',$inv_id)->get();

                $total_inv=0;
                foreach($inv_amt as $invamt)
                {
                    $total_inv+=$invamt->amt;
                }

                $rinv_amt=r_allowance::where('f_id','=',$inv_id)->get();

                $total_rinv=0;
                foreach($rinv_amt as $rinvamt)
                {
                    $total_rinv+=$rinvamt->amt;
                }

                $new_total_rinv=$total_rinv+$amt;
                if($total_inv>=$new_total_rinv)
                {
                    $cu_amt=r_allowance::max('cu_amt');
                    $cu_amt+=$amt;
                    
                    
                               
                    $investments=new r_allowance;
                    $investments->date=date("Y-m-d");
                    $investments->f_id=$inv_id;
                    $investments->amt=$amt;           
                    $investments->cu_amt=$cu_amt; 
                    $investments->save();

                    return \Redirect::route('r_salary_allowReport.index')        
                                ->with('invadded', 'Rs. '.$amt.' Paid To: '.$inv.' As '.$ty.'!');
                }
                else
                    return \Redirect::route('r_salary_allow.index')        
                            ->with('rerror', 'Amount Returned For Allowance To: '.$inv.' Will Be Greater Than Paid Allowance Amount! Please Input Correct Value.');
                    
            }   
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }

    
}

