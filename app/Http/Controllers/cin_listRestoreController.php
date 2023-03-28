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


class cin_listRestoreController extends Controller
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
       
            $investor = cin_list::where('status',0)->get();
        
            return view('/cin_listRestore',['invx' => $investor]);
            }
        else
            abort(403, 'Unauthorized action.');
    }
    
    
    public function destroy($q)
    {
        if (Gate::allows('manager')) 
        {
            $investor=cin_list::where('name','=',$q)->update(['status' => 1]);
        
            return \Redirect::route('cin_list.index')        
                        ->with('ires', 'Cash Source '.'"'.$q.'"'.' Restored!');
        }
        else
            abort(403, 'Unauthorized action.');
    }

  
}
