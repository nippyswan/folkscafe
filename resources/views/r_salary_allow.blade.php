@extends('layouts.app')

@section('content')
@if(Session::has('rerror')) <div class="alert alert-warning"> {{Session::get('rerror')}} </div> @endif
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

                    <h3>Salary & Allowance Return Entry</h3>
                    <hr>
                    <form method="POST" action="/r_salary_allow">
                        @csrf
                        <div class="form-group form-row">
                            <div class="col-md-6">
                                <label for="ty">Type</label>

                                <select id="ty" class="form-control" name="ty" >
                                                                             
                                    <option>Salary</option>
                                    <option>Allowance</option>
                                                                      
                                                                                                                                                                     
                                     
                                </select>                                  
                                                        
                            </div> 
                                               
                        </div>
                        <div class="form-group form-row">
                            <div class="col-md-6">
                                <label for="amt">Amount</label>

                                <input id="amt" type="number" min="1" class="form-control{{ $errors->has('amt') ? ' is-invalid' : '' }}" name="amt" value="{{ old('amt') }}" required autofocus>

                                @if ($errors->has('amt'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('amt') }}</strong>
                                    </span>
                                @endif
                                                        
                            </div>                    
                        </div>
                        <div class="form-group form-row">
                            <div class="col-md-6">
                                <label for="inv">Employee</label>

                                <select id="inv" class="form-control" name="inv" >
                                    @foreach($invx as $inv)
                                          
                                    <option>{{ucfirst($inv->username)}}</option>
                                                                           
                                    @endforeach  
                                                                                                                                    
                                     
                                </select>  
                               
                                
                                                        
                            </div> 
                                               
                        </div>

                        <div class="form-group form-row">
                            <div class="col-md-3" class="form-control">
                                <button type="submit" onclick="return cnf()" class="btn btn-form1" style="color:white;">
                                    Submit
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
