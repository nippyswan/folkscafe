<?php

namespace App\Http\Controllers;
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
use Illuminate\Support\Facades\Storage;


class myProfileController extends Controller
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
    
    public function index()
    {
       
       
            
        
            return view('/myProfile');
      
    }
    
    public function store(Request $request)
    {
        
            $q=$request->get('q');

            $uid=Auth::user()->id;
            if($q=="email")
            {

                $epass=$request->get('curpassword');
                $opass=User::where('id','=',$uid)->select('password')->get();
                foreach($opass as $p)
                {
                    $pass=$p->password;
                }
                if(Hash::check($epass, $pass)) 
                {
                //if(bcrypt($curu)==$current)
                    Validator::make($request->all(), [

                    'email' => 'required|email|unique:users',
                    ])->validate();

                    $email=$request->get('email');
                    User::where('id','=',$uid)->update(['email'=>$email]);
                    return \Redirect::route('myProfile.index')        
                        ->with('changed', 'Email Changed!');
                    
                }
                else
                    return \Redirect::route('pemail')        
                        ->with('notmatch', 'Password Did Not Match!');
            }
            elseif($q=="pass")
            {
                $epass=$request->get('curpassword');
                $opass=User::where('id','=',$uid)->select('password')->get();
                foreach($opass as $p)
                {
                    $pass=$p->password;
                }
                if(Hash::check($epass, $pass)) 
                {
                //if(bcrypt($curu)==$current)
                    Validator::make($request->all(), [

                    'password' => 'required|min:6|confirmed',
                    ])->validate();

                    $newpass=$request->get('password');
                    User::where('id','=',$uid)->update(['password'=>Hash::make($newpass)]);
                    return \Redirect::route('myProfile.index')        
                        ->with('changed', 'Password Changed!');
                    
                }
                else
                    return \Redirect::route('ppass')        
                        ->with('notmatch', 'Password Did Not Match!');  
            }
            else
            {

                $imgu=Auth::user()->imgurl;

                $data=$request->get('base64');
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                $fn=uniqid().'.png';

                 //file_put_contents('image64.png', $data);
                Storage::put('users/'.$fn, $data);

                //$path = request()->file('dp')->store('users');
                //$imgurl=request()->dp->hashName(); 
                $imgurl=$fn;
                Storage::disk('public')->delete('/users/'.$imgu);
                User::where('id','=',$uid)->update(['imgurl'=>$imgurl]);
                return \Redirect::route('myProfile.index')        
                        ->with('changed', 'Profile Picture Changed!');
            }
            

            
                    
                
       
        
                
            
    }
    public function destroy($q)
    {
        
            
        
            return view('myProfileEdit',['q'=>$q]);        
                        
        
    }

  
}
