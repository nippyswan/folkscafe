<?php $__env->startSection('content'); ?>
<?php if(Session::has('combo')): ?> <div class="alert alert-warning"> <?php echo e(Session::get('combo')); ?> </div> <?php endif; ?>
 <script src="<?php echo e(asset('js/menuBadge.js')); ?>" defer></script> 
<div class="container">
     <script src="<?php echo e(asset('js/menulist.js')); ?>" ></script>
    <form method="POST" action="/ingredients">
        <?php echo csrf_field(); ?>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3><b>Ingredients Shopping Entry</b></h3>
                <div class=" row justify-content-end">
                    <a class="btn btn-link" href="/menu/ig">Add/Remove Ingredients</a>
                </div>
                <div class="card" style="margin-bottom: 10px;">
                   
                    <div class="card-body"> 
                        <div class="table-responsive table-striped">
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                <tr>
                                    <th>
                                        S.N.
                                    </th>
                                    <th>
                                        Items
                                    </th>
                                    <th>
                                        Qty
                                    </th>
                                    <th>
                                        Price (Rs.)
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="tb">

                              
                             
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-end" >
                            <pre id="total"></pre>

                        </div>
                      
                        <div class="form-group form-row justify-content-end">
                            <div class="col-md-3" class="form-control">
                                <button type="submit" onclick="return bsubmit('<?php echo e($menulist); ?>')" class="btn btn-secondary">
                                    Submit
                                </button>
                            </div>

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
                                            
                                            
                                            <img src="/storage/ingredients/<?php echo e($ml->imgurl); ?>" style="height: 110px; max-height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            
                                           
                                            <?php else: ?>
                                            <img src="/storage/ingredients/ig.jpg" style="height: 110px; max-height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="font-size: 12px;"  >
                                            <b id="<?php echo e($ml->mname); ?>a"><?php echo e(ucfirst($ml->mname)); ?></b>
                                           
                                        </div>
                                            
                                    </div>
                                                                      
                                    
                                    <div class="form-row mb-1">
                                        <div class="col-9">
                                            <input type="number" min="1" class="form-control" name="<?php echo e($ml->id); ?>a" id="<?php echo e($ml->id); ?>a" oninput="addMenuItem('<?php echo e($ml->mname); ?>','<?php echo e($ml->id); ?>')" placeholder="Qty" >
                                            
                                        </div>
                                        <label for="qty" class="col-3 col-form-label" id="<?php echo e($ml->mname); ?>b" style="font-size: 12px;" >
                                            <?php echo e($ml->unit_name); ?> 
                                        </label>
                                        
                                    </div>
                                    <div class="form-row">
                                        <label for="price" class="col-3 col-form-label" align="right" style="font-size: 12px;" >
                                            Rs
                                        </label>
                                        <div class="col-9">
                                            <input type="number" min="1" class="form-control" name="<?php echo e($ml->id); ?>b" id="<?php echo e($ml->id); ?>b" oninput="addMenuItem('<?php echo e($ml->mname); ?>','<?php echo e($ml->id); ?>')" placeholder="Amt">
                                        </div>
                                    </div>

                                    
                                    
                                           
                                            
                                     
                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
          
            <?php endfor; ?>
        </div>      
                   
    </form>                
         
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//ingredients.blade.php ENDPATH**/ ?>