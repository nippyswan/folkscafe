<?php

namespace App\Http\Controllers;


use Illuminate\Http\File;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Stevebauman\EloquentTable\TableTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class backupController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */

    
    public function index()
    {
        if (Gate::allows('manager')) 
        {
            $out1=shell_exec('c:\wamp\bin\mysql\mysql5.7.23\bin\mysqldump -u root -pAnojNippy156 folkscafe > c:\wamp\www\folkscafe\storage\app\folkscafe.sql');
            $db = Storage::disk('local')->get('folkscafe.sql');
            $encrypted = Crypt::encryptString($db);

            //$decrypted = Crypt::decryptString($encrypted);
            Storage::put('encr.sql',$encrypted);


            date_default_timezone_set("Asia/Kathmandu");

            return Storage::disk('public')->download('encr.sql', 'folkscafeBackup'.date("Y-m-d-H-i-s").'.fcb');
        }
        else
            abort(403, 'Unauthorized action.');
            
        
        
    }
   
    
}
