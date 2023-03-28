<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="theme-color" content="#8f623b">
 
    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
      href="/splash/icon_828x1792.png"
    />
 
    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
      href="/splash/icon_1242x2688.png"
    />
  
    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
      href="/splash/icon_1125x2436.png"
    />
    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
      href="/splash/icon_1242x2208.png"
    />
   
    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
      href="/splash/icon_750x1334.png"
    />
    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
      href="/splash/icon_2048x2732.png"
    />
 
    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
      href="/splash/icon_1668x2224.png"
    />
    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
      href="/splash/icon_640x1136.png"
    />
    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
      href="/splash/icon_1668x2388.png"
    />

    <link
      rel="apple-touch-startup-image"
      media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
      href="/splash/icon_1536x2048.png"
    />
    <!--title icon-->
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon.ico">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Folks Cafe & Food Court') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
     

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/nunito.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/folksCafe.css') }}" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <style>
.anoj {
 
 
  cursor: pointer;
  outline: none;
  
  box-shadow: 0 1px #999;
  border: none;

  
  
}


.anoj:focus {outline:0;}
.anoj:active {
    
  -webkit-transform:translateY(4px);
  
  
}
</style>
<script type="text/javascript">
    
   
   /* if ('serviceWorker' in navigator && 'PushManager' in window) 
    {
        
        
        alert('yes');
        

    }
    else
    {
        alert('no');
    }*/
</script>
 


