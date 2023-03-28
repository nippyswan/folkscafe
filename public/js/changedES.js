function changedES(bt,tb,user)
{
    strxold='';
    if(bt!=0)
    {
        
        if(typeof(changedESvar)!=='undefined')
        {
            
            changedESvar.close();
            
        }

        
    }
    if(bt==0)
    {
        
        if(typeof(changedESvar)!=='undefined')
        {
            
            changedESvar.close();
            
        }        
        changedESvar = new EventSource('/changedES/0/0/'+user, {withCredentials: true}); 
    }
    else
        changedESvar = new EventSource('/changedES/'+bt+'/'+tb+'/'+user, {withCredentials: true}); 
    changedESvar.onmessage=function(e) 
        {

            strx=e.data;
            if(strx!=strxold)
            {

                if(strx!='dontupdate')
            
                    document.getElementById("changedES").innerHTML = strx;
                strxold=strx;
            }

            

          
            
         
        };
        
    
    changedESvar.onerror=function(err)
        {
           
            
            if (this.readyState == 2)
            {
      
                document.getElementById('disconnected').style.display="block"; 
                document.getElementById('disconnected').innerHTML="Connection Lost! Reconnecting...";
                changedES(bt,tb,user);
                
            }

            if (this.readyState == 0)
            {
                document.getElementById('disconnected').style.display="none"; 
                
       
            }

        };

}