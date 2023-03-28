<?php $__env->startSection('content'); ?>
<?php if(Session::has('datarest')): ?> <div class="alert alert-success"> <?php echo e(Session::get('datarest')); ?> </div> <?php endif; ?>
 <script src="<?php echo e(asset('js/menuBadge.js')); ?>" defer></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    You are logwwwwged in!<br>
                    Hey Shital! How Are You? <br>
                    <img src="<?php echo e(asset('png/avik5.png')); ?>" height=100px;>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views/home.blade.php ENDPATH**/ ?>