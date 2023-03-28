@extends('layouts.app')

@section('content')
@if(Session::has('idel')) <div class="alert alert-success"> {{Session::get('idel')}} </div> @endif
@if(Session::has('iadd')) <div class="alert alert-success"> {{Session::get('iadd')}} </div> @endif
@if(Session::has('ierror')) <div class="alert alert-warning"> {{Session::get('ierror')}} </div> @endif

 <script src="{{ asset('js/menuBadge.js') }}" defer></script> 

<script type="text/javascript">
    function cnf(){
        var cnf=confirm("Confirm Action?");
        if(cnf==true)
            return true;
        else 
            return false;
    }

</script>
<script src="{{ asset('js/editUsers.js') }}"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
               
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                    </div>
                    @endif

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
  
                            @foreach($invx as $inv)
                            <tr>
                                <td>
                                    <div align="center">{{$loop->iteration}}</div>
                                </td>
                                    
                             
                                <td >
                                    <span style="float:left; overflow: auto;">{{ucfirst($inv->username)}}</span>
                                    <span style="float:right; overflow: auto;">
                                    <a href="#" onclick="addItem({{$inv->id}})">
                                      <img src="png/edit.png">
                                    </a>  
                                    <a href="/users_list/{{{$inv->username}}}" onclick="return cnf()">
                                      <img src="png/delt.png">
                                    </a>  

                                    </span>
                                    <form id="t{{$inv->id}}" method="POST" action="/users_list">
                                        @csrf
                                        <input type="hidden" name="username" value="{{$inv->username}}">
                                        

                                    </form>
                                </td>
                                <td>
                                    {{$inv->type}}
                                </td>
                                <td >
                                    @if(isset($inv->salary_amt))
                                    @if($inv->salary_amt>0)
                                    {{number_format((int)$inv->salary_amt)}} (from: {{$inv->from_date}})
                                    @else
                                    Left From "{{$inv->from_date}}"
                                    @endif
                                    @else
                                    Job Not Started
                                    @endif
                                    
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
