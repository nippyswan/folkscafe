@extends('layouts.app')

@section('content')
 <script src="{{ asset('js/menuBadge.js') }}" defer></script> 
  <script src="{{ asset('js/exif.js') }}" ></script> 
 <script src="{{ asset('js/croppie.js') }}" ></script> 
 
 <link href="{{ asset('css/croppie.css') }}" rel="stylesheet">
 <script src="{{ asset('js/imageCrop.js') }}" ></script> 
<script type="text/javascript">
    function cnf(){
        var cnf=confirm("Confirm Action?");
        if(cnf==true)
            return true;
        else 
            return false;
    }

</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3><b>Edit
                @foreach($menu as $mnn) 
                @php
                $name=$mnn->name;
                @endphp
                @if($mnn->type=="ig")
                Ingredient 
                @elseif($mnn->type=="pd")
                Product
                @else
                Menu Item
                @endif 
                "{{ucfirst($mnn->name)}}" 
                @endforeach
            </b></h3>
            
            <div class="card" style="margin-bottom: 10px;">
               
                <div class="card-body"> 
                    <form method="POST" action="/menuedit" enctype="multipart/form-data">
                        @csrf
                          <input type="hidden" id="base64" name="base64">
                        <div class="form-row mb-1">
                            
                            <label for="category" class="col-md-1 col-form-label">
                                Category
                            </label>
                            <div class="col-md-3 mr-4">
                                <select name="category" class="form-control">
                                    @foreach($ddcat as $dc)
                                    @foreach($menu as $mn)
                                    @if($dc->id==$mn->f_cat)
                                    <option selected>{{ucfirst($dc->name)}}</option>
                                    @else
                                    <option>{{ucfirst($dc->name)}}</option>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </select>
                                
                            </div>
                            <label for="units" class="col-md-1 col-form-label">
                                Units
                            </label>
                            <div class="col-md-3 mr-4">
                                <select name="units" class="form-control">
                                    @foreach($ddunit as $du)
                                    @foreach($menu as $mn)
                                    @if($du->id==$mn->f_id)
                                    <option selected>{{$du->unit_name}}</option>
                                    @else
                                    <option>{{$du->unit_name}}</option>
                                    @endif
                                    @endforeach
                                    
                                    @endforeach
                                </select>
                        
                            </div>                          
                            
                        </div>
                       
                     
                        
                        <div class="form-row mb-1">
                            @foreach($menu as $mnn) 
                            @if($mnn->type!=="ig")
                            <label for="sp" class="col-md-1 col-form-label">
                                S-Price
                            </label>
                            <div class="col-md-2 mr-5">
                                <input type="number" min="0" class="form-control" name="sp" value="{{$mnn->sp}}" required>
                                
                            </div>
                            
                            @endif
                            @endforeach
                            <label for="icon" class="col-md-1 col-form-label">
                                Image
                            </label>
                            <div class="col-md-3">
                                <input type="file" class="form-control-file" name="icon" id="dp" accept="image/*" onchange="crop()">
                            </div>
                            <div class="col-md-3" class="form-control">
                                <label class="col-md-1"></label>
                                <button type="submit" onclick="return cnf()" class="btn btn-form1" style="color:white;">
                                    Edit
                                </button>
                            </div>                           
                        </div>
                        <input type="hidden" value="{{$name}}" name="menuname">
                        
                       
                        

                        
                    </form>
                   
                </div>

            </div>
        </div>
    </div>   
</div>
@endsection