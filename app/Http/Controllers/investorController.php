<?php

namespace App\Http\Controllers;
use App\investor;
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


class investorController extends Controller
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
       
            $investor = investor::where('status',1)->get();
        
            return view('/investor',['invx' => $investor]);
            }
        else
            abort(403, 'Unauthorized action.');
    }
    
    public function store(Request $request)
    {
        if (Gate::allows('manager')) 
        {
            $name=$request->get('name');         
            
            Validator::make($request->all(), [

                    'name' => 'required|unique:investor',
                    ])->validate();  

            $investor=new investor;
            $investor->name=$name;
            $investor->status=1; 
            $investor->save();

            return \Redirect::route('investor.index')        
                        ->with('iadd', 'New Investor "'.$name.'" Added!');
                    
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }
    public function destroy($q)
    {
        if (Gate::allows('manager')) 
        {
            $investor=investor::where('name','=',$q)->update(['status' => 0]);
        
            return \Redirect::route('investor.index')        
                        ->with('idel', 'Investor '.'"'.$q.'"'.' Deleted!');
        }
        else
            abort(403, 'Unauthorized action.');
    }

  
}
