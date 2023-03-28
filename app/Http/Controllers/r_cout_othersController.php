<?php

namespace App\Http\Controllers;
use App\cout_list;
use App\r_cout_others;
use App\cout_others;
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


class r_cout_othersController extends Controller
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
           
            $inv = cout_list::where('status','=',1)->get();
            return view('/r_cout_others',['invx' => $inv]);
            
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
            
            $investor=cout_list::where('name','=',$inv)->get();
            foreach ($investor as $invstr) {
                $inv_id=$invstr->id;
            }

            $inv_amt=cout_others::where('f_id','=',$inv_id)->get();

            $total_inv=0;
            foreach($inv_amt as $invamt)
            {
                $total_inv+=$invamt->amt;
            }

            $rinv_amt=r_cout_others::where('f_id','=',$inv_id)->get();

            $total_rinv=0;
            foreach($rinv_amt as $rinvamt)
            {
                $total_rinv+=$rinvamt->amt;
            }

            $new_total_rinv=$total_rinv+$amt;
            if($total_inv>=$new_total_rinv)
            {
               
                $cu_amt=r_cout_others::max('cu_amt');
                $cu_amt+=$amt;
                
                
                           
                $investments=new r_cout_others;
                $investments->date=date("Y-m-d");
                $investments->f_id=$inv_id;
                $investments->amt=$amt;           
                $investments->cu_amt=$cu_amt; 
                $investments->save();

                return \Redirect::route('cout_othersReport.index')        
                            ->with('invadded', 'Rs. '.$amt.' Returned For The Expense : '.$inv.'!');
            }
            else
                return \Redirect::route('r_cout_others.index')        
                            ->with('rcouterror', 'Amount Returned For Expense '.$inv.' Will Be Greater Than Spent Amount! Please Input Correct Value.');

                    
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }

    
}

