<?php

namespace App\Http\Controllers;
use App\cin_list;
use App\cin_others;
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


class cin_othersController extends Controller
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
           
            $inv = cin_list::where('status','=',1)->get();
            return view('/cin_others',['invx' => $inv]);
            
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
            
            $investor=cin_list::where('name','=',$inv)->get();
            foreach ($investor as $invstr) {
                $inv_id=$invstr->id;
            }
            $cu_amt=cin_others::max('cu_amt');
            $cu_amt+=$amt;
            
            
                       
            $investments=new cin_others;
            $investments->date=date("Y-m-d");
            $investments->f_id=$inv_id;
            $investments->amt=$amt;           
            $investments->cu_amt=$cu_amt; 
            $investments->save();

            return \Redirect::route('cin_othersReport.index')        
                        ->with('invadded', 'Rs. '.$amt.' Received From: '.$inv.'!');
                    
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }

    
}

