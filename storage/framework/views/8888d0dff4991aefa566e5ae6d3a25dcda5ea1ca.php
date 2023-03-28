<?php $__env->startSection('content'); ?>
<?php if(Session::has('samevalue')): ?> <div class="alert alert-warning"> <?php echo e(Session::get('samevalue')); ?> </div> <?php endif; ?>
<?php if(Session::has('editted')): ?> <div class="alert alert-success"> <?php echo e(Session::get('editted')); ?> </div> <?php endif; ?>

<div class="container">
     <script src="<?php echo e(asset('js/popES.js')); ?>" ></script>  
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

    <script src="<?php echo e(asset('js/menuBadge.js')); ?>" ></script>  
   
     


    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3><b>Product Orders Pending</b></h3>
        </div>
    </div >
            
    <div id="popES" style="margin-bottom: 50px;"> 
    
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//pop.blade.php ENDPATH**/ ?>