<?php

namespace App\Http\Controllers;
use App\menu;
use App\ingredients;
use App\r_ingredients;
use App\units;
use App\investments;

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


class ingredientsReportController extends Controller
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
         
            $inv = ingredients::whereDate('date',$dt)
            ->join('menu', 'ingredients.f_id', '=', 'menu.id')
            ->join('units','menu.f_id','=','units.id')
            ->select('menu.name','ingredients.qty', 'ingredients.date','ingredients.price','units.unit_name')
            ->get();
            $rinv = r_ingredients::whereDate('date',$dt)
            ->join('menu', 'r_ingredients.f_id', '=', 'menu.id')
            ->join('units','menu.f_id','=','units.id')
            ->select('menu.name','r_ingredients.qty', 'r_ingredients.date','r_ingredients.price','units.unit_name')
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
            
            foreach ($rinv as $in) {

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

            

            
            
           
            return view('/ingredientsReport',['invx' => $inv,'rinvx' => $rinv,'investorx'=>$investor,'datesx' => $dates,'fdatex'=>$fdate,'date'=>$dt,'bsdatex'=>$bsdate]);
            
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

            $inv = ingredients::whereDate('date','>=',$from)
            ->whereDate('date','<=',$to)
            ->join('menu', 'ingredients.f_id', '=', 'menu.id')
            ->join('units','menu.f_id','=','units.id')
            ->select('menu.name','ingredients.qty', 'ingredients.date','ingredients.price','units.unit_name')
            ->latest('date')
            ->get();
            $rinv = r_ingredients::whereDate('date','>=',$from)
            ->whereDate('date','<=',$to)
            ->join('menu', 'r_ingredients.f_id', '=', 'menu.id')
            ->join('units','menu.f_id','=','units.id')
            ->select('menu.name','r_ingredients.qty', 'r_ingredients.date','r_ingredients.price','units.unit_name')
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
            
            foreach ($rinv as $in) {

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




                    
            
            return view('/ingredientsReport',['invx' => $inv,'rinvx' => $rinv,'investorx'=>$investor,'datesx' => $dates,'fdatex'=>$fdate,'date'=>$dt,'bsdatex'=>$bsdate]);
            }
            else
                    return \Redirect::route('ingredientsReport.index')        
                        ->with('fromto', 'ERROR! -> "From Date" Is Greater Than "To Date!"');
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }

   

    
}

