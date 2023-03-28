@extends('layouts.app')

@section('content')
@if(Session::has('invadded')) <div class="alert alert-success"> {{Session::get('invadded')}} </div> @endif
@if(Session::has('payoffadded')) <div class="alert alert-success"> {{Session::get('payoffadded')}} </div> @endif
@if(Session::has('fromto')) <div class="alert alert-warning"> {{Session::get('fromto')}} </div> @endif
 <script src="{{ asset('js/menuBadge.js') }}" defer></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
               
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                    </div>
                    @endif

                    <h3>Monthwise Salary Sheet Of: <b>{{$date}}</b></h3>
                    <h4><i>Current Month Year: <b>{{date("M Y")}}</b></i></h4>
                    <h5 style="color:#363636">Balance Start Date: {{$bsdatex}}</h5>
                    <hr>
                    <form method="POST" action="/salary_allow_sheetReport">
                        @csrf
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
                             
                         
                            
                            @foreach ($final_sal_sheet as $key => $value) 
                            <tr>
                                <td colspan="13" align="center" style="font-weight: bold; font-size: 25px;background-color: #c1a878;">{{ucfirst($key)}}
                                    @foreach($value as $subkey=>$subvalue)
                                    @if($subkey=="adv")
                                    
                                        <h6><i>(Advance Salary Given: {{number_format($subvalue)}})</i></h6>
                                    
                                    @endif
                                    @endforeach
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
                            @php
                            $total=0;
                            $total_paid=0;
                            @endphp
                            <tr>
                                <td align="center" style="font-weight: bold;background-color: #795c34;color:white;">
                                           Salary To Pay  
                                </td>
                               
                                @foreach($value as $subkey=>$subvalue)
                                @if($subkey==="stp")
                                @foreach($subvalue as $subsubkey=>$subsubvalue)
                                @if($subsubvalue!=="--")
                                <td>{{number_format((int)$subsubvalue)}}</td>
                                @php
                                $total+=$subsubvalue;
                                @endphp
                                @else
                                <td>{{$subsubvalue}}</td>
                                @endif
                                @endforeach
                                @endif
                                @endforeach
                               

                            </tr>
                            <tr>
                                <td align="center" style="font-weight: bold;background-color: #795c34;color:white;">
                                           Salary Paid  
                                </td>
                                @foreach($value as $subkey=>$subvalue)
                                @if($subkey==="sp")
                                @foreach($subvalue as $subsubkey=>$subsubvalue)
                                @if($subsubvalue!=="--")
                                <td>{{number_format((int)$subsubvalue)}}</td>
                                @php
                                $total-=$subsubvalue;
                                $total_paid+=$subsubvalue;
                                @endphp
                                @else
                                <td>{{$subsubvalue}}</td>
                                @endif
                                @endforeach
                                @endif
                                @endforeach
                                
                            </tr>
                            

                                       
                            <tr>
                                <td colspan="3" align="right" style="font-weight: bold;">
                                    Allowance Paid In {{$date}}: 
                                </td>
                                <td colspan="1" align="left" style="font-weight: bold; background-color:#63c5da;">
                                    @foreach($value as $subkey=>$subvalue)
                                    @if($subkey=="allow")
                                    
                                        {{number_format($subvalue)}}
                                    
                                    @endif
                                    @endforeach
                                </td>
                                <td colspan="3" align="right" style="font-weight: bold;">
                                    Salary Paid In {{$date}}: 
                                </td>
                                <td colspan="2" align="left" style="font-weight: bold; background-color:#fada5e;">
                                    {{number_format($total_paid)}}
                                </td>
                                
                                <td colspan="3" align="right" style="font-weight: bold;">
                                    Salary Left To Pay In {{$date}}: 
                                </td>
                                @if($total<=0)
                                <td colspan="1" align="left" style="font-weight: bold; background-color:#3ded97;">
                                    {{number_format($total)}}
                                </td>
                                @else
                                <td colspan="1" align="left" style="font-weight: bold; background-color:#f08080;">
                                    {{number_format($total)}}
                                </td>
                                @endif                              
                                
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

