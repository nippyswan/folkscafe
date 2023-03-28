<?php $__env->startSection('content'); ?>
<?php if(Session::has('ingret')): ?> <div class="alert alert-success"> <?php echo e(Session::get('ingret')); ?> </div> <?php endif; ?>

<?php if(Session::has('ingadded')): ?> <div class="alert alert-success"> <?php echo e(Session::get('ingadded')); ?> </div> <?php endif; ?>

<?php if(Session::has('fromto')): ?> <div class="alert alert-warning"> <?php echo e(Session::get('fromto')); ?> </div> <?php endif; ?>
 <script src="<?php echo e(asset('js/menuBadge.js')); ?>" defer></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
               
                <div class="card-body">
                    <?php if(session('status')): ?>
                    <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                    </div>
                    <?php endif; ?>

                    <h3>Ingredients Shopping Report: <?php echo e($date); ?></h3>
                    <h5 style="color:#363636">Balance Start Date: <?php echo e($bsdatex); ?></h5>
                    <hr>
                    <form method="POST" action="/ingredientsReport">
                        <?php echo csrf_field(); ?>
                        <div class="form-group form-row">
                            <label for="from" class="col-md-1 col-form-label">From</label>
                            <div class="col-md-3">
                                <input type="date" id="from" name="from" class="form-control" required>
                            </div>
                            <label for="to" class="col-md-1 col-form-label">To</label>
                            <div class="col-md-3">
                                <input type="date" id="to" name="to" class="form-control" required>
                            </div>
                            <div class="col-2" class="form-control">
                                <label></label>
                                <button type="submit" class="btn btn-form1" style="color:white;">
                                    Show
                                </button>
                            </div>
                        </div>

                                            
                    </form>
                    <hr>
                   
                    <div class="table-responsive">
                        <table class="table">
                             
                           
                            

                        <?php for($i=0;$i< count($investorx);$i++): ?>
                            <tr>
                                <td colspan="3" align="center" style="font-weight: bold; font-size: 25px;background-color: #c1a878;"><?php echo e(ucfirst($investorx[$i])); ?></td><!--investor names-->
                            </tr>
                            <tr style="font-weight: bold;background-color: #795c34;color:white;">
                                <td align="center">
                                    Date
                                </td>
                                <td>
                                    Bought
                                </td>
                                <td>
                                    Returned 
                                </td>
                                
                            </tr>
                            <?php 
                            $profit=0;
                            ?>
                            <!--dates loop-->
                            <?php for($j=0;$j< count($datesx);$j++): ?> 

                                <?php
                                //maximum number of amt records
                                $max=0;                            
                                for($k=0;$k< 2;$k++) 
                                    if($fdatex[$i][$j][$k]!=0)
                                        if($fdatex[$i][$j][$k]>$max)
                                            $max=$fdatex[$i][$j][$k];
                                ?>
                                <!-- to show only existing dates for investors -->
                                <?php if($max!=0): ?>
                                    <tr>
                                        <td rowspan=<?php echo e($max); ?> align="center" style="font-weight: bold;background-color: #795c34;color:white;">
                                            <!--show dates-->
                                            <?php echo e($datesx[$j]); ?>   
                                        </td>
                                        <!--for first row 4 columns-->
                                        <?php for($k=0;$k< 2;$k++): ?> 
                                        <!--show only non zero amt-->
                                            <?php if($fdatex[$i][$j][$k]!=0): ?>
                                                <td>
                                                    <?php
                                                        $pos=0;//show only first amt value
                                                    ?>
                                                    <!--for investments-->
                                                    <?php if($k==0): ?>
                                                        <?php $__currentLoopData = $invx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($in->name==$investorx[$i]&&$in->date==$datesx[$j]): ?>
                                                                <?php if($pos==0): ?>
                                                                    <?php echo e($in->price); ?> <span style="color:#ef820d;">(<?php echo e($in->qty); ?> <?php echo e($in->unit_name); ?>)</span>
                                                                    <?php
                                                                    $profit+=$in->price;
                                                                    ?>
                                                                <?php endif; ?>
                                                                <?php
                                                                    $pos++;//skip other amt values
                                                                ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <!--for return investments-->
                                                    <?php else: ?>
                                                        <?php $__currentLoopData = $rinvx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($in->name==$investorx[$i]&&$in->date==$datesx[$j]): ?>
                                                                <?php if($pos==0): ?>
                                                                    <?php echo e($in->price); ?> <span style="color:#ef820d;">(<?php echo e($in->qty); ?> <?php echo e($in->unit_name); ?>)</span>
                                                                    <?php
                                                                    $profit-=$in->price;
                                                                    ?>
                                                                <?php endif; ?>
                                                                <?php
                                                                    $pos++;
                                                                ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                    <?php endif; ?>


                                                </td>
                                            <?php else: ?>
                                                <td>--</td>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <?php
                                            $rows=1;
                                        ?>
                                        <!--to keep only existing amt-->
                                        <?php while($rows<$max): ?>
                                            <tr>
                                            <?php for($k=0;$k< 2;$k++): ?>
                                                <?php if($fdatex[$i][$j][$k]>$rows): ?>
                                                    <td>
                                                        <?php
                                                        $pos=0;
                                                        ?>
                                                        <?php if($k==0): ?>
                                                            <?php $__currentLoopData = $invx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($in->name==$investorx[$i]&&$in->date==$datesx[$j]): ?>
                                                                    <?php if($pos==$rows): ?>
                                                                        <?php echo e($in->price); ?> <span style="color:#ef820d;">(<?php echo e($in->qty); ?> <?php echo e($in->unit_name); ?>)</span>
                                                                        <?php
                                                                        $profit+=$in->price;
                                                                        ?>
                                                                    <?php endif; ?>
                                                                    <?php
                                                                        $pos++;
                                                                    ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <?php $__currentLoopData = $rinvx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($in->name==$investorx[$i]&&$in->date==$datesx[$j]): ?>
                                                                    <?php if($pos==$rows): ?>
                                                                        <?php echo e($in->price); ?> <span style="color:#ef820d;">(<?php echo e($in->qty); ?> <?php echo e($in->unit_name); ?>)</span>
                                                                        <?php
                                                                        $profit-=$in->price;
                                                                        ?>
                                                                    <?php endif; ?>
                                                                    <?php
                                                                        $pos++;
                                                                    ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                        <?php endif; ?>
                                                    </td>
                                                <?php else: ?>
                                                    <td>--</td>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            </tr>
                                            <?php
                                                $rows++;
                                            ?>
                                        <?php endwhile; ?>
                                    </tr>
                                <?php endif; ?>    
                                    


                                
                                <?php endfor; ?>
                                <tr>
                                    <td colspan="2" align="right" style="font-weight: bold;">
                                        Total Spent Amt:
                                    </td>
                                    <?php if($profit>=0): ?>
                                        <td colspan="1" align="left" style="font-weight: bold; background-color:#3ded97;">
                                            <?php echo e($profit); ?>

                                        </td>
                                    <?php else: ?>
                                        <td colspan="1" align="left" style="font-weight: bold; background-color:#f08080;">
                                            <?php echo e($profit); ?>

                                        </td>
                                    <?php endif; ?>

                                </tr>
                                <?php endfor; ?>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//ingredientsReport.blade.php ENDPATH**/ ?>