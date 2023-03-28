function iopES(bt,tb,user)
{
    strxold='';
    if(bt!=0)
    {
        
        if(typeof(iopESvar)!=='undefined')
        {
            
            iopESvar.close();
            
        }

        
    }
    if(bt==0)
    {
        
        if(typeof(iopESvar)!=='undefined')
        {
            
            iopESvar.close();
            
        }        
        iopESvar = new EventSource('/iopES/0/0/'+user, {withCredentials: true}); 
    }
    else
        iopESvar = new EventSource('/iopES/'+bt+'/'+tb+'/'+user, {withCredentials: true}); 
    iopESvar.onmessage=function(e) 
        {

            strx=e.data;
            if(strx!=strxold)
            {

                if(strx!='dontupdate')
            
                    document.getElementById("iopES").innerHTML = strx;
                strxold=strx;
            }

          
            
         
        };
        
    
    iopESvar.onerror=function(err)
        {
           
            
            if (this.readyState == 2)
            {
      
                document.getElementById('disconnected').style.display="block"; 
                document.getElementById('disconnected').innerHTML="Connection Lost! Reconnecting...";
                iopES(bt,tb,user);
                
            }

            if (this.readyState == 0)
            {
                document.getElementById('disconnected').style.display="none"; 
                
       
            }

        };

}