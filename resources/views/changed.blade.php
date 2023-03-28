@extends('layouts.app')

@section('content')
@if(Session::has('samevalue')) <div class="alert alert-warning"> {{Session::get('samevalue')}} </div> @endif
@if(Session::has('editted')) <div class="alert alert-success"> {{Session::get('editted')}} </div> @endif

<div class="container">
     <script src="{{ asset('js/changedES.js') }}" ></script>  
     <script type="text/javascript">
     	if(typeof changedES=='function')
		{
		   changedES(0,0,'<?php echo Auth::user()->username; ?>');
		}
		function cnfchanged()
		{	
			var c=confirm("Confirm Action?");
			if(c==true)
				return true;
			else
				return false;
			
		}	
		
     </script>

    <script src="{{ asset('js/menuBadge.js') }}" ></script>  
   
     


    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3><b>Changed Orders</b></h3>
        </div>
    </div >
            
    <div id="changedES" style="margin-bottom: 50px;"> 
    
</div>
</div>
@endsection
