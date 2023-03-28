@extends('layouts.app')

@section('content')
@if(Session::has('changed')) <div class="alert alert-success"> {{Session::get('changed')}} </div> @endif
 <script src="{{ asset('js/menuBadge.js') }}" defer></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                

                <div class="card-body">
                    <h3>My Profile</h3>
                    <hr>
                    <div class="row" style="height: 150px;">
                        <div class="col-12" >
                            @php
                       
                            $u=Auth::user()->imgurl;
                            $ur='storage/users/'.$u;
                            $url=asset($ur);
                            @endphp                          
                            @if(Auth::user()->imgurl!=NULL)
                        
                                <img src="{{$url}}" height="30px" style="max-height: 150px; margin-left: auto; margin-right: auto; display: block;border-radius: 10px;" class="img-fluid">
                            
                        
                            @else
                                <img src="{{ asset('png/profile.png') }}"  height="30px" style="max-height: 150px; margin-left: auto; margin-right: auto; display: block;border-radius: 10px; background-color: grey;" class="img-fluid">
                            @endif                           
                            
                            
                        </div>
                    </div>
                    <div class=" row justify-content-center mt-1 mb-2">
                        <a class="btn btn-secondary btn-sm" href="myProfile/photo">Change Photo</a>
                        
                    </div>
                    <div class="table-responsive table-striped">
                        <table class="table table-sm">
                            
                            <tbody>
                                <tr>
                                    <td align="right">
                                        <b>Username:</b>
                                    </td>
                                    <td align="left">
                                        {{ucfirst(Auth::user()->username)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <b>Email:</b>
                                    </td>
                                    <td align="left">
                                        {{Auth::user()->email}}
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">
                                        <b>Post:</b>
                                    </td>
                                    <td align="left">
                                        {{ucfirst(Auth::user()->type)}}
                                    </td>
                                </tr>

                          
                         
                            </tbody>
                        </table>
                    </div>
                    
                    
                    
                    <div class=" row justify-content-end">
                        <a class="btn btn-link" href="myProfile/email">Change Email</a>
                        <a class="btn btn-link" href="myProfile/pass">Change Password</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
