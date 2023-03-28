

window.onload=function menuBadge()
{
   
                
      var source = new EventSource('/menuBadge', {withCredentials: true});
    
       
  var c=0;

       

        source.addEventListener('message', 
            function(e) 
            {
                strx=e.data;
                var ssedata=strx.split(",");
                c++;
                document.getElementById("open").innerHTML =c; 
                if(ssedata[0]==0)
                {
                    document.getElementById("menubadge").style.display="none";
                    
                }
                else
                {
                    curmb=document.getElementById("menubadge").innerHTML;
                    if(curmb!=ssedata[0])
                    {
                        
                        
                        document.getElementById("menubadge").style.display="inline-block";
                        document.getElementById("menubadge").innerHTML = ssedata[0];
                        
                        
                    }
                }
                    
                if(ssedata[1]!=0)
                {
                    curiop=document.getElementById("iop").innerHTML;
                    if(curiop!=ssedata[1])
                    {
                        document.getElementById("iop").style.display="inline-block";
                        document.getElementById("iop").innerHTML = ssedata[1];
                    }
                }
                else
                     document.getElementById("iop").style.display="none";
                if(ssedata[2]!=0)
                {
                    curpop=document.getElementById("pop").innerHTML;
                    if(curpop!=ssedata[2])
                    {
                        document.getElementById("pop").style.display="inline-block";
                        document.getElementById("pop").innerHTML = ssedata[2];
                    }
                }
                else
                    document.getElementById("pop").style.display="none";
              
                
                
             
                }, false
        );
    
        source.onerror=function(err)
            {
               
                
                if (this.readyState == 2)
                {
          
                    document.getElementById('disconnected').style.display="block"; 
                    document.getElementById('disconnected').innerHTML="Connection Lost! Reconnecting...";
                    menuBadge();
                    
                }

                if (this.readyState == 0)
                {
                    document.getElementById('disconnected').style.display="none"; 
                    
           
                }

            };

          
  


                
         }
    


 setInterval(function()
    {
          var xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://192.168.100.21/home');

        xhr.timeout = 12000; // time in milliseconds

        xhr.onload = function () {
        // Request finished. Do processing here.
        
         
        document.getElementById('server').style.display="none"; 
              
        };

        xhr.ontimeout = function (e) {
        // XMLHttpRequest timed out. Do something here.
        document.getElementById('server').style.display="block"; 
        document.getElementById('server').innerHTML="Server Down! Reloading...";
     
               location.reload(true);
        };

        xhr.send(null);
                
                }
            ,15000);    
         