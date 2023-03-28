

var item=[]

var rem,minus=0;


function remX(nml,sp,un)
{

    var lower=nml;
    var nm=lower.charAt(0).toUpperCase() + lower.substring(1);
	for(i=0;i<item.length;i++)
	{
		
		if(item[i].n==nm)
		{
			
				item[i].q=item[i].q-1;

				rem=1;
				if(minus==1)
				{
					//alert("Hello World!");
					minus=0;
					addOrder(nml,sp,un);			
				}
		
			
			
			

		}
	}
	
}

function addTableRow(html,i,ex){   
    
   	if(ex==0)
   	{

	    var one=document.getElementById("tb");
	    var newElement = document.createElement("tr");
	    newElement.setAttribute('id','row'+i);
	    newElement.innerHTML = html;
	    one.appendChild(newElement);
	}
	else
	{
		document.getElementById('row'+i).innerHTML=html;
	}
	
    etp=0;
    for(j=0;j<item.length;j++)
    {

        
        if(item[j].q>0)
        {
        	
        	etp+=item[j].price;
        	
        }               
    }
  
    	document.getElementById("total").innerHTML='<b>Total Amt: </b>'+etp;
    
}

function delTableRow(i){

    var elem = document.getElementById('row'+i);

elem.remove();
etp=0;
    for(j=0;j<item.length;j++)
    {

        
        if(item[j].q>0)
        {
        	
        	etp+=item[j].price;
        	
        }               
    }
  
    	document.getElementById("total").innerHTML='<b>Total Amt: </b>'+etp;



}

function addOrder(nml,sp,un)
    {
    	
    	
    	var lower=nml;
    	var nm=lower.charAt(0).toUpperCase() + lower.substring(1);
    	if(item.length==0)//for first one
    	{

    		item[0]={n:nm,s:sp,q:1};
    		price=item[0].q*item[0].s;
    		item[0].price=price;
    		var html='<td>'+item[0].n+'</td><td align="right">'+item[0].q+' '+un+'</td><td align="left"><a id="'+nml+'minus" ><img src="/png/remove.png"  height="20"></a></td><td>'+item[0].price+'</td>';
    		addTableRow(html,0,0);
    		document.getElementById(nml+'minus').style.cursor="pointer";
    		document.getElementById(nml+'minus').addEventListener("click", function() {
			  	//alert("Hello World!");
			  	minus=1;
			  	remX(nml,sp,un);
			});
    	
    		document.getElementById(nml+'c').innerHTML='x'+item[0].q;
    		return false;
    	}
    	else
    	for(i=0;i<item.length;i++)//if exists
    	{
    		
    		if(item[i].n==nm)
	    	{
	    		if(item[i].q==0&&rem==1)
    			{
    				delTableRow(i);
    				item[i].q--;
    				rem=0;
    				document.getElementById(nml+'c').innerHTML='x0';
    				return false;
    				
    			}
    			else if(item[i].q<0&&rem==1)
    			{
    				rem=0;
    				return false;
    			}
    			else if(item[i].q>0&&rem==1)
    			{
    				price=item[i].q*item[i].s;
    				item[i].price=price;
    				var html='<td>'+item[i].n+'</td><td align="right">'+item[i].q+' '+un+'s'+'</td><td align="left"><a id="'+nml+'minus" ><img src="/png/remove.png"  height="20"></a></td><td>'+item[i].price+'</td>';
		    		addTableRow(html,i,1);
		    		document.getElementById(nml+'minus').style.cursor="pointer";
    				document.getElementById(nml+'minus').addEventListener("click", function() {
			  		//alert("Hello World!");
			  		minus=1;
			  		remX(nml,sp,un);
					});
		    		rem=0;
		    		document.getElementById(nml+'c').innerHTML='x'+item[i].q;
		    		return false;
    			}
    			else if(item[i].q<0&&rem==0)
    			{
    				
    				item[i].q=1;
    				price=item[i].q*item[i].s;
    				item[i].price=price;
    				var html='<td>'+item[i].n+'</td><td align="right">'+item[i].q+' '+un+'</td><td align="left"><a id="'+nml+'minus" ><img src="/png/remove.png"  height="20"></a></td><td>'+item[i].price+'</td>';
		    		addTableRow(html,i,0);
		    		document.getElementById(nml+'minus').style.cursor="pointer";
    				document.getElementById(nml+'minus').addEventListener("click", function() {
			  		//alert("Hello World!");
				  	minus=1;
				  	remX(nml,sp,un);
					});
		    		document.getElementById(nml+'c').innerHTML='x'+item[i].q;
		    		return false;
    			}
    			else
    			{
    				item[i].q++;
    				price=item[i].q*item[i].s;
    				item[i].price=price;
	    			var html='<td>'+item[i].n+'</td><td align="right">'+item[i].q+' '+un+'s'+'</td><td align="left"><a id="'+nml+'minus" ><img src="/png/remove.png"  height="20"></a></td><td>'+item[i].price+'</td>';
	    			addTableRow(html,i,1);
	    			document.getElementById(nml+'minus').style.cursor="pointer";
    				document.getElementById(nml+'minus').addEventListener("click", function() {
				  	//alert("Hello World!");
				  	minus=1;
				  	remX(nml,sp,un);
					});
	    			document.getElementById(nml+'c').innerHTML='x'+item[i].q;
	    			return false;
    			}

	    		
	    		
    		}
    		
    	}
    	//for second new and so on
    	
    	
    	item[i]={n:nm,s:sp,q:1};
    	price=item[i].q*item[i].s;
    	item[i].price=price;
    	var html='<td>'+item[i].n+'</td><td align="right">'+item[i].q+' '+un+'</td><td align="left"><a id="'+nml+'minus" ><img src="/png/remove.png"  height="20"></a></td><td>'+item[i].price+'</td>';
    	addTableRow(html,i,0);
        document.getElementById(nml+'minus').style.cursor="pointer";
        document.getElementById(nml+'minus').addEventListener("click", function() {
        //alert("Hello World!");
            minus=1;
            remX(nml,sp,un);
        });
    	document.getElementById(nml+'c').innerHTML='x'+item[i].q;
        //document.getElementById('tb').innerHTML='<tr><td>'+item[0].sn+'</td><td>'+item[0].n+'</td><td>'+item[0].q+'</td><td>'+(item[0].q*item[0].s)+'</td></tr>';
        return false;
    }

    function sendjson()
    {
    	count=0;
    	if(item.length==0)
    	{
    		alert('No Items!');
    		return false;
    	}
    	else
    	{
    		for(i=0;i<item.length;i++)
    		{
    			if(item[i].q<1)
    			{
    				count++;
    			}
    		}
    		if(count==item.length)
    		{
    			alert('No Items!');
    			return false;
    		}
    	}
    	myJSON = JSON.stringify(item);
    	//alert(myJSON);
    	document.forms["takeform"]["jsondata"].value=myJSON;
    	//alert(document.forms["takeform"]["jsondata"].value);
    	var cn=confirm("Confirm Action?");
        if(cn==true)
            return true;
        else 
            return false;
    
    	

    }