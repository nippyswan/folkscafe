<?php

namespace App\Http\Controllers;
use App\menu;
use App\products;
use App\units;
use App\category;
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


class productsController extends Controller
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
           
            $menulist = menu::where('menu.status','=',1)
                 ->where('type','=',"pd")
                ->join('units', 'menu.f_id', '=', 'units.id')
                ->join('category', 'menu.f_cat', '=', 'category.id')
                ->select('menu.name as mname','menu.imgurl', 'units.unit_name', 'category.name as cname','menu.id')
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
                    $exists = Storage::disk('public')->exists('/products/'.$key->imgurl);
                    
                    if($exists!=1)
                        $key->imgurl=NULL;
                    
            }

            return view('/products',['menulist'=>$menulist,'category'=>$category]);
            
            }
        else
            abort(403, 'Unauthorized action.');
               
    }
 


   public function store(Request $request)
    {
        if (Gate::allows('manager')) 
        {
         $ingred=menu::select('id')
         ->where('type','=',"pd")
         ->where('status','=',1)
         ->get();   

         $c=0;

            foreach($ingred as $ing)
            {
                
                
                $rida=$request->get($ing->id.'a');
                if($rida!=NULL)
                {
                    $c=1;
                    $ridb=$request->get($ing->id.'b');
                    if($ridb==NULL)
                        return \Redirect::route('products.index')
                            ->with('combo', 'Please Enter Both Qty & Total Price for All Products!');
                
                    
                    
                }
                else
                {
                    $ridb=$request->get($ing->id.'b');
                    if($ridb!=NULL)
                    {
                        $c=1;
                        return \Redirect::route('products.index')
                            ->with('combo', 'Please Enter Both Qty & Total Price for All Products!');
                    }
                    
                    
                        
                }
            }
            if($c!=1)
                return \Redirect::route('products.index')->with('combo', 'No Input Values!');
            else
            {
                foreach($ingred as $ing)
                {
                
                
                    $rida=$request->get($ing->id.'a');
                    if($rida!=NULL)
                    {
                        $c=1;
                        $ridb=$request->get($ing->id.'b');
                        if($ridb!=NULL)
                        {
                            //echo $rida.' = '.$ridb.' , ';
                            $cu_price=products::max('cu_price');
                            $cu_price+=$ridb;
                            $ingredients=new products;
                            $ingredients->date=date("Y-m-d");
                            $ingredients->f_id=$ing->id;
                            $ingredients->qty=$rida;
                            $ingredients->price=$ridb;
                            $ingredients->cu_price=$cu_price;
                            $ingredients->save();
                            
                        
                        }
                    }
                }


                return \Redirect::route('productsReport.index')->with('ingadded','Products Shopping Details Successfully Entered!');
            }
                
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
    }
        
                
            
    

    
}

