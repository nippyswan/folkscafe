<?php $__env->startSection('content'); ?>
<?php if(Session::has('menudel')): ?> <div class="alert alert-success"> <?php echo e(Session::get('menudel')); ?> </div> <?php endif; ?>
<?php if(Session::has('menuadd')): ?> <div class="alert alert-success"> <?php echo e(Session::get('menuadd')); ?> </div> <?php endif; ?>
<?php if(Session::has('menuedit')): ?> <div class="alert alert-success"> <?php echo e(Session::get('menuedit')); ?> </div> <?php endif; ?>
<script src="<?php echo e(asset('js/exif.js')); ?>" ></script> 
 <script src="<?php echo e(asset('js/croppie.js')); ?>" ></script> 
 
 <link href="<?php echo e(asset('css/croppie.css')); ?>" rel="stylesheet">
 <script src="<?php echo e(asset('js/imageCrop.js')); ?>" ></script>  
<script type="text/javascript">
function cnf(){
        var cnfdlt=confirm("Confirm Edit?");
        if(cnfdlt==true)
            return true;
        else 
            return false;
    }
    function cnfadd(){
        var cnfdlt=confirm("Confirm Add?");
        if(cnfdlt==true)
            return true;
        else 
            return false;
    }
    function cnfdlt(){
        var cnfdlt=confirm("Confirm Delete?");
        if(cnfdlt==true)
            return true;
        else 
            return false;
    }
</script>

<div class="container">
    <script src="<?php echo e(asset('js/menuBadge.js')); ?>" defer></script> 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3><b>Add / Remove 
            <?php if($q=="ig"): ?>
            Ingredients
            <?php elseif($q=="pd"): ?>
            Products
            <?php else: ?> 
            Menu Items 
            <?php endif; ?>
            </b></h3>
            
            <div class="card" style="margin-bottom: 10px;">
               
                <div class="card-body"> 
                    <form method="POST" action="/menu" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" id="base64" name="base64">
                        <div class="form-group form-row mb-1">
                            <label for="igname" class="col-md-1 col-form-label">
                                Name
                            </label>
                            <div class="col-md-2 mr-4" >
                                <input type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" required>
                                <?php if($errors->has('name')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                
                            </div> 
                            <label for="icon" class="col-md-1 col-form-label">
                                Image
                            </label>
                            <div class="col-md-3">
                                <input type="file" class="form-control-file" name="icon" id="dp" accept="image/*" onchange="crop()">
                            </div>
                            <label for="category" class="col-md-1 col-form-label">
                                Category
                            </label>
                            <div class="col-md-3 mr-4">
                                <select name="category" class="form-control">
                                    <?php $__currentLoopData = $ddcat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option><?php echo e(ucfirst($dc->name)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <a class="btn btn-link" href="/category">Add/Remove Categories</a>
                            </div>
                            <label for="units" class="col-md-1 col-form-label">
                                Units
                            </label>
                            <div class="col-md-3 mr-4">
                                <select name="units" class="form-control">
                                    <?php $__currentLoopData = $ddunit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $du): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option><?php echo e($du->unit_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <a class="btn btn-link" href="/units">Add/Remove Units</a>
                            </div>                      
                            <?php if($q!=="ig"): ?>
                            <label for="sp" class="col-md-1 col-form-label">
                                S-Price
                            </label>
                            <div class="col-md-2 mr-5">
                                <input type="number" min="0" class="form-control" name="sp" required>
                                
                            </div>
                            
                            <?php endif; ?>
                            
                            <div class="col-md-3" >
                                <label class="col-md-1"></label>
                                <button type="submit" onclick="return cnfadd()" class="btn btn-form1" style="color:white;">
                                    Add
                                </button>
                            </div>   
                        </div>                        
                        
                        <input type="hidden" value="<?php echo e($q); ?>" name="q">
                       
                        

                        
                    </form>
                    <div class="row justify-content-end">
                        <a class="btn btn-link" href="/menuRestore/<?php echo e($q); ?>">
                            Show Deleted 
                            <?php if($q=="ig"): ?>
                            Ingredients
                            <?php elseif($q=="pd"): ?>
                            Products
                            <?php else: ?> 
                            Menu Items 
                            <?php endif; ?>
                        </a>
                    </div>
                </div>

            </div>
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
                                    <div class="col-12" style="font-size: 12px;">
                                        <b><?php echo e(ucfirst($ml->mname)); ?></b>
                                       
                                    </div>
                                        
                                </div>
                                 <div class="row">
                                    <div class="col-12" style="font-size: 12px;">

                                       <b>Unit:</b> <?php echo e($ml->unit_name); ?>

                                        <?php if($q!="ig"): ?>
                                        <b>SP:</b> <?php echo e($ml->sp); ?>

                                        <?php endif; ?>
                                        <span style="float:right; overflow: auto;">
                                            <a href="/menu/<?php echo e($ml->mname); ?>/edit" onclick="return cnf()">
                                              <img src="<?php echo e(asset('png/edit.png')); ?>">
                                            </a>

                                            <a href="/menu/delete/<?php echo e($ml->mname); ?>" onclick="return cnfdlt()">
                                              <img src="<?php echo e(asset('png/delt.png')); ?>">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//menu.blade.php ENDPATH**/ ?>