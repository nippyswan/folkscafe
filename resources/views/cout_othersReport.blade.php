@extends('layouts.app')

@section('content')
@if(Session::has('invadded')) <div class="alert alert-success"> {{Session::get('invadded')}} </div> @endif

@if(Session::has('fromto')) <div class="alert alert-warning"> {{Session::get('fromto')}} </div> @endif
 <script src="{{ asset('js/menuBadge.js') }}" defer></script> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
               
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                    </div>
                    @endif

                    <h3>Other Cash OUTs Report: {{$date}}</h3>
                    <h5 style="color:#363636">Balance Start Date: {{$bsdatex}}</h5>
                    <hr>
                    <form method="POST" action="/cout_othersReport">
                        @csrf
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
                             
                           
                            

                        @for($i=0;$i< count($investorx);$i++)
                            <tr>
                                <td colspan="3" align="center" style="font-weight: bold; font-size: 25px;background-color: #c1a878;">{{ucfirst($investorx[$i])}}</td><!--investor names-->
                            </tr>
                            <tr style="font-weight: bold;background-color: #795c34;color:white;">
                                <td align="center">
                                    Date
                                </td>
                                <td>
                                    Cash OUTs
                                </td>
                                <td>
                                    Returned Cash OUTs
                                </td>
                                
                            </tr>
                            @php 
                            $profit=0;
                            @endphp
                            <!--dates loop-->
                            @for($j=0;$j< count($datesx);$j++) 

                                @php
                                //maximum number of amt records
                                $max=0;                            
                                for($k=0;$k< 2;$k++) 
                                    if($fdatex[$i][$j][$k]!=0)
                                        if($fdatex[$i][$j][$k]>$max)
                                            $max=$fdatex[$i][$j][$k];
                                @endphp
                                <!-- to show only existing dates for investors -->
                                @if($max!=0)
                                    <tr>
                                        <td rowspan={{$max}} align="center" style="font-weight: bold;background-color: #795c34;color:white;">
                                            <!--show dates-->
                                            {{$datesx[$j]}}   
                                        </td>
                                        <!--for first row 4 columns-->
                                        @for($k=0;$k< 2;$k++) 
                                        <!--show only non zero amt-->
                                            @if($fdatex[$i][$j][$k]!=0)
                                                <td>
                                                    @php
                                                        $pos=0;//show only first amt value
                                                    @endphp
                                                    <!--for investments-->
                                                    @if($k==0)
                                                        @foreach($invx as $in)
                                                            @if($in->name==$investorx[$i]&&$in->date==$datesx[$j])
                                                                @if($pos==0)
                                                                    {{$in->amt}}
                                                                    @php
                                                                    $profit+=$in->amt;
                                                                    @endphp
                                                                @endif
                                                                @php
                                                                    $pos++;//skip other amt values
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        <!--for return investments-->
                                                    @else
                                                        @foreach($rinvx as $in)
                                                            @if($in->name==$investorx[$i]&&$in->date==$datesx[$j])
                                                                @if($pos==0)
                                                                    {{$in->amt}}
                                                                    @php
                                                                    $profit-=$in->amt;
                                                                    @endphp
                                                                @endif
                                                                @php
                                                                    $pos++;
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    
                                                    @endif


                                                </td>
                                            @else
                                                <td>--</td>
                                            @endif
                                        @endfor
                                        @php
                                            $rows=1;
                                        @endphp
                                        <!--to keep only existing amt-->
                                        @while($rows<$max)
                                            <tr>
                                            @for($k=0;$k< 2;$k++)
                                                @if($fdatex[$i][$j][$k]>$rows)
                                                    <td>
                                                        @php
                                                        $pos=0;
                                                        @endphp
                                                        @if($k==0)
                                                            @foreach($invx as $in)
                                                                @if($in->name==$investorx[$i]&&$in->date==$datesx[$j])
                                                                    @if($pos==$rows)
                                                                        {{$in->amt}}
                                                                        @php
                                                                        $profit+=$in->amt;
                                                                        @endphp
                                                                    @endif
                                                                    @php
                                                                        $pos++;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach($rinvx as $in)
                                                                @if($in->name==$investorx[$i]&&$in->date==$datesx[$j])
                                                                    @if($pos==$rows)
                                                                        {{$in->amt}}
                                                                        @php
                                                                        $profit-=$in->amt;
                                                                        @endphp
                                                                    @endif
                                                                    @php
                                                                        $pos++;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        
                                                        @endif
                                                    </td>
                                                @else
                                                    <td>--</td>
                                                @endif
                                            @endfor
                                            </tr>
                                            @php
                                                $rows++;
                                            @endphp
                                        @endwhile
                                    </tr>
                                @endif    
                                    


                                
                                @endfor
                                <tr>
                                    <td colspan="2" align="right" style="font-weight: bold;">
                                        Total Cash OUTs:
                                    </td>
                                    @if($profit>=0)
                                        <td colspan="1" align="left" style="font-weight: bold; background-color:#3ded97;">
                                            {{$profit}}
                                        </td>
                                    @else
                                        <td colspan="1" align="left" style="font-weight: bold; background-color:#f08080;">
                                            {{$profit}}
                                        </td>
                                    @endif

                                </tr>
                                @endfor
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
