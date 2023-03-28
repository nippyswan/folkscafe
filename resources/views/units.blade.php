@extends('layouts.app')

@section('content')
@if(Session::has('idel')) <div class="alert alert-success"> {{Session::get('idel')}} </div> @endif
@if(Session::has('iadd')) <div class="alert alert-success"> {{Session::get('iadd')}} </div> @endif
@if(Session::has('ires')) <div class="alert alert-success"> {{Session::get('ires')}} </div> @endif
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
               
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                    </div>
                    @endif

                    <h3>Add / Remove Unit</h3>
                    <hr>
                    <form method="POST" action="/units">
                        @csrf
                        <div class="form-group form-row">
                            <div class="col-5">
                                Name
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <div class="col-9">
                                

                                <input id="unit_name" type="text" class="form-control{{ $errors->has('unit_name') ? ' is-invalid' : '' }}" name="unit_name" value="{{ old('unit_name') }}" required autofocus>

                                @if ($errors->has('unit_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('unit_name') }}</strong>
                                    </span>
                                @endif
                                                        
                            </div>                    

                            <div class="col-3" class="form-control">
                                
                                <button type="submit" onclick="return cnf()" class="btn btn-form1" style="color:white;">
                                    Add 
                                </button>
                            </div>
                        </div>                    
                    </form>
                    <hr>
                    <div class="row justify-content-end">
                        <a class="btn btn-link" href="/unitsRestore">
                            Show Deleted Units

                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <th>
                                <div align="center">S.N.</div>
                            </th>
                            <th>Name</th>
  
                            @foreach($invx as $inv)
                            <tr>
                                <td>
                                    <div align="center">{{$loop->iteration}}</div>
                                </td>
                                    
                               
                                <td >
                                    <span style="float:left; overflow: auto;">{{$inv->unit_name}}</span>
                                    <span style="float:right; overflow: auto;">
                                    <a href="/units/{{{$inv->unit_name}}}" onclick="return cnf()">
                                      <img src="png/delt.png">
                                    </a>  
                                    </span>                                 
                                            
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
