// for Tab switch
let hidden, vChange;

if ( typeof document.hidden !== 'undefined') 
{
	hidden = 'hidden';
	vChange = 'visibilitychange';
}
else if ( typeof document.webkitHidden !== 'undefined') 
{
	hidden = 'webkitHidden';
	vChange = 'webkitvisibilitychange';	
}
else if ( typeof document.msHidden !== 'undefined') 
{
	hidden = 'msHidden';
	vChange = 'msvisibilitychange';
}
else
{
	// no support
	hidden = null;
	vChange = null;
}


var cheating_time = 0;
if (hidden !== null) 
{
	document.addEventListener(vChange, function()
	{
		document.title = document.visibilityState;
		console.log('visibilitychange', document[hidden]);

		if (document[hidden]) 
		{
			cheating_time+=1;
		}
		else
		{
			alert(cheating_time);
		}
	});
}
