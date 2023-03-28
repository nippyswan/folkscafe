@extends('layouts.app')

@section('content')
@if(Session::has('datarest')) <div class="alert alert-success"> {{Session::get('datarest')}} </div> @endif
 <script src="{{ asset('js/menuBadge.js') }}" defer></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logwwwwged in!<br>
                    Hey Shital! How Are You? <br>
                    <img src="{{ asset('png/avik5.png') }}" height=100px;>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
