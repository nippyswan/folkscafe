@extends('layouts.app')

@section('content')



<script type="text/javascript">
    function cnf(){
        var cnf=confirm("Confirm Action?");
        if(cnf==true)
            return true;
        else 
            return false;
    }

</script>
 <script src="{{ asset('js/menuBadge.js') }}" defer></script> 
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

                    <h3>Restore Employees / Users</h3>
                    <hr>
    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <th>
                                <div align="center">S.N.</div>
                            </th>
                            <th>Name</th>
  
                            @foreach($invx as $inv)
                            <tr>
                                <td>
                                    <div align="center">{{$loop->iteration}}</div>
                                </td>
                                    
                                
                                <td >
                                    <span style="float:left; overflow: auto;">{{ucfirst($inv->username)}}</span>
                                    <span style="float:right; overflow: auto;">
                                    <a href="/users_listRestore/{{{$inv->username}}}" onclick="return cnf()">
                                      <img src="png/restore.png">
                                    </a>  
                                    </span>                                 
                                            
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
