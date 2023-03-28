<?php

namespace App\Http\Controllers;

use App\menu;
use App\tablelist;
use App\orders_pending;
use App\orders_changed;
use App\orders_confirmed;
use App\orders_cancellation;
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


class changedController extends Controller
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
            return view('/changed');//,['iop'=>$iop,'tables'=>$tables]);
            
            }
        else
            abort(403, 'Unauthorized action.');
               
    }
 


    public function store(Request $request)
    {
         
        if (Gate::allows('manager')||Gate::allows('waiter')||Gate::allows('chef')) 
        {
            date_default_timezone_set("Asia/Kathmandu");
            $iop=orders_pending::where('type','=','mn')->get();
            
            $e=0;
            $s=0;
            $qty=0;
            foreach ($iop as $i) 
            {
                
                $qty=$request->get('qty'.$i->id);
                
                if($qty!=NULL)
                {
                    $e++;
                    if($i->qty==$qty)
                        $s++;
                    else
                    {
                        if(Auth::user()->type!='Chef')
                        {
                            if($qty!=0)
                                orders_pending::where('id','=',$i->id)->update(['qty'=>$qty,'time'=> date('Y-m-d h:i.sa')]);
                            else
                                orders_pending::where('id','=',$i->id)->delete();
                        }
                        else
                        {
                            $getrow=orders_pending::where('id','=',$i->id)->get();
                            if($qty!=0)
                            {
                                $chkOchn=orders_changed::where(['table_no'=>$getrow[0]['table_no'],'f_id'=>$getrow[0]['f_id']])->get();
                                if(count($chkOchn)!=0)
                                {
                                    
                                    
                                   
                                    $newqt=$qty+$chkOchn[0]['qty'];

                                    orders_changed::where(['table_no'=>$getrow[0]['table_no'],'f_id'=>$getrow[0]['f_id']])->update(['qty'=>$newqt,'time'=> date('Y-m-d h:i.sa')]);
                                    
                                }
                                else
                                {
                                    
                                    $oc=new orders_changed;
                                    $oc->table_no= $getrow[0]['table_no'];
                                    $oc->f_id= $getrow[0]['f_id'];
                                    $oc->qty= $qty;
                                
                                    $oc->time= date('Y-m-d h:i.sa');
                                    $oc->by_user= Auth::user()->id;
                                    
                                    $oc->save();
                                    
                                    
                                }
                            }
                            else
                            {
                                $chkOC=orders_cancellation::where(['table_no'=>$getrow[0]['table_no'],'f_id'=>$getrow[0]['f_id'],'c_from'=>'chefiop'])->get();
                                if(count($chkOC)!=0)
                                {
                                    
                                    
                                    $o_newqt=$getrow[0]['qty']+$chkOC[0]['o_qty'];
                                    $n_newqt=$qty+$chkOC[0]['n_qty'];

                                    orders_cancellation::where(['table_no'=>$getrow[0]['table_no'],'f_id'=>$getrow[0]['f_id'],'c_from'=>'chefiop'])->update(['o_qty'=>$o_newqt,'n_qty'=>$n_newqt,'time'=> date('Y-m-d h:i.sa')]);
                                    
                                }
                                else
                                {
                                    
                                    $oc=new orders_cancellation;
                                    $oc->table_no= $getrow[0]['table_no'];
                                    $oc->f_id= $getrow[0]['f_id'];
                                    $oc->o_qty= $getrow[0]['qty'];
                                    $oc->n_qty= $qty;
                                    $oc->time= date('Y-m-d h:i.sa');
                                    $oc->by_user= Auth::user()->id;
                                    $oc->c_from= 'chefiop';
                                    $oc->save();
                                    
                                    
                                }
                            }
                            orders_pending::where('id','=',$i->id)->delete();
                        }
                    }            
                }

            }
            if($e==$s)

                return \Redirect::route('iop.index')
                    ->with('samevalue', 'No Qty Changed!');
            else
                return \Redirect::route('iop.index')
                    ->with('editted', 'Orders Successfully Editted!');       
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
    }
    

    public function cancel($tb)
    {
        if (Gate::allows('manager')||Gate::allows('waiter')||Gate::allows('chef')) 
        {
            date_default_timezone_set("Asia/Kathmandu");
            $opc=orders_pending::where(['table_no'=>$tb,'type'=>'mn'])->get();
            if(count($opc)!=0)
            {
                if((Auth::user()->type=='Manager')||(Auth::user()->type=='Waiter'))
                    orders_pending::where(['table_no'=>$tb,'type'=>'mn'])->delete();
                else
                {
                    $getrow=orders_pending::where(['table_no'=>$tb,'type'=>'mn'])->get();
                    

                    foreach($getrow as $g)
                    {
                        $chkOc=orders_cancellation::where(['table_no'=>$tb,'f_id'=>$g->f_id,'c_from'=>'chefiop'])->get();
                        if(count($chkOc)!=0)
                        {
                            $new_o_qty=$chkOc[0]['o_qty']+$g->qty;
                            orders_cancellation::where(['table_no'=>$tb,'f_id'=>$g->f_id,'c_from'=>'chefiop'])->update(['o_qty'=>$new_o_qty,'time'=>date('Y-m-d h:i.sa')]);

                        }
                        else
                        {
                            $oc=new orders_cancellation;
                            $oc->table_no=$tb;
                            $oc->f_id=$g->f_id;
                            $oc->o_qty=$g->qty;
                            $oc->n_qty=0;
                            $oc->time=date('Y-m-d h:i.sa');
                            $oc->by_user=Auth::user()->id;
                            $oc->c_from='chefiop';
                            $oc->save();
                        }
                    }


                    orders_pending::where(['table_no'=>$tb,'type'=>'mn'])->delete();
                }
                
                
                return \Redirect::route('iop.index')
                        ->with('editted', 'Order Successfully Cancelled!');
            }
            else
                return \Redirect::route('iop.index')
                        ->with('samevalue', 'Order Was Already Cancelled By Another User!');   
        }
        else
            abort(403, 'Unauthorized action.');

    }

     public function confirm($tb)
    {
         if (Gate::allows('chef')) 
        {
            date_default_timezone_set("Asia/Kathmandu");
            $iop=orders_pending::where(['table_no'=>$tb,'type'=>'mn'])->get();
            if(count($iop)!=0)
            {
                foreach ($iop as $i) 
                {
                    $chkOCnf=orders_confirmed::where(['table_no'=>$tb,'f_id'=>$i->f_id])->get();
                    if(count($chkOCnf)!=0)
                    {
                        $newqt=$i->qty+$chkOCnf[0]['qty'];
                        orders_confirmed::where(['table_no'=>$tb,'f_id'=>$i->f_id])->update(['qty'=>$newqt,'time'=>date('Y-m-d h:i.sa')]);
                    }
                    else
                    {
                        $oc=new orders_confirmed;
                        $oc->table_no= $tb;
                        $oc->f_id= $i->f_id;
                        $oc->qty= $i->qty;
                        $oc->time= date('Y-m-d h:i.sa');
                        $oc->by_user= Auth::user()->id;
                        $oc->save();
                        
                    }
                    orders_pending::where(['table_no'=>$tb,'type'=>'mn'])->delete();
                }
               
             

             
                
                return \Redirect::route('iop.index')
                        ->with('editted', 'Order Successfully Confirmed!');
            }
            else
                return \Redirect::route('iop.index')
                    ->with('samevalue', 'Order Was Already Confirmed By Another User!');
        }
        else
            abort(403, 'Unauthorized action.');

    }
                
            
    

    
}


