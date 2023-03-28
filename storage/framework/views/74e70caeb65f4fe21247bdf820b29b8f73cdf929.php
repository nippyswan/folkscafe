<?php $__env->startSection('content'); ?>

 
<script type="text/javascript">
function cnf(){
        var cnfdlt=confirm("Confirm Restore?");
        if(cnfdlt==true)
            return true;
        else 
            return false;
    }
    
</script>
<script src="<?php echo e(asset('js/menuBadge.js')); ?>" defer></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3><b>Restore 
            <?php if($q=="ig"): ?>
            Ingredients
            <?php elseif($q=="pd"): ?>
            Products
            <?php else: ?> 
            Menu Items 
            <?php endif; ?>
            </b></h3>
            
            
        </div>
    </div>



    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <?php for($i=0;$i < count($category);$i++): ?>
            <?php
            $catg=str_replace(' ','',$category[$i]);
            ?>
            <?php if($i==0): ?>
            <a class="nav-item nav-link active" id="<?php echo e($catg); ?>-tab" data-toggle="tab" href="#<?php echo e($catg); ?>" role="tab" aria-controls="<?php echo e($catg); ?>" aria-selected="true" >
                <b><?php echo e(ucfirst($category[$i])); ?></b>
            </a>
            <?php else: ?>
            <a class="nav-item nav-link" id="<?php echo e($catg); ?>-tab" data-toggle="tab" href="#<?php echo e($catg); ?>" role="tab" aria-controls="<?php echo e($catg); ?>" aria-selected="true" >
                <b><?php echo e(ucfirst($category[$i])); ?></b>
            </a>
            <?php endif; ?>
            <?php endfor; ?>
        </div>
    </nav>
    <hr>
    <div class="tab-content mb-5" id="nav-tabContent">
        <?php for($i=0;$i < count($category);$i++): ?>
        <?php
            $catg=str_replace(' ','',$category[$i]);
            ?>
        <?php if($i==0): ?>
        <div class="tab-pane fade show active" id="<?php echo e($catg); ?>" role="tabpanel" aria-labelledby="<?php echo e($catg); ?>-tab">
        <?php else: ?>
        <div class="tab-pane fade" id="<?php echo e($catg); ?>" role="tabpanel" aria-labelledby="<?php echo e($catg); ?>-tab">
            
        <?php endif; ?>
            <div class="row no-gutters">
            
                <?php $__currentLoopData = $menulist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ml): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($ml->cname==$category[$i]): ?>
                  <div class="col-6 col-sm-4 col-md-3 col-lg-2 m-0 p-0 justify-content-start">
                            <div class="card mr-auto ml-auto mt-2 mb-2" style="width:145px;">
                               
                                <div class="card-body">
                                    <div class="row no-gutters" style="height: 110px;">
                                        <div class="col-12 p-0" style="background-color: grey;" >
                                        <?php if($ml->imgurl!=NULL): ?>
                                        <?php if($q=="ig"): ?>
                                        
                                        <img src="/storage/ingredients/<?php echo e($ml->imgurl); ?>" style="max-height: 110px;height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                        
                                        <?php elseif($q=="pd"): ?>
                                        <img src="/storage/products/<?php echo e($ml->imgurl); ?>" style="max-height: 110px;height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                        <?php else: ?>
                                        <img src="/storage/menus/<?php echo e($ml->imgurl); ?>" style="max-height: 110px;height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                        <?php endif; ?>
                                        <?php else: ?>
                                        <img src="/storage/ingredients/ig.jpg" style="max-height: 110px;height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" style="font-size: 12px;" >
                                        <b><?php echo e(ucfirst($ml->mname)); ?></b>
                                       
                                    </div>
                                        
                                </div>
                                 <div class="row">
                                    <div class="col-12" style="font-size: 12px;" >

                                       <b>Unit:</b> <?php echo e($ml->unit_name); ?>

                                        <?php if($q!="ig"): ?>
                                        <b>SP:</b> <?php echo e($ml->sp); ?>

                                        <?php endif; ?>
                                        <span style="float:right; overflow: auto;">
                                           

                                            <a href="/menuRestore/restore/<?php echo e($ml->mname); ?>" onclick="return cnf()">
                                              <img src="<?php echo e(asset('png/restore.png')); ?>">
                                            </a>  

                                        </span>
                                    </div>
                                </div>
                               
                                <h6 align="center"></h6>
                                
                                
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        
        <?php endfor; ?>
    </div>   

    
    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//menuRestore.blade.php ENDPATH**/ ?>