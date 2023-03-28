<?php $__env->startSection('content'); ?>
<?php if(Session::has('notmatch')): ?> <div class="alert alert-warning"> <?php echo e(Session::get('notmatch')); ?> </div> <?php endif; ?>

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
        <div class="col-md-8">
            <div class="card">
                

                <div class="card-body">
                    <h3 id="hh">Change
                        <?php if($q=="email"): ?>
                        Email
                        <?php elseif($q=="pass"): ?>
                        Password
                        <?php else: ?>
                        Profile Picture
                        <?php endif; ?>

                    </h3>
                    <hr>
                    <form method="POST" action="/myProfile" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" value="<?php echo e($q); ?>" name="q">
                        <input type="hidden" id="base64" name="base64">
                        <?php if($q=="email"): ?>
                        <div class="form-group row">
                            <label for="curpassword" class="col-md-4 col-form-label text-md-right">Current Password</label>

                            <div class="col-md-6">
                                <input id="curpassword" type="password" class="form-control <?php $__errorArgs = ['curpassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="curpassword" required autocomplete="new-password">

                                <?php $__errorArgs = ['curpassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">New Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email">

                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <?php elseif($q=="pass"): ?>

                        <div class="form-group row">
                            <label for="curpassword" class="col-md-4 col-form-label text-md-right">Current Password</label>

                            <div class="col-md-6">
                                <input id="curpassword" type="password" class="form-control <?php $__errorArgs = ['curpassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="curpassword" required autocomplete="new-password">

                                <?php $__errorArgs = ['curpassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="new-password">

                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Confirm Password')); ?></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="row mb-2" style="height: 150px;">
                        <div class="col-12" >
                            <?php
                       
                            $u=Auth::user()->imgurl;
                            $ur='storage/users/'.$u;
                            $url=asset($ur);
                            ?>                          
                            <?php if(Auth::user()->imgurl!=NULL): ?>
                        
                                <img src="<?php echo e($url); ?>" height="30px" style="max-height: 150px; margin-left: auto; margin-right: auto; display: block;border-radius: 10px;" class="img-fluid">
                            
                        
                            <?php else: ?>
                                <img src="<?php echo e(asset('png/profile.png')); ?>"  height="30px" style="max-height: 150px; margin-left: auto; margin-right: auto; display: block;border-radius: 10px;background-color: grey;" class="img-fluid">
                            <?php endif; ?>                           
                            
                            
                        </div>
                    </div>
                        <div class="form-group row">
                            <label for="dp" class="col-md-4 col-form-label text-md-right">
                                New Photo
                            </label>
                            <div class="col-md-6">
                                <input type="file" id="dp" class="form-control-file" name="dp" accept="image/*" required onchange="crop()">
                            </div>
                        </div>
                        <?php endif; ?>
                            

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" onclick="return cnf()"class="btn btn-form1" style="color:white;">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp\www\folkscafe\resources\views/myProfileEdit.blade.php ENDPATH**/ ?>