</head>
<body ontouchstart="">
   <div id="upload-demo" class="upload-demo" style="position:fixed;
    display: none;
    padding:0;
    margin:0;

    top:0;
    left:0;
    z-index:2000;

    width: 100%;
    height: 100%;
    background:rgba(0,0,0,0.95);">
    <div class="row justify-content-center">    
        <button class="btn btn-success upload-result m-4"  id="upload-result" style="z-index:2001;" onclick="resCrop()">Done</button>  
    </div>
    </div> 

    
    <div id="app">   
        
        <nav class="navbar navbar-expand-sm navbar-light sticky-top shadow-sm" style="background-color: #8f623b;">
            
            <a class="navbar-brand p-0 m-0" href="{{ url('/') }}">
                <img src="{{ asset('png/logo.png') }}"  height="30">
                <span style="font-size: 12px; color:white;" id="open">The Folks Cafe & Food Court</span>
            </a>
            @auth
            <ul class="navbar-nav ml-auto">                
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle p-0 m-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @php
                       
                            $u=Auth::user()->imgurl;
                            $ur='storage/users/'.$u;
                            $url=asset($ur);
                        @endphp
                        @if(Auth::user()->imgurl!=NULL)
                        
                            <img src="{{$url}}" height="30px" style="border-radius:50%;">
                        
                        
                        @else
                            <img src="{{ asset('png/profile.png') }}"  height="30px" style="border-radius: 50%;">
                        @endif
                                        <span style="color:white;">{{ ucfirst(Auth::user()->username) }}</span> 
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/myProfile" style="color:red;">
                                    My Profile
                        </a>
                        @can('manager', auth()->user())


                        
                        
                        <a class="dropdown-item" href="/backup" style="color:red;">
                            Download Backup                           
                        </a>
                       
                      


                       
                        <a class="dropdown-item" href="/users_list" style="color:red;">
                                    Employees / Users                               
                        </a>
                        @endcan
                        <div class="dropdown-divider"></div>
                                        
                        <a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="color:red;">
                                            {{ __('Logout') }}
   
                        </a>
                                        

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                        </form>
                    </div>
                </li>    
            </ul>
                
            @endauth
            
            
        </nav>
      
            <div class="alert alert-danger" role="alert" style="display: none;" id="disconnected"></div>
            <div class="alert alert-danger" role="alert" style="display: none;" id="server"></div>
            
            

        <div class="navbtn"> 
            @auth
            <div class="row">
                <div class="col-md-12" style="position: relative;z-index: 100;">
                    <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="float: right;">
                        <img src="{{asset('png/menu.png')}}" style=" z-index:100; height:70px;">
                       
                    </a>
                    <a style="float: right;">
                    <span class="badge badge-danger" style="font-size: 20px; color: white;z-index: 200;position: absolute; " id="menubadge"></span>
                    </a>
                </div>
            </div>
           
            <div class="collapse" id="collapseExample">
                <div class="accordion" id="myaccordion">
                                      
                    <div class="container-fluid">
                    <div class="row no-gutters justify-content-center">
                        @can('manager', auth()->user()) 
                        <div class="col-md-3 col-5 mb-2 ml-1 mr-1">
                            <a class="nav-link collapsed pt-4 pb-4" role="button" data-toggle="collapse" href="#h1" aria-expanded="false" aria-controls="h1" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/cashin.png') }}"  height="60px" ><span style="color:red;">Done</span>

                            </a>
                                        
                            <div id="h1" class="collapse" data-parent="#myaccordion" style="opacity:0.9;">
                                
                                
                                <a class="nav-link pt-2 pb-2" href="/investments" style="text-align:center; color:red; background-color: #795c34; font-size: 13px;">Investments</a>
                                
                                <a class="nav-link pt-2 pb-2" href="/cin_others" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Others</a>                              
                                                           
                            </div>
                          
                            
                        </div>
                    
                        <div class="col-md-3 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link collapsed pt-4 pb-4" role="button" data-toggle="collapse" href="#h2" aria-expanded="false" aria-controls="h2" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/cashout.png') }}"  height="60px" ><span style="color:red;">Done</span>
                            </a>
                                        
                            <div id="h2" class="collapse" data-parent="#myaccordion" style="opacity:0.9;">
                                <a class="nav-link pt-2 pb-2" href="/ingredients" style="text-align:center; color:red; background-color: #795c34;font-size: 13px;">Ingredients</a>
                                <a class="nav-link pt-2 pb-2" href="/products" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Products</a> 
                                <a class="nav-link pt-2 pb-2" href="/salary_allow" style="text-align:center; color:red; background-color: #795c34;font-size: 13px;">Salary & Allowance</a>
                                <a class="nav-link pt-2 pb-2" href="/payoff" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Pay-off</a> 
                                <a class="nav-link pt-2 pb-2" href="/cout_others" style="text-align:center; color:red; background-color: #795c34;font-size: 13px;">Others</a>
                          
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link collapsed pt-4 pb-4" role="button" data-toggle="collapse" href="#h3" aria-expanded="false" aria-controls="h3" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/returns.png') }}"  height="60px" ><span style="color:red;">Done</span>
                            </a>
                                        
                            <div id="h3" class="collapse" data-parent="#myaccordion" style="opacity:0.9;">
                                
                                <a class="nav-link pt-2 pb-2" href="/r_investments" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Investments</a>
                                <a class="nav-link pt-2 pb-2" href="/r_ingredients" style="text-align:center; color:red; background-color: #795c34;font-size: 13px;">Ingredients</a>
                                <a class="nav-link pt-2 pb-2" href="/r_products" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Products</a>
                                <a class="nav-link pt-2 pb-2" href="/r_salary_allow" style="text-align:center; color:red; background-color: #795c34;font-size: 13px;">Salary & Allowance</a>
                                <a class="nav-link pt-2 pb-2" href="/r_payoff" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Pay-off</a> 
                                <a class="nav-link pt-2 pb-2" href="/r_cin_others" style="text-align:center; color:red; background-color: #795c34;font-size: 13px;">Other Cash INs</a>
                                <a class="nav-link pt-2 pb-2" href="/r_cout_others" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Other Cash OUTs</a> 
                          
                            </div>
                        </div>
                         
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link pt-4 pb-4" href="/home" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/inventory.png') }}"  height="60px" >
                            </a>
                                        
                            
                        </div>
                    
                  
                        <div class="col-md-3 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link collapsed pt-4 pb-4" role="button" data-toggle="collapse" href="#h5" aria-expanded="false" aria-controls="h5" style="text-align:center;color:white; background-color: #8f623b;box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/reports.png') }}"  height="60px" >
                            </a>
                                        
                            <div id="h5" class="collapse" data-parent="#myaccordion" style="opacity:0.9;">
                                <a class="nav-link pt-2 pb-2" href="/home" style="text-align:center; color:white; background-color: #795c34;font-size: 13px;">Daybook</a>
                                <a class="nav-link pt-2 pb-2" href="/home" style="text-align:center; color:white; background-color: #9a7b4f;font-size: 13px;">Sales</a>
                                <a class="nav-link pt-2 pb-2" href="/invpayReport" style="text-align:center; color:red; background-color: #795c34;font-size: 13px;">Investments & Pay-off</a>
                                <a class="nav-link pt-2 pb-2" href="/cin_othersReport" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Other Cash INs</a>
                                <a class="nav-link pt-2 pb-2" href="/ingredientsReport" style="text-align:center; color:red; background-color: #795c34;font-size: 13px;">Ingredients</a>
                                <a class="nav-link pt-2 pb-2" href="/productsReport" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Products</a>
                                <a class="nav-link pt-2 pb-2" href="/salary_allowReport" style="text-align:center; color:red; background-color: #795c34;font-size: 13px;">Salary & Allowance</a>
                                <a class="nav-link pt-2 pb-2" href="/cout_othersReport" style="text-align:center; color:red; background-color: #9a7b4f;font-size: 13px;">Other Cash OUTs</a>
                                <a class="nav-link pt-2 pb-2" href="/home" style="text-align:center; color:white; background-color: #795c34;font-size: 13px;">Profit</a>
                          
                            </div>
                        </div>
                     
                        <div class="col-md-3 col-5 mb-2 ml-1 mr-1">
                            <a class="nav-link collapsed pt-4 pb-4" role="button" data-toggle="collapse" href="#h6" aria-expanded="false" aria-controls="h6" style="text-align:center;color:white; background-color: #8f623b;box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/analysis.png') }}"  height="60px" >
                            </a>
                                        
                            <div id="h6" class="collapse" data-parent="#myaccordion" style="opacity:0.9;">
                                <a class="nav-link pt-2 pb-2" href="/home" style="text-align:center; color:white; background-color: #795c34;font-size: 13px;">Top Selling Item</a>
                                <a class="nav-link pt-2 pb-2" href="/home" style="text-align:center; color:white; background-color: #9a7b4f;font-size: 13px;">Most Profitable Item</a>
                                <a class="nav-link pt-2 pb-2" href="/home" style="text-align:center; color:white; background-color: #795c34;font-size: 13px;">Profit & Loss</a>
                          
                            </div>
                        </div>
                             
                        <div class="col-md-3 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link collapsed pt-4 pb-4" role="button" data-toggle="collapse" href="#h7" aria-expanded="false" aria-controls="h7" style="text-align:center;color:white; background-color: #8f623b;box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/wastage.png') }}"  height="60px" >
                            </a>
                                        
                            <div id="h7" class="collapse" data-parent="#myaccordion" style="opacity:0.9;">
                                <a class="nav-link pt-2 pb-2" href="/home" style="text-align:center; color:white; background-color: #795c34;font-size: 13px;">Entry</a>
                                <a class="nav-link pt-2 pb-2" href="/home" style="text-align:center; color:white; background-color: #9a7b4f;font-size: 13px;">Report</a>
                          
                            </div>
                        </div>
                        @endcan
                          
                        @canany(['manager','waiter'], auth()->user()) 
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link pt-4 pb-4" href="/take" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/takeorder.png') }}"  height="60px" ><span style="color:red;">Done</span>
                            </a>
                                        
                            
                        </div>
                        @endcan
                   
                        @canany(['manager','waiter','chef'], auth()->user())
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link pt-4 pb-4" href="/iop" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/iop.png') }}"  height="60px" >
                                 <span class="badge badge-danger" style="font-size: 20px; color: white;" id="iop"></span><span style="color:red;">Done</span>
                            </a>
                                        
                            
                        </div>
                        
                        @endcan
                         
                        @canany(['manager','waiter'], auth()->user())
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" style="" >

                            <a class="nav-link pt-4 pb-4" href="/pop" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >

                                <img src="{{ asset('png/pop.png') }}"  height="60px" >
                                 <span class="badge badge-danger" style="font-size: 20px; color: white;" id="pop"></span><span style="color:red;">Done</span>
                            </a>
                                        
                            
                        </div>
                         
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link pt-4 pb-4" href="/changed" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/co.png') }}"  height="60px" >
                            </a>
                                        
                            
                        </div>
                        @endcan
                        @canany(['manager','waiter','chef'], auth()->user()) 
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link pt-4 pb-4" href="/confirmed" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/confirmed.png') }}"  height="60px" >
                            </a>
                                        
                            
                        </div>
                         
                      
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link pt-4 pb-4" href="/cancel" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/cancel.png') }}"  height="60px" >
                            </a>
                                        
                            
                        </div>
                      
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link pt-4 pb-4" href="/prepared" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/prepared.png') }}"  height="60px" >
                            </a>
                                        
                            
                        </div>
                        @endcan
                         
                        @canany(['manager','waiter'], auth()->user())
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link pt-4 pb-4" href="/served" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/served.png') }}"  height="60px" >
                            </a>
                                        
                            
                        </div>
                        @endcan
                        
                        @canany(['manager','waiter','chef'], auth()->user())
                        <div class="col-md-2 col-5 mb-2 ml-1 mr-1" >
                            <a class="nav-link pt-4 pb-4" href="/returned" style="text-align:center;color:white; background-color: #8f623b; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19); opacity:0.9;" >
                                <img src="{{ asset('png/returned.png') }}"  height="60px" >
                            </a>
                                        
                            
                        </div>
                        @endcan
                                             

                        
                        


                    </div>
                    </div>
                </div>
            </div>  
            @endauth       
            
        </div>
         

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
