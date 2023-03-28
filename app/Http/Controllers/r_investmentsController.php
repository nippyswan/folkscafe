<?php

namespace App\Http\Controllers;
use App\investor;
use App\r_investments;
use App\investments;
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


class r_investmentsController extends Controller
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
           
            $inv = investor::where('status','=',1)->get();
            return view('/r_investments',['invx' => $inv]);
            
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
            
            $investor=investor::where('name','=',$inv)->get();
            foreach ($investor as $invstr) {
                $inv_id=$invstr->id;
            }

            $inv_amt=investments::where('f_id','=',$inv_id)->get();

            $total_inv=0;
            foreach($inv_amt as $invamt)
            {
                $total_inv+=$invamt->amt;
            }

            $rinv_amt=r_investments::where('f_id','=',$inv_id)->get();

            $total_rinv=0;
            foreach($rinv_amt as $rinvamt)
            {
                $total_rinv+=$rinvamt->amt;
            }

            $new_total_rinv=$total_rinv+$amt;
            if($total_inv>=$new_total_rinv)
            {
                $cu_amt=r_investments::max('cu_amt');
                $cu_amt+=$amt;
            
            
                       
                $r_investments=new r_investments;
                $r_investments->date=date("Y-m-d");
                $r_investments->f_id=$inv_id;
                $r_investments->amt=$amt;           
                $r_investments->cu_amt=$cu_amt; 
                $r_investments->save();

                return \Redirect::route('invpayReport.index')        
                            ->with('invadded', 'Rs. '.$amt.' Investment Returned To: '.$inv.'!');
            }
            else
                return \Redirect::route('r_investments.index')        
                            ->with('rinverror', 'Amount Returned To '.$inv.' Will Be Greater Than Invested Amount! Please Input Correct Value.');

                    
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }

    
}

