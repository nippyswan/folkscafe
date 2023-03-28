@extends('layouts.app')

@section('content')
@if(Session::has('notmatch')) <div class="alert alert-warning"> {{Session::get('notmatch')}} </div> @endif

 <script src="{{ asset('js/menuBadge.js') }}" defer></script> 

 <script src="{{ asset('js/exif.js') }}" ></script> 
 <script src="{{ asset('js/croppie.js') }}" ></script> 
 
 <link href="{{ asset('css/croppie.css') }}" rel="stylesheet">
 <script src="{{ asset('js/imageCrop.js') }}" ></script> 
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
                        @if($q=="email")
                        Email
                        @elseif($q=="pass")
                        Password
                        @else
                        Profile Picture
                        @endif

                    </h3>
                    <hr>
                    <form method="POST" action="/myProfile" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" value="{{$q}}" name="q">
                        <input type="hidden" id="base64" name="base64">
                        @if($q=="email")
                        <div class="form-group row">
                            <label for="curpassword" class="col-md-4 col-form-label text-md-right">Current Password</label>

                            <div class="col-md-6">
                                <input id="curpassword" type="password" class="form-control @error('curpassword') is-invalid @enderror" name="curpassword" required autocomplete="new-password">

                                @error('curpassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">New Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        @elseif($q=="pass")

                        <div class="form-group row">
                            <label for="curpassword" class="col-md-4 col-form-label text-md-right">Current Password</label>

                            <div class="col-md-6">
                                <input id="curpassword" type="password" class="form-control @error('curpassword') is-invalid @enderror" name="curpassword" required autocomplete="new-password">

                                @error('curpassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        @else
                        <div class="row mb-2" style="height: 150px;">
                        <div class="col-12" >
                            @php
                       
                            $u=Auth::user()->imgurl;
                            $ur='storage/users/'.$u;
                            $url=asset($ur);
                            @endphp                          
                            @if(Auth::user()->imgurl!=NULL)
                        
                                <img src="{{$url}}" height="30px" style="max-height: 150px; margin-left: auto; margin-right: auto; display: block;border-radius: 10px;" class="img-fluid">
                            
                        
                            @else
                                <img src="{{ asset('png/profile.png') }}"  height="30px" style="max-height: 150px; margin-left: auto; margin-right: auto; display: block;border-radius: 10px;background-color: grey;" class="img-fluid">
                            @endif                           
                            
                            
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
                        @endif
                            

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

@endsection
