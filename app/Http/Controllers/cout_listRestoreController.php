<?php

namespace App\Http\Controllers;
use App\cout_list;
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


class cout_listRestoreController extends Controller
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
       
            $investor = cout_list::where('status',0)->get();
        
            return view('/cout_listRestore',['invx' => $investor]);
            }
        else
            abort(403, 'Unauthorized action.');
    }
    
    
    public function destroy($q)
    {
        if (Gate::allows('manager')) 
        {
            $investor=cout_list::where('name','=',$q)->update(['status' => 1]);
        
            return \Redirect::route('cout_list.index')        
                        ->with('ires', 'Expense Source '.'"'.$q.'"'.' Restored!');
        }
        else
            abort(403, 'Unauthorized action.');
    }

  
}
