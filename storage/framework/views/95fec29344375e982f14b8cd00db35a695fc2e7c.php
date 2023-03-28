<?php $__env->startSection('content'); ?>
 <script src="<?php echo e(asset('js/menuBadge.js')); ?>" defer></script> 
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
                    <?php if(session('status')): ?>
                    <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                    </div>
                    <?php endif; ?>

                    <h3>Investments Entry</h3>
                    <hr>
                    <form method="POST" action="/investments">
                        <?php echo csrf_field(); ?>

                        <div class="form-group form-row">
                            <div class="col-md-6">
                                <label for="amt">Amount</label>

                                <input id="amt" type="number" min="1" class="form-control<?php echo e($errors->has('amt') ? ' is-invalid' : ''); ?>" name="amt" value="<?php echo e(old('amt')); ?>" required autofocus>

                                <?php if($errors->has('amt')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('amt')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                                        
                            </div>                    
                        </div>
                        <div class="form-group form-row">
                            <div class="col-md-6">
                                <label for="inv">Investor</label>

                                <select id="inv" class="form-control" name="inv" >
                                    <?php $__currentLoopData = $invx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          
                                    <option><?php echo e(ucfirst($inv->name)); ?></option>
                                                                           
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                                                                                                                    
                                     
                                </select>  
                                <a class="btn btn-link" href="/investor">Add/Remove Investor</a>
                                
                                                        
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//investments.blade.php ENDPATH**/ ?>