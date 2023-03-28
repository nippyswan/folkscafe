<?php

namespace App\Http\Controllers;
use App\investments;
use App\User;
use App\salary_list;
use App\salary;
use App\r_salary;
use App\allowance;
use App\r_allowance;
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


class salary_allow_sheetReportController extends Controller
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
        if (Gate::allows('manager')) 

            {
                date_default_timezone_set("Asia/Kathmandu");
                $dt=date("Y");
                $bsdatex=date_create($dt);
                $balance_start=investments::all();
                foreach ($balance_start as $bs) {
                    $bsc=date_create($bs->date);
                    $diff=date_diff($bsc,$bsdatex);
                    if($diff->format("%R%")==='+')
                        $bsdatex=$bsc;
                }
                $bsdate=$bsdatex->format("Y-m-d");

                $cur_date=date("Y-m");
              

                $sal_sheet=array();
                $final_sal_sheet=array();

                $users=User::select('id','username')->get();
               

                foreach ($users as $key) 
                {
                    $id=$key->id;
                    $sal_sheet[$key->username]=array("id"=>$id);
                    $olddate=salary_list::where('f_id','=',$id)
                        ->select('salary_amt','from_date')
                        ->oldest('from_date')
                        ->first();
                        //echo $olddate['salary_amt']."+".$id."------";

                    $salary=salary::where("f_id","=",$id)
                        ->sum('amt');
                    $r_salary=r_salary::where("f_id","=",$id)
                        ->sum('amt');
                    $sal_paid=$salary-$r_salary;

                    $allowance=allowance::where("f_id","=",$id)
                        ->whereYear('date',$dt)
                        ->sum('amt');
                    $r_allowance=r_allowance::where("f_id","=",$id)
                        ->whereYear('date',$dt)
                        ->sum('amt');
                    $allow_paid=$allowance-$r_allowance;
                    $final_sal_sheet[$key->username]["allow"]=$allow_paid;
                        //echo $key->username."=".$sal_paid;
                    //echo $key->username;
                    $od=date_create($olddate['from_date']);
                    $olddt=$od->format("Y");
                    if($dt<$olddt)
                    {
                        $idate="Jan ".$dt;
                        $endmonth="Dec ".$dt;
                        
                        $final_sal_sheet[$key->username]["stp"][$idate]="--";
                        $final_sal_sheet[$key->username]["sp"][$idate]="--";
                        while($idate!==$endmonth)
                        {
                            
                            $iidate=date_create($idate);
                            $iidate->modify('+1 month');
                            $idate=$iidate->format("M Y");
                            $final_sal_sheet[$key->username]["stp"][$idate]="--";
                            $final_sal_sheet[$key->username]["sp"][$idate]="--";

                        } 

                    }

                    

                    if(isset($olddate))
                    {
                        
                        
                        while($olddate['from_date']!==$cur_date)
                        {
                            

                            $date_exist=salary_list::select('salary_amt')
                            ->where("from_date","=",$olddate['from_date'])
                            ->where("f_id","=",$id)
                            ->first();
                            //echo $date_exist['salary_amt']."+".$id."------";
                            if(isset($date_exist))
                            {
                                $mdate=date_create($olddate['from_date']);
                                $Mdate=$mdate->format("M Y");
                                $sal_sheet[$key->username]["stp"][$Mdate]=$date_exist['salary_amt'];
                                $s_amt=(int)$date_exist['salary_amt'];
                                //echo $s_amt."+";
                                if($sal_paid>=$s_amt)
                                {
                                    $sal_sheet[$key->username]["sp"][$Mdate]=$date_exist['salary_amt'];
                                    $sal_paid-=$s_amt;
                                }
                                else
                                {
                                   $sal_sheet[$key->username]["sp"][$Mdate]=$sal_paid;
                                    $sal_paid=0; 
                                }
                                $olddate['salary_amt']=$date_exist['salary_amt'];
                            }
                            else
                            {
                                $mdate=date_create($olddate['from_date']);
                                $Mdate=$mdate->format("M Y");
                                $sal_sheet[$key->username]["stp"][$Mdate]=$olddate['salary_amt'];
                                $s_amt=(int)$olddate['salary_amt'];
                                //echo $s_amt."+";
                                if($sal_paid>=$s_amt)
                                {
                                    $sal_sheet[$key->username]["sp"][$Mdate]=$olddate['salary_amt'];
                                    $sal_paid-=$s_amt;
                                }
                                else
                                {
                                   $sal_sheet[$key->username]["sp"][$Mdate]=$sal_paid;
                                    $sal_paid=0; 
                                }
                            }
                            $mdate=date_create($olddate['from_date']);
                            $mdate->modify('+1 month');
                            $olddate['from_date']=$mdate->format("Y-m");
                        }
                        //echo $key->username."=".$sal_paid."+";
                        
                        
                    }
                    if($sal_paid>0)
                    {
                        $sal_sheet[$key->username]["adv"]=$sal_paid;
                        $final_sal_sheet[$key->username]["adv"]=$sal_paid;

                    }
                }

                
                /*foreach ($sal_sheet as $key => $value) 
                {
                    echo $key."= {";
                    foreach ($value as $subkey => $subvalue) 
                    {
                        
                        if($subkey==="stp")
                        {
                            echo $subkey."= [";
                            foreach ($subvalue as $subsubkey => $subsubvalue) 
                            {
                                echo $subsubkey."= (".$subsubvalue.")";
                            
                            }
                            echo "] \r\n";
                        }
                        if($subkey==="adv")
                        {
                            echo $subkey."= [".$subvalue;
                            echo "] \r\n";
                        }
                        
                    }
                    echo "} \r\n";
                }*/

              
                foreach ($sal_sheet as $key => $value) 
                {

                    foreach ($value as $subkey => $subvalue) 
                    {
                        
                        if($subkey==="stp"||$subkey==="sp")
                        {
                            $idate="Jan ".$dt;

                            foreach ($subvalue as $subsubkey => $subsubvalue) 
                            {
                                
                                $dtssk=date_create($subsubkey);
                                $ydtssk=$dtssk->format("Y");
                                if($ydtssk==$dt)//comparing year to filter
                                {
                                    if($subsubkey!==$idate)
                                    {
                                        while($idate!==$subsubkey)//skipping empty month from beginning
                                        {
                                            $final_sal_sheet[$key][$subkey][$idate]="--";
                                            
                                            $iidate=date_create($idate);
                                            $iidate->modify('+1 month');
                                            $idate=$iidate->format("M Y");

                                        } 
                                    }
                                    
                                    $final_sal_sheet[$key][$subkey][$subsubkey]=$subsubvalue;//copying existing values from non empty months
                                    
                                    $iidate=date_create($idate);
                                    $iidate->modify('+1 month');
                                    $idate=$iidate->format("M Y");
                                    
                                    
                                }

                                
                                
                            
                            }
                            
                        }
                       
                        
                       
                    }
                    
                }

                foreach ($sal_sheet as $key => $value) 
                {
                    $endmonth="Dec ".$dt;
                    if(!isset($sal_sheet[$key]["stp"]))//for those users who have not started working till now
                    {
                        $idate="Jan ".$dt;
                        
                        $final_sal_sheet[$key]["stp"][$idate]="--";
                        $final_sal_sheet[$key]["sp"][$idate]="--";
                        while($idate!==$endmonth)
                        {
                            
                            $iidate=date_create($idate);
                            $iidate->modify('+1 month');
                            $idate=$iidate->format("M Y");
                            $final_sal_sheet[$key]["stp"][$idate]="--";
                            $final_sal_sheet[$key]["sp"][$idate]="--";

                        } 

                    }
                    $cur_year=date("Y");
                    if($dt==$cur_year)//for showing -- in remaining momnths of current year
                    {
                        $cur_month=date("M Y");

                        $final_sal_sheet[$key]["stp"][$cur_month]="--";
                        $final_sal_sheet[$key]["sp"][$cur_month]="--";
                        while($cur_month!=$endmonth)
                        {
                            $iidate=date_create($cur_month);
                            $iidate->modify('+1 month');
                            $cur_month=$iidate->format("M Y");
                            $final_sal_sheet[$key]["stp"][$cur_month]="--";
                            $final_sal_sheet[$key]["sp"][$cur_month]="--";
                        }
                    }

                }

              

                

               /* foreach ($final_sal_sheet as $key => $value) 
                {
                    echo $key."= {";
                    foreach ($value as $subkey => $subvalue) 
                    {
                        
                            
                            
                            if($subkey=="stp")
                            {
                                echo $subkey."= [";
                                foreach ($subvalue as $subsubkey => $subsubvalue) 
                                {
                                    echo $subsubkey."= (".$subsubvalue.")";
                                
                                }
                                echo "] \r\n";
                            }
                            
                        
                        
                        
                    }
                    echo "} \r\n";
                }*/
               

            
                            
         
           
            return view('/salary_allow_sheetReport',['date'=>$dt,'bsdatex'=>$bsdate,'final_sal_sheet'=>$final_sal_sheet]);
            
            }
        else
            abort(403, 'Unauthorized action.');
               
    }
    
    public function store(Request $request)
    {
        if (Gate::allows('manager')) 
        {
            date_default_timezone_set("Asia/Kathmandu");
                $dt=$request->get('year');
                $bsdatex=date_create($dt);
                $balance_start=investments::all();
                foreach ($balance_start as $bs) {
                    $bsc=date_create($bs->date);
                    $diff=date_diff($bsc,$bsdatex);
                    if($diff->format("%R%")==='+')
                        $bsdatex=$bsc;
                }
                $bsdate=$bsdatex->format("Y-m-d");

                $cur_date=date("Y-m");
              

                $sal_sheet=array();
                $final_sal_sheet=array();

                $users=User::select('id','username')->get();
               

                foreach ($users as $key) 
                {
                    $id=$key->id;
                    $sal_sheet[$key->username]=array("id"=>$id);
                    $olddate=salary_list::where('f_id','=',$id)
                        ->select('salary_amt','from_date')
                        ->oldest('from_date')
                        ->first();
                        //echo $olddate['salary_amt']."+".$id."------";

                    $salary=salary::where("f_id","=",$id)
                        ->sum('amt');
                    $r_salary=r_salary::where("f_id","=",$id)
                        ->sum('amt');
                    $sal_paid=$salary-$r_salary;

                    $allowance=allowance::where("f_id","=",$id)
                        ->whereYear('date',$dt)
                        ->sum('amt');
                    $r_allowance=r_allowance::where("f_id","=",$id)
                        ->whereYear('date',$dt)
                        ->sum('amt');
                    $allow_paid=$allowance-$r_allowance;
                    $final_sal_sheet[$key->username]["allow"]=$allow_paid;
                        //echo $key->username."=".$sal_paid;
                    //echo $key->username;
                    $od=date_create($olddate['from_date']);
                    $olddt=$od->format("Y");
                    if($dt<$olddt)
                    {
                        $idate="Jan ".$dt;
                        $endmonth="Dec ".$dt;
                        
                        $final_sal_sheet[$key->username]["stp"][$idate]="--";
                        $final_sal_sheet[$key->username]["sp"][$idate]="--";
                        while($idate!==$endmonth)
                        {
                            
                            $iidate=date_create($idate);
                            $iidate->modify('+1 month');
                            $idate=$iidate->format("M Y");
                            $final_sal_sheet[$key->username]["stp"][$idate]="--";
                            $final_sal_sheet[$key->username]["sp"][$idate]="--";

                        } 

                    }

                    if($dt>date("Y"))//for store
                    {
                        $idate="Jan ".$dt;
                        $endmonth="Dec ".$dt;
                        
                        $final_sal_sheet[$key->username]["stp"][$idate]="--";
                        $final_sal_sheet[$key->username]["sp"][$idate]="--";
                        while($idate!==$endmonth)
                        {
                            
                            $iidate=date_create($idate);
                            $iidate->modify('+1 month');
                            $idate=$iidate->format("M Y");
                            $final_sal_sheet[$key->username]["stp"][$idate]="--";
                            $final_sal_sheet[$key->username]["sp"][$idate]="--";

                        } 

                    }

                    if(isset($olddate))
                    {
                        
                        
                        while($olddate['from_date']!==$cur_date)
                        {
                            

                            $date_exist=salary_list::select('salary_amt')
                            ->where("from_date","=",$olddate['from_date'])
                            ->where("f_id","=",$id)
                            ->first();
                            //echo $date_exist['salary_amt']."+".$id."------";
                            if(isset($date_exist))
                            {
                                $mdate=date_create($olddate['from_date']);
                                $Mdate=$mdate->format("M Y");
                                $sal_sheet[$key->username]["stp"][$Mdate]=$date_exist['salary_amt'];
                                $s_amt=(int)$date_exist['salary_amt'];
                                //echo $s_amt."+";
                                if($sal_paid>=$s_amt)
                                {
                                    $sal_sheet[$key->username]["sp"][$Mdate]=$date_exist['salary_amt'];
                                    $sal_paid-=$s_amt;
                                }
                                else
                                {
                                   $sal_sheet[$key->username]["sp"][$Mdate]=$sal_paid;
                                    $sal_paid=0; 
                                }
                                $olddate['salary_amt']=$date_exist['salary_amt'];
                            }
                            else
                            {
                                $mdate=date_create($olddate['from_date']);
                                $Mdate=$mdate->format("M Y");
                                $sal_sheet[$key->username]["stp"][$Mdate]=$olddate['salary_amt'];
                                $s_amt=(int)$olddate['salary_amt'];
                                //echo $s_amt."+";
                                if($sal_paid>=$s_amt)
                                {
                                    $sal_sheet[$key->username]["sp"][$Mdate]=$olddate['salary_amt'];
                                    $sal_paid-=$s_amt;
                                }
                                else
                                {
                                   $sal_sheet[$key->username]["sp"][$Mdate]=$sal_paid;
                                    $sal_paid=0; 
                                }
                            }
                            $mdate=date_create($olddate['from_date']);
                            $mdate->modify('+1 month');
                            $olddate['from_date']=$mdate->format("Y-m");
                        }
                        //echo $key->username."=".$sal_paid."+";
                        
                        
                    }
                    if($sal_paid>0)
                    {
                        $sal_sheet[$key->username]["adv"]=$sal_paid;
                        $final_sal_sheet[$key->username]["adv"]=$sal_paid;

                    }
                }

                
                /*foreach ($sal_sheet as $key => $value) 
                {
                    echo $key."= {";
                    foreach ($value as $subkey => $subvalue) 
                    {
                        
                        if($subkey==="stp")
                        {
                            echo $subkey."= [";
                            foreach ($subvalue as $subsubkey => $subsubvalue) 
                            {
                                echo $subsubkey."= (".$subsubvalue.")";
                            
                            }
                            echo "] \r\n";
                        }
                        if($subkey==="adv")
                        {
                            echo $subkey."= [".$subvalue;
                            echo "] \r\n";
                        }
                        
                    }
                    echo "} \r\n";
                }*/

              
                foreach ($sal_sheet as $key => $value) 
                {

                    foreach ($value as $subkey => $subvalue) 
                    {
                        
                        if($subkey==="stp"||$subkey==="sp")
                        {
                            $idate="Jan ".$dt;

                            foreach ($subvalue as $subsubkey => $subsubvalue) 
                            {
                                
                                $dtssk=date_create($subsubkey);
                                $ydtssk=$dtssk->format("Y");
                                if($ydtssk==$dt)//comparing year to filter
                                {
                                    if($subsubkey!==$idate)
                                    {
                                        while($idate!==$subsubkey)//skipping empty month from beginning
                                        {
                                            $final_sal_sheet[$key][$subkey][$idate]="--";
                                            
                                            $iidate=date_create($idate);
                                            $iidate->modify('+1 month');
                                            $idate=$iidate->format("M Y");

                                        } 
                                    }
                                    
                                    $final_sal_sheet[$key][$subkey][$subsubkey]=$subsubvalue;//copying existing values from non empty months
                                    
                                    $iidate=date_create($idate);
                                    $iidate->modify('+1 month');
                                    $idate=$iidate->format("M Y");
                                    
                                    
                                }

                                
                                
                            
                            }
                            
                        }
                       
                        
                       
                    }
                    
                }

                foreach ($sal_sheet as $key => $value) 
                {
                    $endmonth="Dec ".$dt;
                    if(!isset($sal_sheet[$key]["stp"]))//for those users who have not started working till now
                    {
                        $idate="Jan ".$dt;
                        
                        $final_sal_sheet[$key]["stp"][$idate]="--";
                        $final_sal_sheet[$key]["sp"][$idate]="--";
                        while($idate!==$endmonth)
                        {
                            
                            $iidate=date_create($idate);
                            $iidate->modify('+1 month');
                            $idate=$iidate->format("M Y");
                            $final_sal_sheet[$key]["stp"][$idate]="--";
                            $final_sal_sheet[$key]["sp"][$idate]="--";

                        } 

                    }
                    $cur_year=date("Y");
                    if($dt==$cur_year)//for showing -- in remaining momnths of current year
                    {
                        $cur_month=date("M Y");

                        $final_sal_sheet[$key]["stp"][$cur_month]="--";
                        $final_sal_sheet[$key]["sp"][$cur_month]="--";
                        while($cur_month!=$endmonth)
                        {
                            $iidate=date_create($cur_month);
                            $iidate->modify('+1 month');
                            $cur_month=$iidate->format("M Y");
                            $final_sal_sheet[$key]["stp"][$cur_month]="--";
                            $final_sal_sheet[$key]["sp"][$cur_month]="--";
                        }
                    }

                }

              

                

               /* foreach ($final_sal_sheet as $key => $value) 
                {
                    echo $key."= {";
                    foreach ($value as $subkey => $subvalue) 
                    {
                        
                            
                            
                            if($subkey=="stp")
                            {
                                echo $subkey."= [";
                                foreach ($subvalue as $subsubkey => $subsubvalue) 
                                {
                                    echo $subsubkey."= (".$subsubvalue.")";
                                
                                }
                                echo "] \r\n";
                            }
                            
                        
                        
                        
                    }
                    echo "} \r\n";
                }*/
               

            
                            
         
           
            return view('/salary_allow_sheetReport',['date'=>$dt,'bsdatex'=>$bsdate,'final_sal_sheet'=>$final_sal_sheet]);
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }

   

    
}

