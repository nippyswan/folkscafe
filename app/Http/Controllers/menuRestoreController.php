<?php

namespace App\Http\Controllers;
use App\menu;

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


class menuRestoreController extends Controller
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
    public function index($q)
    {
        if (Gate::allows('manager')) 
        {
            if($q=="ig")
            {
                 $menulist = menu::where('menu.status','=',0)
                 ->where('type','=',"ig")
                ->join('units', 'menu.f_id', '=', 'units.id')
                ->join('category', 'menu.f_cat', '=', 'category.id')
                ->select('menu.name as mname','menu.imgurl', 'units.unit_name', 'category.name as cname')
                ->get();
            }
            elseif($q=="pd")
            {
                 $menulist = menu::where('menu.status','=',0)
                 ->where('type','=',"pd")
                ->join('units', 'menu.f_id', '=', 'units.id')
                ->join('category', 'menu.f_cat', '=', 'category.id')
                ->select('menu.name as mname','menu.imgurl', 'units.unit_name', 'category.name as cname','menu.sp')
                ->get();
            }
            else
            {
                 $menulist = menu::where('menu.status','=',0)
                 ->where('type','=',"mn")
                 ->join('units', 'menu.f_id', '=', 'units.id')
                ->join('category', 'menu.f_cat', '=', 'category.id')
                ->select('menu.name as mname','menu.imgurl', 'units.unit_name', 'category.name as cname','menu.sp')
                ->get();
            }
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
            
            if($q=="ig")
            {
                foreach ($menulist as $key) {
                    $exists = Storage::disk('public')->exists('/ingredients/'.$key->imgurl);
                    
                    if($exists!=1)
                        $key->imgurl=NULL;
                    
                }
            }
            elseif($q=="pd")
            {
                foreach ($menulist as $key) {
                    $exists = Storage::disk('public')->exists('/products/'.$key->imgurl);
                    
                    if($exists!=1)
                        $key->imgurl=NULL;
                    
                }
            }
            else
            {
                foreach ($menulist as $key) {
                    
                    $exists = Storage::disk('public')->exists('/menus/'.$key->imgurl);
                    
                    if($exists!=1)
                        $key->imgurl=NULL;
                    
                }
            }

            
                return view('/menuRestore',['q'=>$q,'menulist'=>$menulist,'category'=>$category]);
            
        }

                
                    
            
        else
            abort(403, 'Unauthorized action.');
               
    }
 


   
    

    public function destroy($q)
    {
        if (Gate::allows('manager')) 
        {
            menu::where('name','=',$q)->update(['status' => 1]);
            $type=menu::where('name','=',$q)->select('type')->get();
            
            if($type=='[{"type":"ig"}]')
            return \Redirect::route('igmenu')        
                        ->with('menudel', 'Ingredient '.'"'.ucfirst($q).'"'.' Restored!');
            elseif($type=='[{"type":"pd"}]')
                return \Redirect::route('pdmenu')        
                        ->with('menudel', 'Product '.'"'.ucfirst($q).'"'.' Restored!');
            else
                return \Redirect::route('mnmenu')        
                        ->with('menudel', 'Menu Item '.'"'.ucfirst($q).'"'.' Restored!');

        }
        else
            abort(403, 'Unauthorized action.');
    }

   
    
}

