


//

function crop()
{


input=document.getElementById('dp');


if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            //alert("Your browser supports the FileReader API");

	            reader.onload = function (e) {
	            	/*divsh.bind({
	            		url: e.target.result
	            	});*/
					var el = document.getElementById('upload-demo');
    resize = new Croppie(el, {
    viewport: { width: 200, height: 200 },
    boundary: { width: 300, height: 300 },
    showZoomer: true,
    enableExif: true,
    //enableResize: true,
    //enableOrientation: true,
    mouseWheelZoom: 'ctrl'
});
resize.bind({
    url: e.target.result
});


	            	
	            	};
	            
	            reader.readAsDataURL(input.files[0]);
	        }
	        else {
		       alert("Sorry - your browser doesn't support the FileReader API");
		    }
		    //alert('sonn');

document.getElementById('upload-demo').style.display="block";
		

}
function resCrop()
{

	resize.result({size: {width: 600,height: 600}}).then(function(im) {
    // do something with cropped blob
    
    document.getElementById('base64').value=im;
    
});
	document.getElementById('upload-demo').style.display="none";

}



