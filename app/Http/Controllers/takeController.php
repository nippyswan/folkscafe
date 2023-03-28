<?php

namespace App\Http\Controllers;

use App\menu;
use App\tablelist;
use App\orders_pending;
use App\units;
use App\category;
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
use Symfony\Component\HttpFoundation\StreamedResponse;


class takeController extends Controller
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
        if (Gate::allows('manager')||Gate::allows('waiter')) 
            {
     

            $invx=tablelist::all();

            $menulist = menu::where('menu.status','=',1)
                ->where('type','=',"mn")
                ->orWhere('type','=',"pd")
                ->join('units', 'menu.f_id', '=', 'units.id')
                ->join('category', 'menu.f_cat', '=', 'category.id')
                ->select('menu.name as mname','menu.imgurl', 'units.unit_name', 'category.name as cname','menu.id','menu.type','menu.sp')
                ->get();


         
            $category=array();
            
          
            

            foreach ($menulist as $key) 
            {
                for($j=0;$j<count($category);$j++)
                {

                    if($key->cname!=$category[$j])
                        continue;
                    else 
                        break;
                    
                }
                if($j==count($category))
                $category[$j]=$key->cname;               
                
                    
            }

            foreach ($menulist as $key) {
                    if($key->type=="pd")
                    {
                        $exists = Storage::disk('public')->exists('/products/'.$key->imgurl);
                    
                        if($exists!=1)
                            $key->imgurl=NULL;
                    }
                    else
                    {

                        $exists = Storage::disk('public')->exists('/menus/'.$key->imgurl);
                    
                        if($exists!=1)
                            $key->imgurl=NULL;
                    }

                    
            }

        

            return view('/take',['menulist'=>$menulist,'category'=>$category,'invx'=>$invx]);
            
            }
        else
            abort(403, 'Unauthorized action.');
               
    }
 


   public function store(Request $request)
    {
        date_default_timezone_set("Asia/Kathmandu");
        if (Gate::allows('manager')||Gate::allows('waiter')) 
        {
            $jsondata=$request->get('jsondata');
            $table=$request->get('table');
            $decdata=json_decode($jsondata);
            foreach($decdata as $dd)
            {
                $name=lcfirst($dd->n);
                $menu=menu::where('name','=',$name)->select('id','type')->get();
                $by_user=User::where('username','=',Auth::user()->username)->select('id')->get();
                $tablen=tablelist::where('table_no','=',$table)->select('id')->get();

                if($dd->q>0)
                {
                    $exist=orders_pending::where(['f_id'=>$menu[0]['id'],'table_no'=>$tablen[0]['id']])->get();
                    if(count($exist)>0)
                    {
                        $nq=$dd->q+$exist[0]['qty'];
                        orders_pending::where(['f_id'=>$menu[0]['id'],'table_no'=>$tablen[0]['id']])->update(['qty'=>$nq,'time'=>date("Y-m-d h:i a")]);
                    }
                    else
                    {
                        $opending=new orders_pending;
                        $opending->table_no=$tablen[0]['id'];
                        $opending->f_id=$menu[0]['id'];
                        $opending->qty=$dd->q;
                        $opending->type=$menu[0]['type'];
                        $opending->time=date("Y-m-d h:i a");
                        $opending->by_user=$by_user[0]['id'];
                        $opending->save();
                    }
                }


            }





            return \Redirect::route('take.index')
                            ->with('taken', 'Orders Successfully Received!');       
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
    }
        
                
            
    

    
}

