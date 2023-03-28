n=1;



function addElem(html){

   
    
    var one=document.getElementById("tb");
    var newElement = document.createElement("tr");
    newElement.setAttribute('id',n);
    newElement.innerHTML = html;
    one.appendChild(newElement);
    n++;
    etp=0;
    for(i=1;i<n;i++)
    {
        var x=document.getElementById(i);
       
            var y=x.getElementsByTagName("td");
            
            etpp=parseInt(y[3].innerHTML);
            etp+=etpp;
                
            
        

    }
    document.getElementById("total").innerHTML='<b>Total Amt: </b>'+etp;
    
}
function delMenuItem(i){

    var elem = document.getElementById(i);

elem.remove();
n--;


}

function bsubmit(menulist)
{
    
   
    minone=0;
    mlist=JSON.parse(menulist);

    for(i=0;i<mlist.length;i++)
    {
        qtchk=document.getElementById(mlist[i].id+'a').value;
        tpchk=document.getElementById(mlist[i].id+'b').value;
       
         if(qtchk=='')
         {
            if(tpchk!='')
            {
                alert("Enter Both Qty & Total Price Values for All Items!");
                return false;
            }
         }
         else
         {
            
            if(tpchk=='')
            {
                alert("Enter Both Qty & Total Price Values for All Items!");
                return false;
            }
            else
                minone=1;
         }
    }
    
    if(minone==0)
    {

        alert('No Input Values!');
        return false;
    }
    else
    {
        cnact=confirm("Confirm Action?");
        if(cnact==true)
            return true;
        else    
            return false;
        
    }
    
}


function addMenuItem(name,id) {

        
        nid=0;//new item if 0
        var qtyc=document.getElementById(id+'a');//to color
        var tpc=document.getElementById(id+'b');
        var qty=document.getElementById(id+'a').value;  
        var tp=document.getElementById(id+'b').value;
         var cname=document.getElementById(name+'a').innerHTML;
          var unit=document.getElementById(name+'b').innerHTML;
        if(qty!="" && tp!="")
        {
            qtyc.setAttribute('style','background-color:#3ded97; color:white;');
            tpc.setAttribute('style','background-color:#3ded97; color:white;');
            etp=0;
            for(i=1;i<n;i++)
            {
                var x=document.getElementById(i);
                if(x!=null)
                {
                    var y=x.getElementsByTagName("td");
                    ename=y[1].innerHTML;
                    etpp=parseInt(y[3].innerHTML);
                    etp+=etpp;

                    if(ename==cname)//if exists, update
                    {
                        nid=i;//exists!
                        y[2].innerHTML=qty+' '+unit;
                        y[3].innerHTML=tp;
                        etp-=etpp;
                        etp+=parseInt(tp);
                        
                    }
                }

            }
            document.getElementById("total").innerHTML='<b>Total Amt: '+' '+'</b>'+etp;
            if(nid==0)//does not exist, so new add
            {
                
                var html = '<td>'+n+'</td><td>'+cname+'</td><td>'+qty+' '+unit+'</td><td>'+tp+'</td>';   
                addElem(html);   
            }     
            
        }
        else 
        {
            if(qty==""&&tp=="")
            {
                qtyc.setAttribute('style','background-color:white; color:black;');
                tpc.setAttribute('style','background-color:white; color:black;');
            }
            else if(qty=="")
            {
                tpc.setAttribute('style','background-color:#f08080; color:white;');
                qtyc.setAttribute('style','background-color:white; color:black;');
            }
            else
            {
                tpc.setAttribute('style','background-color:white; color:black;');
                qtyc.setAttribute('style','background-color:#f08080; color:white;');
            }
            esn=0;//if doesnot exist, 0
            for(i=1;i<n;i++)
            {
                var x=document.getElementById(i);
                if(x!=null)
                {
                    var y=x.getElementsByTagName("td");
                    ename=y[1].innerHTML;

                    if(ename==cname)//exists, so delete 
                    {
                        esns=y[0].innerHTML;
                        esn=parseInt(esns);
                        delMenuItem(i);
                    }
                }

            }
            if(esn!=0)//existed, so re-arrange after delete
            for(i=(esn+1);i<=n;i++)
            {
                var x=document.getElementById(i);
                
                var y=x.getElementsByTagName("td");
                x.setAttribute('id',(i-1));
                y[0].innerHTML=(i-1);
            }
            etp=0;
            for(i=1;i<n;i++)
            {
                var x=document.getElementById(i);
               
                    var y=x.getElementsByTagName("td");
                    
                    etpp=parseInt(y[3].innerHTML);
                    etp+=etpp;
                        
                    
                

            }
            document.getElementById("total").innerHTML='<b>Total Amt: '+' '+'</b>'+etp;
            
            
        }
       
}

