<?php $__env->startSection('content'); ?>
<?php if(Session::has('idel')): ?> <div class="alert alert-success"> <?php echo e(Session::get('idel')); ?> </div> <?php endif; ?>
<?php if(Session::has('iadd')): ?> <div class="alert alert-success"> <?php echo e(Session::get('iadd')); ?> </div> <?php endif; ?>
<?php if(Session::has('ierror')): ?> <div class="alert alert-warning"> <?php echo e(Session::get('ierror')); ?> </div> <?php endif; ?>

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
<script src="<?php echo e(asset('js/editUsers.js')); ?>"></script>
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

                    <h3>Employees / Users</h3>

                    <hr>
                    <a type="button" class="btn btn-secondary" href="/register">
                        Click To Register a New Employee / User
                    </a>
                    <div class="row justify-content-end">
                        <a class="btn btn-link" href="/salary_allow_sheetReport">
                            Show Monthwise Salary Sheet 
                        </a>
                    </div>
                    <hr>
                    <div class="row justify-content-end">
                        <a class="btn btn-link" href="/users_listRestore">
                            Show Deleted Employees / Users
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <th>
                                <div align="center">S.N.</div>
                            </th>
                            <th>Name</th>
                            <th>Post</th>
                            <th>Current Salary</th>
  
                            <?php $__currentLoopData = $invx; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div align="center"><?php echo e($loop->iteration); ?></div>
                                </td>
                                    
                             
                                <td >
                                    <span style="float:left; overflow: auto;"><?php echo e(ucfirst($inv->username)); ?></span>
                                    <span style="float:right; overflow: auto;">
                                    <a href="#" onclick="addItem(<?php echo e($inv->id); ?>)">
                                      <img src="png/edit.png">
                                    </a>  
                                    <a href="/users_list/<?php echo e($inv->username); ?>" onclick="return cnf()">
                                      <img src="png/delt.png">
                                    </a>  

                                    </span>
                                    <form id="t<?php echo e($inv->id); ?>" method="POST" action="/users_list">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="username" value="<?php echo e($inv->username); ?>">
                                        

                                    </form>
                                </td>
                                <td>
                                    <?php echo e($inv->type); ?>

                                </td>
                                <td >
                                    <?php if(isset($inv->salary_amt)): ?>
                                    <?php if($inv->salary_amt>0): ?>
                                    <?php echo e(number_format((int)$inv->salary_amt)); ?> (from: <?php echo e($inv->from_date); ?>)
                                    <?php else: ?>
                                    Left From "<?php echo e($inv->from_date); ?>"
                                    <?php endif; ?>
                                    <?php else: ?>
                                    Job Not Started
                                    <?php endif; ?>
                                    
                                </td>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views//users_list.blade.php ENDPATH**/ ?>