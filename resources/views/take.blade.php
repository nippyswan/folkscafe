@extends('layouts.app')

@section('content')
@if(Session::has('taken')) <div class="alert alert-success"> {{Session::get('taken')}} </div> @endif


<div class="container">

 <script src="{{ asset('js/menuBadge.js') }}" defer></script>  

     

<script src="{{ asset('js/addOrder.js') }}" ></script>
    <form method="POST" action="/take" onsubmit="return sendjson()" name="takeform">
        @csrf
        <input type="hidden" name="jsondata">
     
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3><b>Take Order</b></h3>
                
                
             

                <div class="card" style="margin-bottom: 10px;">
                   
                    <div class="card-body"> 

                        <div class="form-group form-row">
                            <div class="col-md-2">
                                <label for="table"><b>Table No.</b></label>

                                <select id="table" class="form-control" name="table" >
                                    @foreach($invx as $inv)
                                          
                                    <option>{{ucfirst($inv->table_no)}}</option>
                                                                           
                                    @endforeach  
                                                                                                                                    
                                     
                                </select>  
                                @can('manager', auth()->user()) 
                                <a class="btn btn-link" href="/table">Add/Remove Tables</a>
                                @endcan
                                
                                                        
                            </div> 
                                               
                        </div>
                        @can('manager', auth()->user()) 
                        <div class=" row justify-content-end">
                            <a class="btn btn-link" href="/menu/mn">Add/Remove Menu Items</a>
                        </div>
                        @endcan
                        <div class="table-responsive table-striped">
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                <tr style="background-color: #48494b; font-weight: bold; color:white;">
                                  
                                    <td>
                                        Items
                                    </td>
                                   
                                    <td colspan="2" align="center">
                                        Qty
                                    </td>
                                    
                                    <td>
                                        Price (Rs.)
                                    </td>
                                </tr>
                                </thead>
                                <tbody id="tb">

                              
                             
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-end" >
                            <pre id="total"></pre>

                        </div>
                        <div class="form-group form-row justify-content-end">
                            <div class="col-md-3" class="form-control">
                                <button type="submit"  class="btn btn-secondary">
                                    Submit
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>   
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @for($i=0;$i < count($category);$i++)
                @php
                $catg=str_replace(' ','',$category[$i]);
                @endphp
                @if($i==0)
                <a class="nav-item nav-link active" id="{{$catg}}-tab" data-toggle="tab" href="#{{$catg}}" role="tab" aria-controls="{{$catg}}" aria-selected="true" >
                    <b>{{ucfirst($category[$i])}}</b>
                </a>
                @else
                <a class="nav-item nav-link" id="{{$catg}}-tab" data-toggle="tab" href="#{{$catg}}" role="tab" aria-controls="{{$catg}}" aria-selected="true" >
                    <b>{{ucfirst($category[$i])}}</b>
                </a>
                @endif
                @endfor
            </div>
        </nav>
        <hr>
        <div class="tab-content mb-5" id="nav-tabContent">
            @for($i=0;$i < count($category);$i++)
            @php
                $catg=str_replace(' ','',$category[$i]);
                @endphp
            @if($i==0)
            <div class="tab-pane fade show active" id="{{$catg}}" role="tabpanel" aria-labelledby="{{$catg}}-tab">
            @else
            <div class="tab-pane fade" id="{{$catg}}" role="tabpanel" aria-labelledby="{{$catg}}-tab">
            @endif
                <div class="row no-gutters">
                    
                    @foreach($menulist as $ml)
                        @if($ml->cname==$category[$i])
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 m-0 p-0 justify-content-start">
                        <button class="mr-auto ml-auto mt-2 mb-2 anoj p-0" onclick="return addOrder('{{$ml->mname}}','{{$ml->sp}}','{{$ml->unit_name}}')" style="border-radius: 15%; width:145px;">
                        <div class="row no-gutters" style="border-radius: 15%;" >    
                        <div class="col-12 " >
                            <div class="card m-0 p-0" style="border-radius: 15%;">
                               
                                <div class="card-body pt-2 pb-0" style="border-radius: 15%;background-color: #eedc82; border-style: solid;
            border-color: #c1a878;">
                                    
                                    <div class="row no-gutters mb-1">
                                        <div class="col-6" align="left">
                                            <span class="badge badge-light" style="font-size: 16px; " id="{{$ml->mname}}c">x0</span>
                                        </div>
                                        <div class="col-6" align="right">
                                            <a onclick="return remX('{{$ml->mname}}','{{$ml->sp}}','{{$ml->unit_name}}')" style="cursor: default;">
                                                <img src="/png/remove.png" style="height: 25px; width: 25px;" class="img-fluid"  >
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row no-gutters" style="border-radius: 15%;">

                                        <div class="col-12 p-0" style="background-color: #eee; ">

                                            @if($ml->imgurl!=NULL)
                                            @if($ml->type=="pd")
                                            
                                            <img src="/storage/products/{{$ml->imgurl}}" style=" height:110px;max-height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            @else
                                            <img src="/storage/menus/{{$ml->imgurl}}" style="height:110px;max-height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            @endif
                                            
                                           
                                            @else
                                            <img src="/storage/ingredients/ig.jpg" style="height:110px; max-height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            @endif
                                            
                                            
                                        </div>
                                        
                                            
                                      
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="font-size: 12px;" >
                                            <b id="{{$ml->mname}}a">{{ucfirst($ml->mname)}}</b>
                                           
                                        </div>
                                            
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="font-size: 12px;">
                                            Rs. <span id="{{$ml->mname}}b">{{$ml->sp}}</span> per {{$ml->unit_name}}
                                           
                                        </div>
                                            
                                    </div> 
                                  
                                                                      
                                    
                                    
                                    
                                    
                                           
                                            
                                     
                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                        </button>
                        </div>
                        @endif
                    @endforeach
                    
                </div>
            </div>
           
            @endfor
        </div>      
                   
    </form>                
         
</div>
@endsection
