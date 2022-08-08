window.saveDataAcrossSessions = true;

let startLookTime = Number.POSITIVE_INFINITY;
let lookDirection = null;
const LOOK_DELAY = 1000; // 1sec
const LEFT_CUTOFF = window.innerWidth / 16;
const RIGHT_CUTOFF = window.innerWidth - window.innerWidth / 16;

webgazer.setGazeListener((data, timestamp) => {
	 if (data == null || lookDirection === 'STOP') return;

	if (data.x < LEFT_CUTOFF && lookDirection !== 'LEFT' && lookDirection !== 'RESET') 
	{
		startLookTime = timestamp;
		lookDirection = 'LEFT';
	}
	else if (data.x > RIGHT_CUTOFF && lookDirection !== 'RIGHT' && lookDirection !== 'RESET') 
	{
		startLookTime = timestamp;
		lookDirection = 'RIGHT';
	}
	else if (data.x >= LEFT_CUTOFF && data.x <= RIGHT_CUTOFF) 
	{
		startLookTime = Number.POSITIVE_INFINITY;
		lookDirection = null;
	}


	if (startLookTime + LOOK_DELAY < timestamp) 
	{
		if (lookDirection === 'LEFT') 
			{ 
				alert('LEFT');
			}
			else
			{
				alert('RIGHT');
			}

			startLookTime = Number.POSITIVE_INFINITY;
			lookDirection = 'STOP';


			setTimeout(() => {
				// aha niho haviramwo image 1 hakza izindi
				lookDirection = 'RESET';

			});

	}
}).begin();


// hide cammera

webgazer.showVideoPreview(true).showPredictionPoints(true);

