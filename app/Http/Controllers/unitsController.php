<?php

namespace App\Http\Controllers;
use App\units;
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


class unitsController extends Controller
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
       
            $investor = units::where('status',1)->get();
        
            return view('/units',['invx' => $investor]);
            }
        else
            abort(403, 'Unauthorized action.');
    }
    
    public function store(Request $request)
    {
        if (Gate::allows('manager')) 
        {
            $name=$request->get('unit_name');         
            
            Validator::make($request->all(), [

                    'unit_name' => 'required|unique:units',
                    ])->validate();  

            $investor=new units;
            $investor->unit_name=$name;
            $investor->status=1; 
            $investor->save();

            return \Redirect::route('units.index')        
                        ->with('iadd', 'New Unit "'.$name.'" Added!');
                    
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }
    public function destroy($q)
    {
        if (Gate::allows('manager')) 
        {
            $investor=units::where('unit_name','=',$q)->update(['status' => 0]);
        
            return \Redirect::route('units.index')        
                        ->with('idel', 'Unit '.'"'.$q.'"'.' Deleted!');
        }
        else
            abort(403, 'Unauthorized action.');
    }

  
}
