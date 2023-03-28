@extends('layouts.app')
@section('content')

 
<script type="text/javascript">
function cnf(){
        var cnfdlt=confirm("Confirm Restore?");
        if(cnfdlt==true)
            return true;
        else 
            return false;
    }
    
</script>
<script src="{{ asset('js/menuBadge.js') }}" defer></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3><b>Restore 
            @if($q=="ig")
            Ingredients
            @elseif($q=="pd")
            Products
            @else 
            Menu Items 
            @endif
            </b></h3>
            
            
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
                                    <div class="col-12" style="font-size: 12px;" >
                                        <b>{{ucfirst($ml->mname)}}</b>
                                       
                                    </div>
                                        
                                </div>
                                 <div class="row">
                                    <div class="col-12" style="font-size: 12px;" >

                                       <b>Unit:</b> {{$ml->unit_name}}
                                        @if($q!="ig")
                                        <b>SP:</b> {{$ml->sp}}
                                        @endif
                                        <span style="float:right; overflow: auto;">
                                           

                                            <a href="/menuRestore/restore/{{$ml->mname}}" onclick="return cnf()">
                                              <img src="{{asset('png/restore.png')}}">
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
