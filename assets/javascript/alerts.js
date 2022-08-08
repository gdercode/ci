
function confirm()
{
	var operations;
	var links;
	this.render = function(operation, link, dialog){
		operations = operation;
		links = link;

		var winW = window.innerWidth;
		var winH = window.innerHeight;

		var dialogoverlay = document.getElementById('dialogoverlay');
		var dialogbox = document.getElementById('dialogbox');

		dialogoverlay.style.display = 'block';
		dialogoverlay.style.height = winH+'px';


		dialogbox.style.left = (winW/2) - (550 * .5) + 'px';
		dialogbox.style.top = '100px';
		dialogbox.style.display = 'block';


		document.getElementById('dialogboxhead').innerHTML = 'Acknowledge This Message';
		document.getElementById('dialogboxbody').innerHTML = dialog; 
		document.getElementById('dialogboxfoot').innerHTML = '<button onclick = "confirmObj.yes()">YES</button> <button onclick = "confirmObj.no()">NO</button>';
	}

	this.no = function(){

		document.getElementById('dialogoverlay').style.display = 'none';
		document.getElementById('dialogbox').style.display = 'none';
		
	}

	this.yes = function(){
		if (operations == 'attendExam') 
		{
			window.location.href = links;
		}
	}

}


var confirmObj = new confirm();
