<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
      

    }
    

    public function showRegistrationForm()
    {
        $user=Auth::user();
        if(Gate::allows('manager', $user))
        return view('auth.register');
        abort(403, 'Unauthorized action.');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
           'username' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'type' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    //protected function create(Request $request)

    {
        date_default_timezone_set("Asia/Kathmandu");
        
         
        if(request()->file('dp')!=NULL)
        {
            
            //$path = request()->file('dp')->store('users');
            //$imgurl=request()->dp->hashName(); 

            $dt=$data['base64'];

            //$data=$request->get('base64');
            list($type, $dt) = explode(';', $dt);
            list(, $dt)      = explode(',', $dt);
            $dt = base64_decode($dt);

            $fn=uniqid().'.png';

             //file_put_contents('image64.png', $data);
            Storage::put('users/'.$fn, $dt);

            //$path = request()->file('dp')->store('users');
            //$imgurl=request()->dp->hashName(); 
            $imgurl=$fn;


            return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'status' =>1,
            'imgurl' =>$imgurl,
            
        ]);
            
            
        }
        else
        {

           
                
            return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'status' =>1,
            'imgurl' =>NULL,
        ]);
        }


        /*return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type'],
            'status' =>1,
        ]);*/
    }
}
