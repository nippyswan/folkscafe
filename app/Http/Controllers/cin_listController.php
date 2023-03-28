<?php

namespace App\Http\Controllers;
use App\cin_list;
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


class cin_listController extends Controller
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
       
            $investor = cin_list::where('status',1)->get();
        
            return view('/cin_list',['invx' => $investor]);
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

                    'name' => 'required|unique:cin_list',
                    ])->validate();  

            $investor=new cin_list;
            $investor->name=$name;
            $investor->status=1; 
            $investor->save();

            return \Redirect::route('cin_list.index')        
                        ->with('iadd', 'New Cash Source "'.$name.'" Added!');
                    
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }
    public function destroy($q)
    {
        if (Gate::allows('manager')) 
        {
            $investor=cin_list::where('name','=',$q)->update(['status' => 0]);
        
            return \Redirect::route('cin_list.index')        
                        ->with('idel', 'Cash Source '.'"'.$q.'"'.' Deleted!');
        }
        else
            abort(403, 'Unauthorized action.');
    }

  
}
