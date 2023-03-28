<?php $__env->startSection('content'); ?>
<?php if(Session::has('taken')): ?> <div class="alert alert-success"> <?php echo e(Session::get('taken')); ?> </div> <?php endif; ?>


<div class="container">

 <script src="<?php echo e(asset('js/menuBadge.js')); ?>" defer></script>  

     

<script src="<?php echo e(asset('js/addOrder.js')); ?>" ></script>
    <form method="POST" action="/take" onsubmit="return sendjson()" name="takeform">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="jsondata">
     
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3><b>Take Order</b></h3>
                
                
             

                <div class="card" style="margin-bottom: 10px;">
                   
                    <div class="card-body"> 

                        <div class="form-group form-row">
                            <div class="col-md-2">
                                <label for="table"><b>Table No.</b></label>

                                <select id="table" class="form-control" name="table" >
                                    <?php $__currentLoopData = $invx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          
                                    <option><?php echo e(ucfirst($inv->table_no)); ?></option>
                                                                           
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                                                                                                                    
                                     
                                </select>  
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manager', auth()->user())): ?> 
                                <a class="btn btn-link" href="/table">Add/Remove Tables</a>
                                <?php endif; ?>
                                
                                                        
                            </div> 
                                               
                        </div>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manager', auth()->user())): ?> 
                        <div class=" row justify-content-end">
                            <a class="btn btn-link" href="/menu/mn">Add/Remove Menu Items</a>
                        </div>
                        <?php endif; ?>
                        <div class="table-responsive table-striped">
                            <table class="table table-sm">
                                <thead class="thead-dark">
                                <tr style="background-color: #48494b; font-weight: bold; color:white;">
                                  
                                    <td>
                                        Items
                                    </td>
                                   
                                    <td colspan="2" align="center">
                                        Qty
                                    </td>
                                    
                                    <td>
                                        Price (Rs.)
                                    </td>
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
                                <button type="submit"  class="btn btn-secondary">
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
                        <button class="mr-auto ml-auto mt-2 mb-2 anoj p-0" onclick="return addOrder('<?php echo e($ml->mname); ?>','<?php echo e($ml->sp); ?>','<?php echo e($ml->unit_name); ?>')" style="border-radius: 15%; width:145px;">
                        <div class="row no-gutters" style="border-radius: 15%;" >    
                        <div class="col-12 " >
                            <div class="card m-0 p-0" style="border-radius: 15%;">
                               
                                <div class="card-body pt-2 pb-0" style="border-radius: 15%;background-color: #eedc82; border-style: solid;
            border-color: #c1a878;">
                                    
                                    <div class="row no-gutters mb-1">
                                        <div class="col-6" align="left">
                                            <span class="badge badge-light" style="font-size: 16px; " id="<?php echo e($ml->mname); ?>c">x0</span>
                                        </div>
                                        <div class="col-6" align="right">
                                            <a onclick="return remX('<?php echo e($ml->mname); ?>','<?php echo e($ml->sp); ?>','<?php echo e($ml->unit_name); ?>')" style="cursor: default;">
                                                <img src="/png/remove.png" style="height: 25px; width: 25px;" class="img-fluid"  >
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row no-gutters" style="border-radius: 15%;">

                                        <div class="col-12 p-0" style="background-color: #eee; ">

                                            <?php if($ml->imgurl!=NULL): ?>
                                            <?php if($ml->type=="pd"): ?>
                                            
                                            <img src="/storage/products/<?php echo e($ml->imgurl); ?>" style=" height:110px;max-height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            <?php else: ?>
                                            <img src="/storage/menus/<?php echo e($ml->imgurl); ?>" style="height:110px;max-height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            <?php endif; ?>
                                            
                                           
                                            <?php else: ?>
                                            <img src="/storage/ingredients/ig.jpg" style="height:110px; max-height: 110px; margin-left: auto; margin-right: auto; display: block;" class="img-fluid">
                                            <?php endif; ?>
                                            
                                            
                                        </div>
                                        
                                            
                                      
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="font-size: 12px;" >
                                            <b id="<?php echo e($ml->mname); ?>a"><?php echo e(ucfirst($ml->mname)); ?></b>
                                           
                                        </div>
                                            
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="font-size: 12px;">
                                            Rs. <span id="<?php echo e($ml->mname); ?>b"><?php echo e($ml->sp); ?></span> per <?php echo e($ml->unit_name); ?>

                                           
                                        </div>
                                            
                                    </div> 
                                  
                                                                      
                                    
                                    
                                    
                                    
                                           
                                            
                                     
                                    
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                        </button>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//take.blade.php ENDPATH**/ ?>