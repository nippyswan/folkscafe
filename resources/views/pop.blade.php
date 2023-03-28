@extends('layouts.app')

@section('content')
@if(Session::has('samevalue')) <div class="alert alert-warning"> {{Session::get('samevalue')}} </div> @endif
@if(Session::has('editted')) <div class="alert alert-success"> {{Session::get('editted')}} </div> @endif

<div class="container">
     <script src="{{ asset('js/popES.js') }}" ></script>  
     <script type="text/javascript">
     	if(typeof popES=='function')
		{
		   popES(0,0,'<?php echo Auth::user()->username; ?>');
		}
		function cnfpop()
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
            <h3><b>Product Orders Pending</b></h3>
        </div>
    </div >
            
    <div id="popES" style="margin-bottom: 50px;"> 
    
</div>
</div>
@endsection
