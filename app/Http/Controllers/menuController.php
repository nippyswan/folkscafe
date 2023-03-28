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


class menuController extends Controller
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
                 $menulist = menu::where('menu.status','=',1)
                 ->where('type','=',"ig")
                ->join('units', 'menu.f_id', '=', 'units.id')
                ->join('category', 'menu.f_cat', '=', 'category.id')
                ->select('menu.name as mname','menu.imgurl', 'units.unit_name', 'category.name as cname')
                ->get();
            }
            elseif($q=="pd")
            {
                 $menulist = menu::where('menu.status','=',1)
                 ->where('type','=',"pd")
                ->join('units', 'menu.f_id', '=', 'units.id')
                ->join('category', 'menu.f_cat', '=', 'category.id')
                ->select('menu.name as mname','menu.imgurl', 'units.unit_name', 'category.name as cname','menu.sp')
                ->get();
            }
            elseif($q=="mn")
            {
                 $menulist = menu::where('menu.status','=',1)
                 ->where('type','=',"mn")
                 ->join('units', 'menu.f_id', '=', 'units.id')
                ->join('category', 'menu.f_cat', '=', 'category.id')
                ->select('menu.name as mname','menu.imgurl', 'units.unit_name', 'category.name as cname','menu.sp')
                ->get();
            }
            else
                abort(404, 'Not Found');
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

            $ddunit=units::select('unit_name')
            ->where('status','=',1)
            ->get();
            $ddcat=category::select('name')
            ->where('status','=',1)
            ->get();
                return view('/menu',['q'=>$q,'menulist'=>$menulist,'category'=>$category,'ddunit'=>$ddunit,'ddcat'=>$ddcat]);
            
        }

                
                    
            
        else
            abort(403, 'Unauthorized action.');
               
    }
 


   public function store(Request $request)
    {
        if (Gate::allows('manager')) 
        {
            $q=$request->get('q');
            $nm=$request->get('name');
            $units=$request->get('units');
            $category=$request->get('category');
            
            $unitsx=units::where('unit_name','=',$units)->get();
            foreach ($unitsx as $un) {
                $units_id=$un->id;
            }
            $catx=category::where('name','=',$category)->get();
            foreach ($catx as $un) {
                $category_id=$un->id;
            }
            Validator::make($request->all(), [

                    'name' => 'unique:menu',
                    ])->validate();  
            
            $menu=new menu;
            if($request->file('icon')!=NULL)
            {
                $data=$request->get('base64');
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                $fn=uniqid().'.png';

                
              
                
                if($q=="ig")
                {
                    Storage::put('ingredients/'.$fn, $data);
                    //$path = $request->file('icon')->store('ingredients');
                }
                elseif($q=="pd")
                {
                    Storage::put('products/'.$fn, $data);
                    //$path = $request->file('icon')->store('products');
                }
                else
                {
                    Storage::put('menus/'.$fn, $data);
                    //$path = $request->file('icon')->store('menus');
                }
                $imgurl=$fn;
                //$imgurl=$request->icon->hashName();

                $menu->imgurl=$imgurl;
            }
            else
                $menu->imgurl=NULL;

            $menu->name=$nm;
            $menu->f_id=$units_id;
            $menu->f_cat=$category_id;
            if($q=="ig")
                $menu->sp=0;
            else
                $menu->sp=$request->get('sp');

            $menu->type=$q;
            
            $menu->status=1;
            $menu->save();

            
            if($q=="ig")
             return \Redirect::route('igmenu')
                ->with('menuadd', 'Ingredient '.'"'.ucfirst($nm).'"'.' Added!');  
            elseif ($q=="pd")  
                return \Redirect::route('pdmenu')
                ->with('menuadd', 'Product '.'"'.ucfirst($nm).'"'.' Added!');
            else                                                     
                return \Redirect::route('mnmenu')
                ->with('menuadd', 'Menu Item '.'"'.ucfirst($nm).'"'.' Added!');               
        }
                     
            
        else
            abort(403, 'Unauthorized action.');
        
                
            
    }

    

    public function destroy($q)
    {
        if (Gate::allows('manager')) 
        {
            menu::where('name','=',$q)->update(['status' => 0]);
            $type=menu::where('name','=',$q)->select('type')->get();
            
            if($type=='[{"type":"ig"}]')
            return \Redirect::route('igmenu')        
                        ->with('menudel', 'Ingredient '.'"'.ucfirst($q).'"'.' Deleted!');
            elseif($type=='[{"type":"pd"}]')
                return \Redirect::route('pdmenu')        
                        ->with('menudel', 'Product '.'"'.ucfirst($q).'"'.' Deleted!');
            else
                return \Redirect::route('mnmenu')        
                        ->with('menudel', 'Menu Item '.'"'.ucfirst($q).'"'.' Deleted!');

        }
        else
            abort(403, 'Unauthorized action.');
    }

    public function edit($q)
    {
        if (Gate::allows('manager')) 
        {
            $menu=menu::where('name','=',$q)->get();
            $ddunit=units::select('unit_name','id')
            ->where('status','=',1)
            ->get();
            $ddcat=category::select('name','id')
            ->where('status','=',1)
            ->get();
            
           
            return view('/menuedit',['menu'=>$menu,'ddunit'=>$ddunit,'ddcat'=>$ddcat]);
                        
        }
        else
            abort(403, 'Unauthorized action.');
    }

    
}

