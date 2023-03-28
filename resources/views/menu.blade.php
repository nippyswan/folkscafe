@extends('layouts.app')

@section('content')
@if(Session::has('menudel')) <div class="alert alert-success"> {{Session::get('menudel')}} </div> @endif
@if(Session::has('menuadd')) <div class="alert alert-success"> {{Session::get('menuadd')}} </div> @endif
@if(Session::has('menuedit')) <div class="alert alert-success"> {{Session::get('menuedit')}} </div> @endif
<script src="{{ asset('js/exif.js') }}" ></script> 
 <script src="{{ asset('js/croppie.js') }}" ></script> 
 
 <link href="{{ asset('css/croppie.css') }}" rel="stylesheet">
 <script src="{{ asset('js/imageCrop.js') }}" ></script>  
<script type="text/javascript">
function cnf(){
        var cnfdlt=confirm("Confirm Edit?");
        if(cnfdlt==true)
            return true;
        else 
            return false;
    }
    function cnfadd(){
        var cnfdlt=confirm("Confirm Add?");
        if(cnfdlt==true)
            return true;
        else 
            return false;
    }
    function cnfdlt(){
        var cnfdlt=confirm("Confirm Delete?");
        if(cnfdlt==true)
            return true;
        else 
            return false;
    }
</script>

<div class="container">
    <script src="{{ asset('js/menuBadge.js') }}" defer></script> 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3><b>Add / Remove 
            @if($q=="ig")
            Ingredients
            @elseif($q=="pd")
            Products
            @else 
            Menu Items 
            @endif
            </b></h3>
            
            <div class="card" style="margin-bottom: 10px;">
               
                <div class="card-body"> 
                    <form method="POST" action="/menu" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="base64" name="base64">
                        <div class="form-group form-row mb-1">
                            <label for="igname" class="col-md-1 col-form-label">
                                Name
                            </label>
                            <div class="col-md-2 mr-4" >
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                
                            </div> 
                            <label for="icon" class="col-md-1 col-form-label">
                                Image
                            </label>
                            <div class="col-md-3">
                                <input type="file" class="form-control-file" name="icon" id="dp" accept="image/*" onchange="crop()">
                            </div>
                            <label for="category" class="col-md-1 col-form-label">
                                Category
                            </label>
                            <div class="col-md-3 mr-4">
                                <select name="category" class="form-control">
                                    @foreach($ddcat as $dc)
                                    <option>{{ucfirst($dc->name)}}</option>
                                    @endforeach
                                </select>
                                <a class="btn btn-link" href="/category">Add/Remove Categories</a>
                            </div>
                            <label for="units" class="col-md-1 col-form-label">
                                Units
                            </label>
                            <div class="col-md-3 mr-4">
                                <select name="units" class="form-control">
                                    @foreach($ddunit as $du)
                                    <option>{{$du->unit_name}}</option>
                                    @endforeach
                                </select>
                                <a class="btn btn-link" href="/units">Add/Remove Units</a>
                            </div>                      
                            @if($q!=="ig")
                            <label for="sp" class="col-md-1 col-form-label">
                                S-Price
                            </label>
                            <div class="col-md-2 mr-5">
                                <input type="number" min="0" class="form-control" name="sp" required>
                                
                            </div>
                            
                            @endif
                            
                            <div class="col-md-3" >
                                <label class="col-md-1"></label>
                                <button type="submit" onclick="return cnfadd()" class="btn btn-form1" style="color:white;">
                                    Add
                                </button>
                            </div>   
                        </div>                        
                        
                        <input type="hidden" value="{{$q}}" name="q">
                       
                        

                        
                    </form>
                    <div class="row justify-content-end">
                        <a class="btn btn-link" href="/menuRestore/{{$q}}">
                            Show Deleted 
                            @if($q=="ig")
                            Ingredients
                            @elseif($q=="pd")
                            Products
                            @else 
                            Menu Items 
                            @endif
                        </a>
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
                            <div class="card mr-auto ml-auto mt-2 mb-2" style="width:145px;">
                               
                                <div class="card-body">
                                    <div class="row no-gutters" style="height: 110px;">
                                        <div class="col-12 p-0" style="background-color: grey;" >
                                        @if($ml->imgurl!=NULL)
                                        @if($q=="ig")
                                        
                                        <img src="/storage/ingredients/{{$ml->imgurl}}" style="max-height: 110px;height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                        
                                        @elseif($q=="pd")
                                        <img src="/storage/products/{{$ml->imgurl}}" style="max-height: 110px;height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                        @else
                                        <img src="/storage/menus/{{$ml->imgurl}}" style="max-height: 110px;height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                        @endif
                                        @else
                                        <img src="/storage/ingredients/ig.jpg" style="max-height: 110px;height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" style="font-size: 12px;">
                                        <b>{{ucfirst($ml->mname)}}</b>
                                       
                                    </div>
                                        
                                </div>
                                 <div class="row">
                                    <div class="col-12" style="font-size: 12px;">

                                       <b>Unit:</b> {{$ml->unit_name}}
                                        @if($q!="ig")
                                        <b>SP:</b> {{$ml->sp}}
                                        @endif
                                        <span style="float:right; overflow: auto;">
                                            <a href="/menu/{{$ml->mname}}/edit" onclick="return cnf()">
                                              <img src="{{asset('png/edit.png')}}">
                                            </a>

                                            <a href="/menu/delete/{{$ml->mname}}" onclick="return cnfdlt()">
                                              <img src="{{asset('png/delt.png')}}">
                                            </a>  

                                        </span>
                                    </div>
                                </div>
                               
                                <h6 align="center"></h6>
                                
                                
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        
        @endfor
    </div>   

    
    
</div>
@endsection
