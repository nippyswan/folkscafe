<?php

namespace App\Http\Controllers;

use App\menu;
use App\tablelist;
use App\orders_pending;
use App\orders_changed;
use App\orders_confirmed;
use App\units;
use App\category;
use App\User;
use App\pending_buttons;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class sseController extends Controller
{
   
   /* public function __construct()
    {
        $this->middleware('auth');
    }
*/
  


    public function menuBadge()
    {
    	
        
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        while (true) 
        {
            
        
	        $pending=orders_pending::all();
	        if($pending!=NULL)
	        {
	            //$tables=DB::table('orders_pending')->distinct()->get(['table_no']);
	            //echo count($tables);  
	            //$nt=count($tables); 
	            $iop=orders_pending::where('type','=','mn')->distinct()->get(['table_no']);
	            $pop=orders_pending::where('type','=','pd')->distinct()->get(['table_no']);
	            if(Auth::user()->type=='Chef')
	            {
	            	$nt=count($iop);
	            }
	            elseif(Auth::user()->type=='Waiter')
	            	$nt=count($iop)+count($pop);
	            else
	            {
	            	$nt=count($iop)+count($pop);
	            }
	            $ntiop=count($iop);
	            $ntpop=count($pop);
	            //$nt=500000;
	            // $time = date('r');
	            
	            //echo "data: my  {$time}\n\n";
	            echo "retry: 1000". PHP_EOL;
	            echo "data:{$nt},{$ntiop},{$ntpop}". PHP_EOL;
	            echo PHP_EOL;
	            ob_end_flush();
	            flush();
	             
	        }
		}
 		



    }

	public function iopES($bt,$tb,$user)
	{
	    	
        date_default_timezone_set("Asia/Kathmandu");
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        while (true) 
        {
        	$ip = getenv("REMOTE_ADDR") ; 
        	//$MAC = getenv("REMOTE_HOST") ; 
  
			
        	$editting=0;
        	$dltPb=pending_buttons::all();
        	foreach ($dltPb as $key) 
        	{
        		$dltTime=$key->time;
        		$cdate=date('Y-m-d h:i.sa');
        		$diff=strtotime($cdate)-strtotime($dltTime);
        		if($diff>30)
        		{
        			pending_buttons::where('id','=',$key->id)->delete();
        		}

        	}
        	if($bt==0)
        	{
        		$chkPb=pending_buttons::where(['by_user'=>$user,'by_ip'=>$ip])
            		->delete();
        	}
        	if($bt==1)//edit
            {
            	$chkPb=pending_buttons::where(['table_n'=>$tb,'bt_type'=>$bt,'m_type'=>1,'by_user'=>$user,'by_ip'=>$ip])
            		->get();
            	if(count($chkPb)!=0)//found
            	{
            		
            			pending_buttons::where('id',$chkPb[0]['id'])->update(['time'=>date('Y-m-d h:i.sa')]);
            			$editting=1;
            		

            		
            	}
            	else
            	{
	            	$pbt=new pending_buttons;
	            	$pbt->table_n=$tb;
	            	$pbt->bt_type=$bt;
	            	$pbt->m_type=1;//menu item
	            	$pbt->time=date('Y-m-d h:i.sa');
	            	$pbt->by_user=$user;
	            	$pbt->by_ip=$ip;
	            	$pbt->save();
            	}
            }
        	$pb=pending_buttons::where('m_type','=','1')->get();
        	
        	$tables=orders_pending::where('orders_pending.type','=','mn')->select('table_no')->distinct()->get();

            $iop=orders_pending::where('orders_pending.type','=','mn')
            ->join('menu', 'orders_pending.f_id', '=', 'menu.id')
            ->join('tablelist', 'orders_pending.table_no', '=', 'tablelist.id')
            ->join('units', 'menu.f_id', '=', 'units.id')

            ->select('menu.name as mname','menu.sp','units.unit_name', 'tablelist.table_no','orders_pending.qty','orders_pending.by_user','orders_pending.id')

            ->get();
            $html='';
            $found=0;
            $i=0;
            $normalTable=array();
            foreach($tables as $t)
	     	{
	     		foreach ($pb as $p ) 
            	{
            		if($p->table_n==$t->table_no)
            			$found=1;
            	}
            	if($found==0)
            		$normalTable[$i++]=$t->table_no;
            	$found=0;
	     	}

	     	
	     	if(count($pb)!=0)//if a table is being editted by a user
            {
            	
            	if($bt==0)//if the current user is not editting any table
            	{
	            	foreach($tables as $t)//take care of being editted tables by other users
		     		{
	            		foreach ($pb as $p) 
	            		{
	            			if($p->table_n==$t->table_no)
	            			{
		            			if($p->bt_type==1)//edit button
		            			{
		            				if($user==$p->by_user)
		            					$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$t->table_no.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12">User <b>'.ucfirst($p->by_user).'</b> with IP Address: '.$p->by_ip.' is Editting the Orders<img src="'.asset('gif/dots.gif').'" height="20px"></div></div></div></div></div></div>';
		            				else	
		            				
		            					$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$t->table_no.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12">User <b>'.ucfirst($p->by_user).'</b> is Editting the Orders<img src="'.asset('gif/dots.gif').'" height="20px"></div></div></div></div></div></div>';
		            				
		            			}
	            			}
	            		}
	            	}
		            if(count($normalTable)!=0)//take care of not being editted table
		        		for($j=0;$j<count($normalTable);$j++)
		            	{	

		        			
			     			$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$normalTable[$j].'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12"><div class="table-responsive table-striped"><table class="table table-sm"><thead class="thead-dark"><tr style="background-color: #48494b; font-weight: bold; color:white;"><td align="center">Items</td><td align="center">Price</td><td align="center">Qty</td><td align="center">Total Price (Rs.)</td></tr></thead><tbody>';
			     			foreach($iop as $i)
			     			{	        			
			     				if(($i->table_no)===$normalTable[$j])
			     				{
			     					$html=$html.'<tr><td align="center">'.ucfirst($i->mname).'</td>';
				     				$html=$html.'<td align="center">'.$i->sp.'</td>';
				     				if($i->qty< 2)
				     				{
				     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'</td>';
				     				}
				     				else
				     				{
				     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'s</td>';
				     				}
				     				$html=$html.'<td align="center">'.($i->sp)*($i->qty).'</td></tr>';
				     				
				     				
					     				
						            
						            	
				     			}
		        			}
		        			$html=$html.'</tbody></table></div>';
		        			$html=$html.'<div class="row justify-content-end"><a class="btn btn-secondary mr-1" href="/iop/c/'.$normalTable[$j].'" onclick="return cnfiop()">Cancel All</a><a class="btn btn-secondary mr-1" href="#" onclick="iopES(1,'.$normalTable[$j].','."'".$user."'".')">Edit Order</a>';
				     		
				     		
							if (Gate::allows('chef')) 
			            	{	     		
			            		$html=$html.'<a class="btn btn-secondary mr-1" href="/iop/cnf/'.$normalTable[$j].'" onclick="return cnfiop()">Confirm All</a></div></div></div></div></div></div></div>';
			            	}
			            	else
			            	{
			            		$html=$html.'</div></div></div></div></div></div></div>';
			            	}
		        		}
            	}
            	else//if current user is editting a table
            	{
            		
        			if($editting!=1)//create form once
					{
    					$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$tb.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12"><form method="POST" action="/iop"><input type="hidden" name="_token" value="'.csrf_token().'"><div class="table-responsive table-striped"><table class="table table-sm"><thead class="thead-dark"><tr style="background-color: #48494b; font-weight: bold; color:white;"><td align="center">Items</td><td align="center">Price</td><td align="center" style="width:70px">Qty</td><td align="center">Total Price (Rs.)</td></tr></thead><tbody>';
    					foreach ($iop as $i) 
    					{	
    						if($i->table_no==$tb)
 							{
    						            					
		     					$html=$html.'<tr><td align="center">'.ucfirst($i->mname).'</td>';
			     				$html=$html.'<td align="center">'.$i->sp.'</td>';
			     				if($i->qty< 2)
			     				{
			     					if(Auth::user()->type=="Chef")
			     						$html=$html.'<td align="center"><input class="form-control" type="number" name="qty'.$i->id.'" min=0 max="'.$i->qty.'" value="'.$i->qty.'">'.' '.$i->unit_name.'</td>';
			     					else
			     						$html=$html.'<td align="center"><input class="form-control" type="number" name="qty'.$i->id.'" min=0 value="'.$i->qty.'">'.' '.$i->unit_name.'</td>';
			     				}
			     				else
			     				{
			     					if(Auth::user()->type=="Chef")
			     						$html=$html.'<td align="center"><input class="form-control" type="number" name="qty'.$i->id.'" min=0 max="'.$i->qty.'" value="'.$i->qty.'">'.' '.$i->unit_name.'s</td>';
			     					else
			     						$html=$html.'<td align="center"><input class="form-control" type="number" name="qty'.$i->id.'" min=0 value="'.$i->qty.'">'.' '.$i->unit_name.'s</td>';
			     				}
			     				$html=$html.'<td align="center">'.($i->sp)*($i->qty).'</td></tr>';
			     				
		     				}
	     				}
	     				$html=$html.'</tbody></table></div><div class="row justify-content-end"><a class="btn btn-secondary mr-1" href="#" onclick="iopES(0,0,'."'".$user."'".')">Cancel</a><button class="btn btn-secondary" type="submit" onclick="return cnfiop()">Submit Order</button></div></form></div></div></div></div></div></div>';
     				}
     				else//do not update form for editor user
     				{
     					$html="dontupdate";
     				}
	            		
	            	
            	}
            

        	}
        	else//if no table is editted by any user
        	{
        		foreach($tables as $t)
	     		{
		     		$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$t->table_no.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12"><div class="table-responsive table-striped"><table class="table table-sm"><thead class="thead-dark"><tr style="background-color: #48494b; font-weight: bold; color:white;"><td align="center">Items</td><td align="center">Price</td><td align="center">Qty</td><td align="center">Total Price (Rs.)</td></tr></thead><tbody>';

		     		foreach($iop as $i)
		     		{
		     			if($i->table_no==$t->table_no)
		     			{
		     				$html=$html.'<tr><td align="center">'.ucfirst($i->mname).'</td>';
		     				$html=$html.'<td align="center">'.$i->sp.'</td>';
		     				if($i->qty< 2)
		     				{
		     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'</td>';
		     				}
		     				else
		     				{
		     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'s</td>';
		     				}
		     				$html=$html.'<td align="center">'.($i->sp)*($i->qty).'</td></tr>';
		     			}
		     		}
		     		$html=$html.'</tbody></table></div><div class="row justify-content-end"><a class="btn btn-secondary mr-1" href="/iop/c/'.$t->table_no.'" onclick="return cnfiop()">Cancel All</a><a class="btn btn-secondary mr-1" href="#" onclick="iopES(1,'.$t->table_no.','."'".$user."'".')">Edit Order</a>';
		     		
		     		
					if (Gate::allows('chef')) 
	            	{	     		
	            		$html=$html.'<a class="btn btn-secondary mr-1" href="/iop/cnf/'.$t->table_no.'" onclick="return cnfiop()">Confirm All</a></div></div></div></div></div></div></div>';
	            	}
	            	else
	            	{
	            		$html=$html.'</div></div></div></div></div></div></div>';
	            	}
	            }
	     	}	
	    
	     			
	    
	     
            echo "retry: 100". PHP_EOL;
            echo "data:$html". PHP_EOL;
            echo PHP_EOL;
            ob_end_flush();
            flush();
	       
		}
	     	
	             
	        
	} 

	public function popES($bt,$tb,$user)
	{
	    	
        date_default_timezone_set("Asia/Kathmandu");
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        while (true) 
        {
        	$ip = getenv("REMOTE_ADDR") ; 
        	$editting=0;
        	$dltPb=pending_buttons::all();
        	foreach ($dltPb as $key) 
        	{
        		$dltTime=$key->time;
        		$cdate=date('Y-m-d h:i.sa');
        		$diff=strtotime($cdate)-strtotime($dltTime);
        		if($diff>30)
        		{
        			pending_buttons::where('id','=',$key->id)->delete();
        		}

        	}
        	if($bt==0)
        	{
        		$chkPb=pending_buttons::where(['by_user'=>$user,'by_ip'=>$ip])
            		->delete();
        	}
        	if($bt==1)//edit
            {
            	$chkPb=pending_buttons::where(['table_n'=>$tb,'bt_type'=>$bt,'m_type'=>2,'by_user'=>$user,'by_ip'=>$ip])
            		->get();
            	if(count($chkPb)!=0)//found
            	{
            		
            			pending_buttons::where('id',$chkPb[0]['id'])->update(['time'=>date('Y-m-d h:i.sa')]);
            			$editting=1;
            		

            		
            	}
            	else
            	{
	            	$pbt=new pending_buttons;
	            	$pbt->table_n=$tb;
	            	$pbt->bt_type=$bt;
	            	$pbt->m_type=2;//product item
	            	$pbt->time=date('Y-m-d h:i.sa');
	            	$pbt->by_user=$user;
	            	$pbt->by_ip=$ip;
	            	$pbt->save();
            	}
            }
          
        	
        	$pb=pending_buttons::where('m_type','=','2')->get();
        	
        	$tables=orders_pending::where('orders_pending.type','=','pd')->select('table_no')->distinct()->get();

            $pop=orders_pending::where('orders_pending.type','=','pd')
            ->join('menu', 'orders_pending.f_id', '=', 'menu.id')
            ->join('tablelist', 'orders_pending.table_no', '=', 'tablelist.id')
            ->join('units', 'menu.f_id', '=', 'units.id')

            ->select('menu.name as mname','menu.sp','units.unit_name', 'tablelist.table_no','orders_pending.qty','orders_pending.by_user','orders_pending.id')

            ->get();
            $html='';
            $found=0;
            $i=0;
            $normalTable=array();
            foreach($tables as $t)
	     	{
	     		foreach ($pb as $p ) 
            	{
            		if($p->table_n==$t->table_no)
            			$found=1;
            	}
            	if($found==0)
            		$normalTable[$i++]=$t->table_no;
            	$found=0;
	     	}

	     	
	     	if(count($pb)!=0)//if a table is being editted by a user
            {
            	
            	if($bt==0)//if the current user is not editting any table
            	{
	            	foreach($tables as $t)//take care of being editted tables by other users
		     		{
	            		foreach ($pb as $p) 
	            		{
	            			if($p->table_n==$t->table_no)
	            			{
		            			if($p->bt_type==1)//edit button
		            			{
		            				if($user==$p->by_user)
		            					$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$t->table_no.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12">User <b>'.ucfirst($p->by_user).'</b> with IP Address: '.$p->by_ip.' is Editting the Product Orders<img src="'.asset('gif/dots.gif').'" height="20px"></div></div></div></div></div></div>';
		            				else
		            				
		            					$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$t->table_no.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12">User <b>'.ucfirst($p->by_user).'</b> is Editting the Product Orders<img src="'.asset('gif/dots.gif').'" height="20px"></div></div></div></div></div></div>';
		            				
		            			}
	            			}
	            		}
	            	}
		            if(count($normalTable)!=0)//take care of not being editted table
		        		for($j=0;$j<count($normalTable);$j++)
		            	{	

		        			
			     			$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$normalTable[$j].'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12"><div class="table-responsive table-striped"><table class="table table-sm"><thead class="thead-dark"><tr style="background-color: #48494b; font-weight: bold; color:white;"><td align="center">Items</td><td align="center">Price</td><td align="center">Qty</td><td align="center">Total Price (Rs.)</td></tr></thead><tbody>';
			     			foreach($pop as $i)
			     			{	        			
			     				if(($i->table_no)===$normalTable[$j])
			     				{
			     					$html=$html.'<tr><td align="center">'.ucfirst($i->mname).'</td>';
				     				$html=$html.'<td align="center">'.$i->sp.'</td>';
				     				if($i->qty< 2)
				     				{
				     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'</td>';
				     				}
				     				else
				     				{
				     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'s</td>';
				     				}
				     				$html=$html.'<td align="center">'.($i->sp)*($i->qty).'</td></tr>';
				     				
				     				
					     				
						            
						            	
				     			}
		        			}
		        			$html=$html.'</tbody></table></div>';
		        			$html=$html.'<div class="row justify-content-end"><a class="btn btn-secondary mr-1" href="/pop/c/'.$normalTable[$j].'" onclick="return cnfpop()">Cancel All</a><a class="btn btn-secondary mr-1" href="#" onclick="popES(1,'.$normalTable[$j].','."'".$user."'".')">Edit Order</a>';
				     		
				     		
							     		
			            		$html=$html.'<a class="btn btn-secondary mr-1" href="/pop/cnf/'.$normalTable[$j].'" onclick="return cnfpop()">Serve All</a></div></div></div></div></div></div></div>';
			            
		        		}
            	}
            	else//if current user is editting a table
            	{
            		
        			if($editting!=1)//create form once
					{
    					$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$tb.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12"><form method="POST" action="/pop"><input type="hidden" name="_token" value="'.csrf_token().'"><div class="table-responsive table-striped"><table class="table table-sm"><thead class="thead-dark"><tr style="background-color: #48494b; font-weight: bold; color:white;"><td align="center">Items</td><td align="center">Price</td><td align="center" style="width:70px">Qty</td><td align="center">Total Price (Rs.)</td></tr></thead><tbody>';
    					foreach ($pop as $i) 
    					{	
    						if($i->table_no==$tb)
 							{
    						            					
		     					$html=$html.'<tr><td align="center">'.ucfirst($i->mname).'</td>';
			     				$html=$html.'<td align="center">'.$i->sp.'</td>';
			     				if($i->qty< 2)
			     				{
			     					$html=$html.'<td align="center"><input class="form-control" type="number" name="qty'.$i->id.'" min=0 value="'.$i->qty.'">'.' '.$i->unit_name.'</td>';
			     				}
			     				else
			     				{
			     					$html=$html.'<td align="center"><input class="form-control" type="number" name="qty'.$i->id.'" min=0 value="'.$i->qty.'">'.' '.$i->unit_name.'s</td>';
			     				}
			     				$html=$html.'<td align="center">'.($i->sp)*($i->qty).'</td></tr>';
			     				
		     				}
	     				}
	     				$html=$html.'</tbody></table></div><div class="row justify-content-end"><a class="btn btn-secondary mr-1" href="#" onclick="popES(0,0,'."'".$user."'".')">Cancel</a><button class="btn btn-secondary" type="submit" onclick="return cnfpop()">Submit Order</button></div></form></div></div></div></div></div></div>';
     				}
     				else//do not update form for editor user
     				{
     					$html="dontupdate";
     				}
	            		
	            	
            	}
            

        	}
        	else//if no table is editted by any user
        	{
        		foreach($tables as $t)
	     		{
		     		$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$t->table_no.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12"><div class="table-responsive table-striped"><table class="table table-sm"><thead class="thead-dark"><tr style="background-color: #48494b; font-weight: bold; color:white;"><td align="center">Items</td><td align="center">Price</td><td align="center">Qty</td><td align="center">Total Price (Rs.)</td></tr></thead><tbody>';

		     		foreach($pop as $i)
		     		{
		     			if($i->table_no==$t->table_no)
		     			{
		     				$html=$html.'<tr><td align="center">'.ucfirst($i->mname).'</td>';
		     				$html=$html.'<td align="center">'.$i->sp.'</td>';
		     				if($i->qty< 2)
		     				{
		     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'</td>';
		     				}
		     				else
		     				{
		     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'s</td>';
		     				}
		     				$html=$html.'<td align="center">'.($i->sp)*($i->qty).'</td></tr>';
		     			}
		     		}
		     		$html=$html.'</tbody></table></div><div class="row justify-content-end"><a class="btn btn-secondary mr-1" href="/pop/c/'.$t->table_no.'" onclick="return cnfpop()">Cancel All</a><a class="btn btn-secondary mr-1" href="#" onclick="popES(1,'.$t->table_no.','."'".$user."'".')">Edit Order</a>';
		     		
		     			     		
	            		$html=$html.'<a class="btn btn-secondary mr-1" href="/pop/cnf/'.$t->table_no.'" onclick="return cnfpop()">Serve All</a></div></div></div></div></div></div></div>';
	            	
	            	
	            }
	     	}	
	    
	     			
	    
	     
            echo "retry: 100". PHP_EOL;
            echo "data:$html". PHP_EOL;
            echo PHP_EOL;
            ob_end_flush();
            flush();
	       
		}
	     	
	             
	        
	} 


	public function changedES($bt,$tb,$user)
	{
	    	
        date_default_timezone_set("Asia/Kathmandu");
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        while (true) 
        {
        	$editting=0;
        	$dltPb=pending_buttons::all();
        	foreach ($dltPb as $key) 
        	{
        		$dltTime=$key->time;
        		$cdate=date('Y-m-d h:i.sa');
        		$diff=strtotime($cdate)-strtotime($dltTime);
        		if($diff>30)
        		{
        			pending_buttons::where('id','=',$key->id)->delete();
        		}

        	}
        	if($bt==0)
        	{
        		$chkPb=pending_buttons::where(['by_user'=>$user])
            		->delete();
        	}
        	if($bt==1)//edit
            {
            	$chkPb=pending_buttons::where(['table_n'=>$tb,'bt_type'=>$bt,'m_type'=>2])
            		->get();
            	if(count($chkPb)!=0)//found
            	{
            		if($user==$chkPb[0]['by_user'])//by the user
            		{
            			pending_buttons::where('id',$chkPb[0]['id'])->update(['time'=>date('Y-m-d h:i.sa')]);
            			$editting=1;
            		}

            		
            	}
            	else
            	{
	            	$pbt=new pending_buttons;
	            	$pbt->table_n=$tb;
	            	$pbt->bt_type=$bt;
	            	$pbt->m_type=2;//product item
	            	$pbt->time=date('Y-m-d h:i.sa');
	            	$pbt->by_user=$user;
	            	$pbt->save();
            	}
            }
        	$pb=pending_buttons::where('m_type','=','2')->get();
        	
        	$tables=orders_pending::where('orders_pending.type','=','pd')->select('table_no')->distinct()->get();

            $pop=orders_pending::where('orders_pending.type','=','pd')
            ->join('menu', 'orders_pending.f_id', '=', 'menu.id')
            ->join('tablelist', 'orders_pending.table_no', '=', 'tablelist.id')
            ->join('units', 'menu.f_id', '=', 'units.id')

            ->select('menu.name as mname','menu.sp','units.unit_name', 'tablelist.table_no','orders_pending.qty','orders_pending.by_user','orders_pending.id')

            ->get();
            $html='';
            $found=0;
            $i=0;
            $normalTable=array();
            foreach($tables as $t)
	     	{
	     		foreach ($pb as $p ) 
            	{
            		if($p->table_n==$t->table_no)
            			$found=1;
            	}
            	if($found==0)
            		$normalTable[$i++]=$t->table_no;
            	$found=0;
	     	}

	     	
	     	if(count($pb)!=0)//if a table is being editted by a user
            {
            	
            	if($bt==0)//if the current user is not editting any table
            	{
	            	foreach($tables as $t)//take care of being editted tables by other users
		     		{
	            		foreach ($pb as $p) 
	            		{
	            			if($p->table_n==$t->table_no)
	            			{
		            			if($p->bt_type==1)//edit button
		            			{
		            				
		            				
		            				$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$t->table_no.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12">User <b>'.ucfirst($p->by_user).'</b> is Editting the Product Orders<img src="'.asset('gif/dots.gif').'" height="20px"></div></div></div></div></div></div>';
		            				
		            			}
	            			}
	            		}
	            	}
		            if(count($normalTable)!=0)//take care of not being editted table
		        		for($j=0;$j<count($normalTable);$j++)
		            	{	

		        			
			     			$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$normalTable[$j].'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12"><div class="table-responsive table-striped"><table class="table table-sm"><thead class="thead-dark"><tr style="background-color: #48494b; font-weight: bold; color:white;"><td align="center">Items</td><td align="center">Price</td><td align="center">Qty</td><td align="center">Total Price (Rs.)</td></tr></thead><tbody>';
			     			foreach($pop as $i)
			     			{	        			
			     				if(($i->table_no)===$normalTable[$j])
			     				{
			     					$html=$html.'<tr><td align="center">'.ucfirst($i->mname).'</td>';
				     				$html=$html.'<td align="center">'.$i->sp.'</td>';
				     				if($i->qty< 2)
				     				{
				     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'</td>';
				     				}
				     				else
				     				{
				     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'s</td>';
				     				}
				     				$html=$html.'<td align="center">'.($i->sp)*($i->qty).'</td></tr>';
				     				
				     				
					     				
						            
						            	
				     			}
		        			}
		        			$html=$html.'</tbody></table></div>';
		        			$html=$html.'<div class="row justify-content-end"><a class="btn btn-secondary mr-1" href="/pop/c/'.$normalTable[$j].'" onclick="return cnfpop()">Cancel All</a><a class="btn btn-secondary mr-1" href="#" onclick="popES(1,'.$normalTable[$j].','."'".$user."'".')">Edit Order</a>';
				     		
				     		
							     		
			            		$html=$html.'<a class="btn btn-secondary mr-1" href="/pop/cnf/'.$normalTable[$j].'" onclick="return cnfpop()">Serve All</a></div></div></div></div></div></div></div>';
			            
		        		}
            	}
            	else//if current user is editting a table
            	{
            		
        			if($editting!=1)//create form once
					{
    					$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$tb.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12"><form method="POST" action="/pop"><input type="hidden" name="_token" value="'.csrf_token().'"><div class="table-responsive table-striped"><table class="table table-sm"><thead class="thead-dark"><tr style="background-color: #48494b; font-weight: bold; color:white;"><td align="center">Items</td><td align="center">Price</td><td align="center">Qty</td><td align="center">Total Price (Rs.)</td></tr></thead><tbody>';
    					foreach ($pop as $i) 
    					{	
    						if($i->table_no==$tb)
 							{
    						            					
		     					$html=$html.'<tr><td align="center">'.ucfirst($i->mname).'</td>';
			     				$html=$html.'<td align="center">'.$i->sp.'</td>';
			     				if($i->qty< 2)
			     				{
			     					$html=$html.'<td align="center"><input type="number" name="qty'.$i->id.'" min=0 value="'.$i->qty.'">'.' '.$i->unit_name.'</td>';
			     				}
			     				else
			     				{
			     					$html=$html.'<td align="center"><input type="number" name="qty'.$i->id.'" min=0 value="'.$i->qty.'">'.' '.$i->unit_name.'s</td>';
			     				}
			     				$html=$html.'<td align="center">'.($i->sp)*($i->qty).'</td></tr>';
			     				
		     				}
	     				}
	     				$html=$html.'</tbody></table></div><div class="row justify-content-end"><a class="btn btn-secondary mr-1" href="#" onclick="popES(0,0,'."'".$user."'".')">Cancel</a><button class="btn btn-secondary" type="submit" onclick="return cnfpop()">Submit Order</button></div></form></div></div></div></div></div></div>';
     				}
     				else//do not update form for editor user
     				{
     					$html="dontupdate";
     				}
	            		
	            	
            	}
            

        	}
        	else//if no table is editted by any user
        	{
        		foreach($tables as $t)
	     		{
		     		$html=$html.'<div class="row justify-content-center" ><div class="col-md-12" ><div class="card" style="margin-bottom: 10px;border-radius: 10px ;" ><div class="card-header" align="center" style="border-radius: 10px 10px 0px 0px;"><h5><b>Table No. '.$t->table_no.'</b></h5></div><div class="card-body" style="border-radius: 0px 0px 10px 10px;"><div class="form-group form-row"><div class="col-md-12"><div class="table-responsive table-striped"><table class="table table-sm"><thead class="thead-dark"><tr style="background-color: #48494b; font-weight: bold; color:white;"><td align="center">Items</td><td align="center">Price</td><td align="center">Qty</td><td align="center">Total Price (Rs.)</td></tr></thead><tbody>';

		     		foreach($pop as $i)
		     		{
		     			if($i->table_no==$t->table_no)
		     			{
		     				$html=$html.'<tr><td align="center">'.ucfirst($i->mname).'</td>';
		     				$html=$html.'<td align="center">'.$i->sp.'</td>';
		     				if($i->qty< 2)
		     				{
		     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'</td>';
		     				}
		     				else
		     				{
		     					$html=$html.'<td align="center">'.$i->qty.' '.$i->unit_name.'s</td>';
		     				}
		     				$html=$html.'<td align="center">'.($i->sp)*($i->qty).'</td></tr>';
		     			}
		     		}
		     		$html=$html.'</tbody></table></div><div class="row justify-content-end"><a class="btn btn-secondary mr-1" href="/pop/c/'.$t->table_no.'" onclick="return cnfpop()">Cancel All</a><a class="btn btn-secondary mr-1" href="#" onclick="popES(1,'.$t->table_no.','."'".$user."'".')">Edit Order</a>';
		     		
		     			     		
	            		$html=$html.'<a class="btn btn-secondary mr-1" href="/pop/cnf/'.$t->table_no.'" onclick="return cnfpop()">Serve All</a></div></div></div></div></div></div></div>';
	            	
	            	
	            }
	     	}	
	    
	     			
	    
	     
            echo "retry: 100". PHP_EOL;
            echo "data:$html". PHP_EOL;
            echo PHP_EOL;
            ob_end_flush();
            flush();
	       
		}
	     	
	             
	        
	} 
    
}

