<?php

namespace App\Http\Controllers;
use App\investor;
use App\investments;
use App\r_investments;
use App\payoff;
use App\r_payoff;
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


class invpayReportController extends Controller
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
                $dt=date("Y-m-d");
                $bsdatex=date_create($dt);
                $balance_start=investments::all();
                foreach ($balance_start as $bs) {
                    $bsc=date_create($bs->date);
                    $diff=date_diff($bsc,$bsdatex);
                    if($diff->format("%R%")==='+')
                        $bsdatex=$bsc;
                }
                $bsdate=$bsdatex->format("Y-m-d");
               
         
            $inv = investments::whereDate('date',$dt)
            ->join('investor', 'investments.f_id', '=', 'investor.id')
            ->select('investor.name', 'investments.date', 'investments.amt')
            ->get();
            $rinv = r_investments::whereDate('date',$dt)
            ->join('investor', 'r_investments.f_id', '=', 'investor.id')
            ->select('investor.name', 'r_investments.date', 'r_investments.amt')
            ->get();
            $payoff = payoff::whereDate('date',$dt)
            ->join('investor', 'payoff.f_id', '=', 'investor.id')
            ->select('investor.name', 'payoff.date', 'payoff.amt')
            ->get();
            $rpayoff = r_payoff::whereDate('date',$dt)
            ->join('investor', 'r_payoff.f_id', '=', 'investor.id')
            ->select('investor.name', 'r_payoff.date', 'r_payoff.amt')
            ->get();
            $investor=array();

            foreach ($inv as $in) {

                $arrlength = count($investor);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($investor[$i]==$in->name) 
                    break;
                    
                }
                $investor[$i]=$in->name;
            }
            foreach ($payoff as $in) {

                $arrlength = count($investor);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($investor[$i]==$in->name) 
                    break;
                    
                }
                $investor[$i]=$in->name;
            }
            foreach ($rinv as $in) {

                $arrlength = count($investor);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($investor[$i]==$in->name) 
                    break;
                    
                }
                $investor[$i]=$in->name;
            }
            foreach ($rpayoff as $in) {

                $arrlength = count($investor);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($investor[$i]==$in->name) 
                    break;
                    
                }
                $investor[$i]=$in->name;
            }




            $dates=array();//for unique dates of all investors

            foreach ($inv as $in) {

                $arrlength = count($dates);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($dates[$i]==$in->date) 
                    break;
                    
                }
                $dates[$i]=$in->date;
            }





            foreach ($rinv as $in) {

                $arrlength = count($dates);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($dates[$i]==$in->date) 
                    break;
                    
                }
                $dates[$i]=$in->date;
            }

            foreach ($payoff as $in) {

                $arrlength = count($dates);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($dates[$i]==$in->date) 
                    break;
                    
                }
                $dates[$i]=$in->date;
            }

            foreach ($rpayoff as $in) {

                $arrlength = count($dates);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($dates[$i]==$in->date) 
                    break;
                    
                }
                $dates[$i]=$in->date;
            }

            $fdate=array();//to store counts of amt records
            $cnt=array();//count variable

            for($i = 0; $i < count($investor); $i++)
                for($j = 0; $j < count($dates); $j++)
                {
                    $cnt[$i][$j]=0;
                    foreach ($inv as $in)
                    {
                        if($investor[$i]==$in->name && $dates[$j]==$in->date)
                            $cnt[$i][$j]++;
                    }
                    
                        $fdate[$i][$j][0]=$cnt[$i][$j];
                    
                }

            for($i = 0; $i < count($investor); $i++)
                for($j = 0; $j < count($dates); $j++)
                {
                    $cnt[$i][$j]=0;
                    foreach ($rinv as $in)
                    {
                        if($investor[$i]==$in->name && $dates[$j]==$in->date)
                            $cnt[$i][$j]++;
                    }
                    $fdate[$i][$j][1]=$cnt[$i][$j];
                }

            for($i = 0; $i < count($investor); $i++)
                for($j = 0; $j < count($dates); $j++)
                {
                    $cnt[$i][$j]=0;
                    foreach ($payoff as $in)
                    {
                        if($investor[$i]==$in->name && $dates[$j]==$in->date)
                            $cnt[$i][$j]++;
                    }
                    $fdate[$i][$j][2]=$cnt[$i][$j];
                }

            for($i = 0; $i < count($investor); $i++)
                for($j = 0; $j < count($dates); $j++)
                {
                    $cnt[$i][$j]=0;
                    foreach ($rpayoff as $in)
                    {
                        if($investor[$i]==$in->name && $dates[$j]==$in->date)
                            $cnt[$i][$j]++;
                    }
                    $fdate[$i][$j][3]=$cnt[$i][$j];
                }

            
            
           
            return view('/invpayReport',['invx' => $inv,'rinvx' => $rinv,'payoffx'=> $payoff,'rpayoffx'=> $rpayoff,'investorx'=>$investor,'datesx' => $dates,'fdatex'=>$fdate,'date'=>$dt,'bsdatex'=>$bsdate]);
            
            }
        else
            abort(403, 'Unauthorized action.');
               
    }
    
    public function store(Request $request)
    {
        if (Gate::allows('manager')) 
        {
            date_default_timezone_set("Asia/Kathmandu");
            
            $bsdatex=date_create(date("Y-m-d"));
            $balance_start=investments::all();
            foreach ($balance_start as $bs) {
                $bsc=date_create($bs->date);
                $diff=date_diff($bsc,$bsdatex);
                if($diff->format("%R%")==='+')
                    $bsdatex=$bsc;
            }
            $bsdate=$bsdatex->format("Y-m-d");
            $from=$request->get('from');
            $to=$request->get('to');

            $date1=date_create($from);
            $date2=date_create($to);
            $diff=date_diff($date1,$date2);
            if($diff->format("%R%")==='+')
            {
            $dt='From( '.$from.' ) To( '.$to.' )';
            $inv = investments::whereDate('date','>=',$from)
            ->whereDate('date','<=',$to)
            ->join('investor', 'investments.f_id', '=', 'investor.id')
            ->select('investor.name', 'investments.date', 'investments.amt')
            ->latest('date')
            ->get();
            $rinv = r_investments::whereDate('date','>=',$from)
            ->whereDate('date','<=',$to)
            ->join('investor', 'r_investments.f_id', '=', 'investor.id')
            ->select('investor.name', 'r_investments.date', 'r_investments.amt')
            ->latest('date')
            ->get();
            $payoff = payoff::whereDate('date','>=',$from)
            ->whereDate('date','<=',$to)
            ->join('investor', 'payoff.f_id', '=', 'investor.id')
            ->select('investor.name', 'payoff.date', 'payoff.amt')
            ->latest('date')
            ->get();
            $rpayoff = r_payoff::whereDate('date','>=',$from)
            ->whereDate('date','<=',$to)
            ->join('investor', 'r_payoff.f_id', '=', 'investor.id')
            ->select('investor.name', 'r_payoff.date', 'r_payoff.amt')
            ->latest('date')
            ->get();

           
            $investor=array();//for unique investors

            foreach ($inv as $in) {

                $arrlength = count($investor);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($investor[$i]==$in->name) 
                    break;
                    
                }
                $investor[$i]=$in->name;
            }
            foreach ($payoff as $in) {

                $arrlength = count($investor);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($investor[$i]==$in->name) 
                    break;
                    
                }
                $investor[$i]=$in->name;
            }
            foreach ($rinv as $in) {

                $arrlength = count($investor);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($investor[$i]==$in->name) 
                    break;
                    
                }
                $investor[$i]=$in->name;
            }
            foreach ($rpayoff as $in) {

                $arrlength = count($investor);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($investor[$i]==$in->name) 
                    break;
                    
                }
                $investor[$i]=$in->name;
            }




            $dates=array();//for unique dates of all investors

            foreach ($inv as $in) {

                $arrlength = count($dates);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($dates[$i]==$in->date) 
                    break;
                    
                }
                $dates[$i]=$in->date;
            }





            foreach ($rinv as $in) {

                $arrlength = count($dates);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($dates[$i]==$in->date) 
                    break;
                    
                }
                $dates[$i]=$in->date;
            }

            foreach ($payoff as $in) {

                $arrlength = count($dates);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($dates[$i]==$in->date) 
                    break;
                    
                }
                $dates[$i]=$in->date;
            }

            foreach ($rpayoff as $in) {

                $arrlength = count($dates);
                for($i = 0; $i < $arrlength; $i++)
                {
                    if($dates[$i]==$in->date) 
                    break;
                    
                }
                $dates[$i]=$in->date;
            }

            $fdate=array();//to store counts of amt records
            $cnt=array();//count variable

            for($i = 0; $i < count($investor); $i++)
                for($j = 0; $j < count($dates); $j++)
                {
                    $cnt[$i][$j]=0;
                    foreach ($inv as $in)
                    {
                        if($investor[$i]==$in->name && $dates[$j]==$in->date)
                            $cnt[$i][$j]++;
                    }
                    
                        $fdate[$i][$j][0]=$cnt[$i][$j];
                    
                }

            for($i = 0; $i < count($investor); $i++)
                for($j = 0; $j < count($dates); $j++)
                {
                    $cnt[$i][$j]=0;
                    foreach ($rinv as $in)
                    {
                        if($investor[$i]==$in->name && $dates[$j]==$in->date)
                            $cnt[$i][$j]++;
                    }
                    $fdate[$i][$j][1]=$cnt[$i][$j];
                }

            for($i = 0; $i < count($investor); $i++)
                for($j = 0; $j < count($dates); $j++)
                {
                    $cnt[$i][$j]=0;
                    foreach ($payoff as $in)
                    {
                        if($investor[$i]==$in->name && $dates[$j]==$in->date)
                            $cnt[$i][$j]++;
                    }
                    $fdate[$i][$j][2]=$cnt[$i][$j];
                }

            for($i = 0; $i < count($investor); $i++)
                for($j = 0; $j < count($dates); $j++)
                {
                    $cnt[$i][$j]=0;
                    foreach ($rpayoff as $in)
                    {
                        if($investor[$i]==$in->name && $dates[$j]==$in->date)
                            $cnt[$i][$j]++;
                    }
                    $fdate[$i][$j][3]=$cnt[$i][$j];
                }

                /* verify values in fdate
                for($i = 0; $i < count($fdate); $i++)
                {
                    for($j = 0; $j < count($fdate[$i]); $j++)
                    {
                        for($k = 0; $k < count($fdate[$i][$j]); $k++)
                        {
                            echo '('.$fdate[$i][$j][$k].')'.'+';

                        }
                        echo "<br>";
                    }
                }   */

                    
            
            return view('/invpayReport',['invx' => $inv,'rinvx' => $rinv,'payoffx'=> $payoff,'rpayoffx'=> $rpayoff,'investorx'=>$investor,'datesx' => $dates,'fdatex'=>$fdate,'date'=>$dt,'bsdatex'=>$bsdate]);
            }
            else
                    return \Redirect::route('invpayReport.index')        
                        ->with('fromto', 'ERROR! -> "From Date" Is Greater Than "To Date!"');
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }

   

    
}

