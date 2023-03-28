<?php

namespace App\Http\Controllers;

use App\menu;
use App\tablelist;
use App\orders_pending;
use App\orders_served;

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


class popController extends Controller
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
     

            /*$tables=orders_pending::where('orders_pending.type','=','mn')->select('table_no')->distinct()->get();

            $iop=orders_pending::where('orders_pending.type','=','mn')
            ->join('menu', 'orders_pending.f_id', '=', 'menu.id')
            ->join('tablelist', 'orders_pending.table_no', '=', 'tablelist.id')
            ->join('units', 'menu.f_id', '=', 'units.id')

            ->select('menu.name as mname','menu.sp','units.unit_name', 'tablelist.table_no','orders_pending.qty','orders_pending.by_user')

            ->get();


*/
            return view('/pop');//,['iop'=>$iop,'tables'=>$tables]);
            
            }
        else
            abort(403, 'Unauthorized action.');
               
    }
 


    public function store(Request $request)
    {
         
        if (Gate::allows('manager')||Gate::allows('waiter')) 
        {
            date_default_timezone_set("Asia/Kathmandu");
            $pop=orders_pending::where('type','=','pd')->get();
            
            $e=0;
            $s=0;
            $qty=0;
            foreach ($pop as $i) 
            {
                
                $qty=$request->get('qty'.$i->id);
                
                if($qty!=NULL)
                {
                    $e++;
                    if($i->qty==$qty)
                        $s++;
                    else
                    {
                        
                        if($qty!=0)
                            orders_pending::where('id','=',$i->id)->update(['qty'=>$qty,'time'=> date('Y-m-d h:i.sa')]);
                        else
                            orders_pending::where('id','=',$i->id)->delete();
                        
                        
                    }            
                }

            }
            if($e==$s)

                return \Redirect::route('pop.index')
                    ->with('samevalue', 'No Qty Changed!');
            else
                return \Redirect::route('pop.index')
                    ->with('editted', 'Orders Successfully Editted!');       
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
    }
    

     public function cancel($tb)
    {
        if (Gate::allows('manager')||Gate::allows('waiter')) 
        {
            date_default_timezone_set("Asia/Kathmandu");
            $opc=orders_pending::where(['table_no'=>$tb,'type'=>'pd'])->get();
            if(count($opc)!=0)
            {
              
                    orders_pending::where(['table_no'=>$tb,'type'=>'pd'])->delete();
                
                
                
                return \Redirect::route('pop.index')
                        ->with('editted', 'Order Successfully Cancelled!');
            }
            else
                return \Redirect::route('pop.index')
                        ->with('samevalue', 'Order Was Already Cancelled By Another User!');   
        }
        else
            abort(403, 'Unauthorized action.');

    }

     public function serve($tb)
    {
         if (Gate::allows('manager')||Gate::allows('waiter'))
        {
            date_default_timezone_set("Asia/Kathmandu");
            $pop=orders_pending::where(['table_no'=>$tb,'type'=>'pd'])->get();
            if(count($pop)!=0)
            {
                foreach ($pop as $i) 
                {
                    $chkOCnf=orders_served::where(['table_no'=>$tb,'f_id'=>$i->f_id])->get();
                    if(count($chkOCnf)!=0)
                    {
                        $newqt=$i->qty+$chkOCnf[0]['qty'];
                        orders_served::where(['table_no'=>$tb,'f_id'=>$i->f_id])->update(['qty'=>$newqt,'time'=>date('Y-m-d h:i.sa')]);
                    }
                    else
                    {
                        $oc=new orders_served;
                        $oc->table_no= $tb;
                        $oc->f_id= $i->f_id;
                        $oc->qty= $i->qty;
                        $oc->time= date('Y-m-d h:i.sa');
                        $oc->by_user= Auth::user()->id;
                        $oc->save();
                        
                    }
                    orders_pending::where(['table_no'=>$tb,'type'=>'pd'])->delete();
                }
               
             

             
                
                return \Redirect::route('pop.index')
                        ->with('editted', 'Order Successfully Served!');
            }
            else
                return \Redirect::route('pop.index')
                    ->with('samevalue', 'Order Was Already Served By Another User!');
        }
        else
            abort(403, 'Unauthorized action.');

    }
                
            
    

    
}


