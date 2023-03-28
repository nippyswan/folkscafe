
var c=0;
function addElement(html,id){


	var one=document.getElementById("t"+id);

	var newElement = document.createElement("div");
    newElement.setAttribute('id',id);
    newElement.innerHTML = html;
    one.appendChild(newElement);
	c=1;
}
function delItem(did){

    var elem = document.getElementById(did);

elem.remove();
c=0;

}



function addItem(id) {

    if(c==0)
        {	
        var html = '<br><h6><i>Note: Leave Salary & From Date Field Empty To Change Only Post</i></h6><input type="hidden" name="id" value="'+id+'"><div class="form-group form-row"><div class="col-md-8">Post <select id="type" class="form-control" name="type"><option>Manager</option><option>Waiter</option><option>Chef</option></select></div></div><div class="form-group form-row"><div class="col-md-8">Salary <input type="number" min="0" name="salary_amt"></div></div><div class="form-group form-row"><div class="col-md-8">From Date <input type="month" name="from_date"></div></div><div class="form-group form-row"><div class="col-md-4"><input type="submit" onclick="return cnf()"></div></div>';
        addElement(html,id);
    }
    else
        delItem(id);
}
//{{ config('app.name', 'Laravel') }}
