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


class menueditController extends Controller
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
     * @return \Illuminate\Http\Response*/
    public function store(Request $request)
        {
            if (Gate::allows('manager')) 
            {
                $name=$request->get('menuname');
                $menu=menu::where('name','=',$name)->get();
                foreach($menu as $mnu)
                {
                    
                    $ty=$mnu->type;
                }
              
                $units=$request->get('units');
                $category=$request->get('category');
                $sp=$request->get('sp');
                
                $unitsx=units::where('unit_name','=',$units)->get();
                foreach ($unitsx as $un) {
                    $units_id=$un->id;
                }
                $catx=category::where('name','=',$category)->get();
                foreach ($catx as $un) {
                    $category_id=$un->id;
                }
                
                
                $oldimage=menu::where('name','=',$name)->select('imgurl')->get();
                foreach ($oldimage as $key) {
                    $oldimageurl=$key->imgurl;
                }
              
                if($request->file('icon')!=NULL)
                {
                    $data=$request->get('base64');
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);

                    $fn=uniqid().'.png';
                    $imgurl=$fn;
                    if($ty=="ig")
                    {
                        //$path = $request->file('icon')->store('ingredients');
                        //$imgurl=$request->icon->hashName();

                        Storage::put('ingredients/'.$fn, $data);

                        Storage::disk('public')->delete('/ingredients/'.$oldimageurl);
                        menu::where('name','=',$name)->update(['f_id' => $units_id,'f_cat'=>$category_id,'imgurl'=>$imgurl]);
                    }
                    elseif($ty=="pd")
                    {
                        //$path = $request->file('icon')->store('products');
                        //$imgurl=$request->icon->hashName();

                        Storage::put('products/'.$fn, $data);

                        Storage::disk('public')->delete('/products/'.$oldimageurl);
                        menu::where('name','=',$name)->update(['f_id' => $units_id,'f_cat'=>$category_id,'imgurl'=>$imgurl,'sp'=>$sp]);
                    }
                    else
                    {
                        //$path = $request->file('icon')->store('menus');
                        //$imgurl=$request->icon->hashName();

                        Storage::put('menus/'.$fn, $data);

                        Storage::disk('public')->delete('/menus/'.$oldimageurl);
                        menu::where('name','=',$name)->update(['f_id' => $units_id,'f_cat'=>$category_id,'imgurl'=>$imgurl,'sp'=>$sp]);
                    }
                    
                    
                }
                else
                {
                    if($ty=="ig")
                    {
                        
                        
                        menu::where('name','=',$name)->update(['f_id' => $units_id,'f_cat'=>$category_id]);
                    }
                    elseif($ty=="pd")
                    {
                       
                        
                        menu::where('name','=',$name)->update(['f_id' => $units_id,'f_cat'=>$category_id,'sp'=>$sp]);
                    }
                    else
                    {
                       
                        
                        menu::where('name','=',$name)->update(['f_id' => $units_id,'f_cat'=>$category_id,'sp'=>$sp]);
                    }  
                }
            

                

                
                
               

                
                if($ty=="ig")
                return \Redirect::route('igmenu')
                    ->with('menuedit', 'Ingredient '.'"'.$name.'"'.' Edited!');  
                elseif($ty=="pd")
                 return \Redirect::route('pdmenu')
                    ->with('menuedit', 'Product '.'"'.$name.'"'.' Edited!');  
                else
                 return \Redirect::route('mnmenu')
                    ->with('menuedit', 'Menu Item '.'"'.$name.'"'.' Edited!');  
                          
            }
                         
                
            else
                abort(403, 'Unauthorized action.');
            
                    
                
        }
}