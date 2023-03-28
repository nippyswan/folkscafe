function popES(bt,tb,user)
{
    strxold='';
    if(bt!=0)
    {
        
        if(typeof(popESvar)!=='undefined')
        {
            
            popESvar.close();
            
        }

        
    }
    if(bt==0)
    {
        
        if(typeof(popESvar)!=='undefined')
        {
            
            popESvar.close();
            
        }        
        popESvar = new EventSource('/popES/0/0/'+user, {withCredentials: true}); 
    }
    else
        popESvar = new EventSource('/popES/'+bt+'/'+tb+'/'+user, {withCredentials: true}); 
    popESvar.onmessage=function(e) 
        {

            strx=e.data;
            if(strx!=strxold)
            {

                if(strx!='dontupdate')
            
                    document.getElementById("popES").innerHTML = strx;
                strxold=strx;
            }

          

          
            
         
        };
        
    
    popESvar.onerror=function(err)
        {
           
            
            if (this.readyState == 2)
            {
      
                document.getElementById('disconnected').style.display="block"; 
                document.getElementById('disconnected').innerHTML="Connection Lost! Reconnecting...";
                popES(bt,tb,user);
                
            }

            if (this.readyState == 0)
            {
                document.getElementById('disconnected').style.display="none"; 
                
       
            }

        };

}