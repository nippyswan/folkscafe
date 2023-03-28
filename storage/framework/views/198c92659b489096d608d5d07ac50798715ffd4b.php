<?php $__env->startSection('content'); ?>
<?php if(Session::has('invadded')): ?> <div class="alert alert-success"> <?php echo e(Session::get('invadded')); ?> </div> <?php endif; ?>
<?php if(Session::has('payoffadded')): ?> <div class="alert alert-success"> <?php echo e(Session::get('payoffadded')); ?> </div> <?php endif; ?>
<?php if(Session::has('fromto')): ?> <div class="alert alert-warning"> <?php echo e(Session::get('fromto')); ?> </div> <?php endif; ?>
 <script src="<?php echo e(asset('js/menuBadge.js')); ?>" defer></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
               
                <div class="card-body">
                    <?php if(session('status')): ?>
                    <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                    </div>
                    <?php endif; ?>

                    <h3>Monthwise Salary Sheet Of: <b><?php echo e($date); ?></b></h3>
                    <h4><i>Current Month Year: <b><?php echo e(date("M Y")); ?></b></i></h4>
                    <h5 style="color:#363636">Balance Start Date: <?php echo e($bsdatex); ?></h5>
                    <hr>
                    <form method="POST" action="/salary_allow_sheetReport">
                        <?php echo csrf_field(); ?>
                        <div class="form-group form-row">
                            
                            <div class="col-md-3">
                                <input type="number" min="2000" max="2120" placeholder="Year" id="year" name="year" class="form-control" required>
                            </div>
                            
                            <div class="col-2" class="form-control">
                                <label></label>
                                <button type="submit" class="btn btn-form1" style="color:white;">
                                    Show
                                </button>
                            </div>
                        </div>

                                            
                    </form>
                    <div class="row justify-content-end">
                        <a class="btn btn-link" href="/users_list">
                            Change Salary Details
                        </a>
                    </div>
                    <hr>
                    
                    <div class="table-responsive">
                        <table class="table">
                             
                         
                            
                            <?php $__currentLoopData = $final_sal_sheet; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                            <tr>
                                <td colspan="13" align="center" style="font-weight: bold; font-size: 25px;background-color: #c1a878;"><?php echo e(ucfirst($key)); ?>

                                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subkey=>$subvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($subkey=="adv"): ?>
                                    
                                        <h6><i>(Advance Salary Given: <?php echo e(number_format($subvalue)); ?>)</i></h6>
                                    
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td><!--investor names-->
                            </tr>
                            <tr style="font-weight: bold;background-color: #795c34;color:white;">
                                <td align="center">Title/Month</td>
                                <td align="center">Jan</td>
                                <td align="center">Feb</td>
                                <td align="center">Mar</td>
                                <td align="center">Apr</td>
                                <td align="center">May</td>
                                <td align="center">Jun</td>
                                <td align="center">Jul</td>
                                <td align="center">Aug</td>
                                <td align="center">Sep</td>
                                <td align="center">Oct</td>
                                <td align="center">Nov</td>
                                <td align="center">Dec</td>

                            </tr>
                            <?php
                            $total=0;
                            $total_paid=0;
                            ?>
                            <tr>
                                <td align="center" style="font-weight: bold;background-color: #795c34;color:white;">
                                           Salary To Pay  
                                </td>
                               
                                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subkey=>$subvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($subkey==="stp"): ?>
                                <?php $__currentLoopData = $subvalue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subsubkey=>$subsubvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($subsubvalue!=="--"): ?>
                                <td><?php echo e(number_format((int)$subsubvalue)); ?></td>
                                <?php
                                $total+=$subsubvalue;
                                ?>
                                <?php else: ?>
                                <td><?php echo e($subsubvalue); ?></td>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               

                            </tr>
                            <tr>
                                <td align="center" style="font-weight: bold;background-color: #795c34;color:white;">
                                           Salary Paid  
                                </td>
                                <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subkey=>$subvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($subkey==="sp"): ?>
                                <?php $__currentLoopData = $subvalue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subsubkey=>$subsubvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($subsubvalue!=="--"): ?>
                                <td><?php echo e(number_format((int)$subsubvalue)); ?></td>
                                <?php
                                $total-=$subsubvalue;
                                $total_paid+=$subsubvalue;
                                ?>
                                <?php else: ?>
                                <td><?php echo e($subsubvalue); ?></td>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </tr>
                            

                                       
                            <tr>
                                <td colspan="3" align="right" style="font-weight: bold;">
                                    Allowance Paid In <?php echo e($date); ?>: 
                                </td>
                                <td colspan="1" align="left" style="font-weight: bold; background-color:#63c5da;">
                                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subkey=>$subvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($subkey=="allow"): ?>
                                    
                                        <?php echo e(number_format($subvalue)); ?>

                                    
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td colspan="3" align="right" style="font-weight: bold;">
                                    Salary Paid In <?php echo e($date); ?>: 
                                </td>
                                <td colspan="2" align="left" style="font-weight: bold; background-color:#fada5e;">
                                    <?php echo e(number_format($total_paid)); ?>

                                </td>
                                
                                <td colspan="3" align="right" style="font-weight: bold;">
                                    Salary Left To Pay In <?php echo e($date); ?>: 
                                </td>
                                <?php if($total<=0): ?>
                                <td colspan="1" align="left" style="font-weight: bold; background-color:#3ded97;">
                                    <?php echo e(number_format($total)); ?>

                                </td>
                                <?php else: ?>
                                <td colspan="1" align="left" style="font-weight: bold; background-color:#f08080;">
                                    <?php echo e(number_format($total)); ?>

                                </td>
                                <?php endif; ?>                              
                                
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//salary_allow_sheetReport.blade.php ENDPATH**/ ?>