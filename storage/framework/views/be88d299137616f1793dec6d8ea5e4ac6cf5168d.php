<?php $__env->startSection('content'); ?>
 <script src="<?php echo e(asset('js/menuBadge.js')); ?>" defer></script> 
  <script src="<?php echo e(asset('js/exif.js')); ?>" ></script> 
 <script src="<?php echo e(asset('js/croppie.js')); ?>" ></script> 
 
 <link href="<?php echo e(asset('css/croppie.css')); ?>" rel="stylesheet">
 <script src="<?php echo e(asset('js/imageCrop.js')); ?>" ></script> 
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
                <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mnn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                <?php
                $name=$mnn->name;
                ?>
                <?php if($mnn->type=="ig"): ?>
                Ingredient 
                <?php elseif($mnn->type=="pd"): ?>
                Product
                <?php else: ?>
                Menu Item
                <?php endif; ?> 
                "<?php echo e(ucfirst($mnn->name)); ?>" 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </b></h3>
            
            <div class="card" style="margin-bottom: 10px;">
               
                <div class="card-body"> 
                    <form method="POST" action="/menuedit" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                          <input type="hidden" id="base64" name="base64">
                        <div class="form-row mb-1">
                            
                            <label for="category" class="col-md-1 col-form-label">
                                Category
                            </label>
                            <div class="col-md-3 mr-4">
                                <select name="category" class="form-control">
                                    <?php $__currentLoopData = $ddcat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($dc->id==$mn->f_cat): ?>
                                    <option selected><?php echo e(ucfirst($dc->name)); ?></option>
                                    <?php else: ?>
                                    <option><?php echo e(ucfirst($dc->name)); ?></option>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                
                            </div>
                            <label for="units" class="col-md-1 col-form-label">
                                Units
                            </label>
                            <div class="col-md-3 mr-4">
                                <select name="units" class="form-control">
                                    <?php $__currentLoopData = $ddunit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $du): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($du->id==$mn->f_id): ?>
                                    <option selected><?php echo e($du->unit_name); ?></option>
                                    <?php else: ?>
                                    <option><?php echo e($du->unit_name); ?></option>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                        
                            </div>                          
                            
                        </div>
                       
                     
                        
                        <div class="form-row mb-1">
                            <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mnn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                            <?php if($mnn->type!=="ig"): ?>
                            <label for="sp" class="col-md-1 col-form-label">
                                S-Price
                            </label>
                            <div class="col-md-2 mr-5">
                                <input type="number" min="0" class="form-control" name="sp" value="<?php echo e($mnn->sp); ?>" required>
                                
                            </div>
                            
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <input type="hidden" value="<?php echo e($name); ?>" name="menuname">
                        
                       
                        

                        
                    </form>
                   
                </div>

            </div>
        </div>
    </div>   
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//menuedit.blade.php ENDPATH**/ ?>