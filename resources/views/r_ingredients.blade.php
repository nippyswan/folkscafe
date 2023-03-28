@extends('layouts.app')

@section('content')
@if(Session::has('rcombo')) <div class="alert alert-warning"> {{Session::get('rcombo')}} </div> @endif
 <script src="{{ asset('js/menuBadge.js') }}" defer></script> 
<script type="text/javascript">
    function cnf(){
        var cnf=confirm("Confirm Action?");
        if(cnf==true)
            return true;
        else 
            return false;
    }

</script>
<script src="{{ asset('js/menulist.js') }}" ></script>
<div class="container">
     
    <form method="POST" action="/r_ingredients">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3><b>Ingredients Return Entry</b></h3>
                <div class=" row justify-content-end">
                    <a class="btn btn-link" href="/menu/ig">Add/Remove Ingredients</a>
                </div>
                <div class="card" style="margin-bottom: 10px;">
                   
                    <div class="card-body"> 
                        <div class="table-responsive table-striped">
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                <tr>
                                    <th>
                                        S.N.
                                    </th>
                                    <th>
                                        Items
                                    </th>
                                    <th>
                                        Qty
                                    </th>
                                    <th>
                                        Price (Rs.)
                                    </th>
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
                                <button type="submit" onclick="return cnf()" class="btn btn-secondary">
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
                            <div class="card mr-auto ml-auto mt-2 mb-2" style="width:145px;">
                               
                                <div class="card-body">
                                    <div class="row no-gutters" style="height: 110px;">
                                        <div class="col-12 p-0" style="background-color: grey;" >
                                            @if($ml->imgurl!=NULL)
                                            
                                            
                                            <img src="/storage/ingredients/{{$ml->imgurl}}" style="max-height: 110px;height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            
                                           
                                            @else
                                            <img src="/storage/ingredients/ig.jpg" style="max-height: 110px; height: 110px;margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="font-size: 12px;" >
                                            <b id="{{$ml->mname}}a">{{ucfirst($ml->mname)}}</b>
                                           
                                        </div>
                                            
                                    </div>
                                                                      
                                    
                                    <div class="form-row mb-1">
                                        <div class="col-9">
                                            <input type="number" min="1" class="form-control" name="{{$ml->id}}a" id="{{$ml->id}}a" oninput="addMenuItem('{{$ml->mname}}','{{$ml->id}}')" placeholder="Qty" >
                                            
                                        </div>
                                        <label for="qty" class="col-3 col-form-label" id="{{$ml->mname}}b" style="font-size: 12px;">
                                            {{$ml->unit_name}} 
                                        </label>
                                        
                                    </div>
                                    <div class="form-row">
                                        <label for="price" class="col-3 col-form-label" align="right" style="font-size: 12px;">
                                            Rs
                                        </label>
                                        <div class="col-9">
                                            <input type="number" min="1" class="form-control" name="{{$ml->id}}b" id="{{$ml->id}}b" oninput="addMenuItem('{{$ml->mname}}','{{$ml->id}}')" placeholder="Amt">
                                        </div>
                                    </div>

                                    
                                    
                                           
                                            
                                     
                                    
                                    
                                    
                                </div>
                            </div>
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
