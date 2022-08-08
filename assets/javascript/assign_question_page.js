$('#validateEyeTrainingOverlay').css('display','block');
var permit = $('#permit').val(); 
var eyeTraining = false; 


var validButton1 = 10;
var validButton2 = 10;
var validButton3 = 10;
var validButton4 = 10;
var validButton5 = 10;
var validButton6 = 10;
var validButton7 = 10;
var validButton8 = 10;
var validButton9 = 10;

var visibleBtns = 0;
var visibleOverlay = 9;


		// functions area
// ---------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------

function overlayValidation()
{
	visibleOverlay = visibleOverlay -1;
	if (visibleOverlay == 0 ) 
	{
		$('#validateEyeTrainingOverlay').css('display','none');
		eyeTraining = true;
	}
}

function buttonValidation(btnID)
{
	var btn = $('#validateEyeBtn'+btnID);

	if (btnID == 1) 
	{
		validButton1 = validButton1 - 1;
		btn.text(validButton1);

		if (validButton1 == 0 ) 
		{
			$('#validateEyeBtn1').css('display','none');
			overlayValidation()
		}
	}

	if (btnID == 2) 
	{
		validButton2 = validButton2 - 1;
		btn.text(validButton2);

		if (validButton2 == 0 ) 
		{
			$('#validateEyeBtn2').css('display','none');
			overlayValidation()
		}
	}

	if (btnID == 3) 
	{
		validButton3 = validButton3 - 1;
		btn.text(validButton3);

		if (validButton3 == 0 ) 
		{
			$('#validateEyeBtn3').css('display','none');
			overlayValidation()
		}
	}

	if (btnID == 4) 
	{
		validButton4 = validButton4 - 1;
		btn.text(validButton4);

		if (validButton4 == 0 ) 
		{
			$('#validateEyeBtn4').css('display','none');
			overlayValidation()
		}
	}

	if (btnID == 5) 
	{
		validButton5 = validButton5 - 1;
		btn.text(validButton5);

		if (validButton5 == 0 ) 
		{
			$('#validateEyeBtn5').css('display','none');
			overlayValidation()
		}
	}

	if (btnID == 6) 
	{
		validButton6 = validButton6 - 1;
		btn.text(validButton6);

		if (validButton6 == 0 ) 
		{
			$('#validateEyeBtn6').css('display','none');
			overlayValidation()
		}
	}

	if (btnID == 7) 
	{
		validButton7 = validButton7 - 1;
		btn.text(validButton7);

		if (validButton7 == 0 ) 
		{
			$('#validateEyeBtn7').css('display','none');
			overlayValidation()
		}
	}

	if (btnID == 8) 
	{
		validButton8 = validButton8 - 1;
		btn.text(validButton8);

		if (validButton8 == 0 ) 
		{
			$('#validateEyeBtn8').css('display','none');
			overlayValidation()
		}
	}

	if (btnID == 9) 
	{
		validButton9 = validButton9 - 1;
		btn.text(validButton9);

		if (validButton9 == 0 ) 
		{
			$('#validateEyeBtn9').css('display','none');
			overlayValidation()
		}
	}

	

}

function validateEyeTraining()
{
	if (visibleBtns == 0)
	{
		$('.validateEyeTrainingBtn').css('display','block');
		visibleBtns = 1;
	}
}


function eyeTracking()
{
	window.saveDataAcrossSessions = true;

	let startLookTime = Number.POSITIVE_INFINITY;
	let lookDirection = null;
	const LOOK_DELAY = 1000; // 1sec
	const LEFT_CUTOFF = window.innerWidth / 16;
	const RIGHT_CUTOFF = window.innerWidth - window.innerWidth / 16;

	webgazer.setGazeListener((data, timestamp) => {


		validateEyeTraining();

		if (eyeTraining == true ) 
		{
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
				var module_id = $('#module_id').val();
				var baseURL = $('#baseURL').val();
				var exam_id = $('#exam_id').val();

				if (lookDirection === 'LEFT') 
				{ 
					// alert('LEFT');
					updateEyeFocusLost(module_id, exam_id, baseURL);
					// alert('Keep your eyes inside the Screen');
				}
				else if(lookDirection === 'RIGHT')
				{
					// alert('Keep your eyes inside the Screen');
					updateEyeFocusLost( module_id, exam_id, baseURL );
				}

				startLookTime = Number.POSITIVE_INFINITY;
				lookDirection = 'STOP';


				setTimeout(() => {
					// aha niho haviramwo image 1 hakza izindi
					lookDirection = 'RESET';

				});
			}
		}
	}).begin();

	// hide cammera
	webgazer.showVideoPreview(true).showPredictionPoints(true);
}


function updateFocusLost(module_id, exam_id, baseURL)
{
	if (eyeTraining == true ) 
	{
		$.ajax(
		{
		 	url:baseURL+'eexam/course/courseController/updateFocusLost_c/',
		 	type:'POST',
		 	data:
		 	{
	 			moduleID: module_id,
	 			examID: exam_id
			},
			success: function(data)
			{
				$('#page_focus_lost_number').html(' || Page focus lost  = '+data);
			}
		});
	}
}



function updateEyeFocusLost( module_id, exam_id, baseURL)
{
	$.ajax(
	{
	 	url:baseURL+'eexam/course/courseController/updateEyeFocusLost_c/',
	 	type:'POST',
	 	data:
	 	{
 			moduleID: module_id,
 			examID: exam_id
		},
		success: function(data)
		{
			$('#eye_focus_lost_number').html(' || Eye focus lost  = '+data);

		}
	});

}

function startExam()
{
	var module_id = $(this).find('#module_id').val();
	var exam_id = $(this).find('#exam_id').val();
	var baseURL = $(this).find('#baseURL').val();

	function play()
	{
		document.title='focus';
	}

	function pause()
	{
		document.title='blur';
		updateFocusLost(module_id, exam_id, baseURL);
	}

	$.ajax(
	{
	 	url:baseURL+'eexam/course/courseController/insert_user_attemption/',
	 	type:'POST',
	 	data:
	 	{
 			moduleID: module_id,
 			examID: exam_id
		},
		success: function(data)
		{
			questBox.css('display','block');
				$('#submitBtn').css('display','block');
				$('#startBtn').css('display','none');

			window.addEventListener('blur', pause);
			window.addEventListener('focus', play);
			// eyeTracking();
		}
	});
}


function submitExam(event)
{
	event.preventDefault();
 // 	if (confirm('Are you sure You want to Submit The exam ?')) 
	// {
		var module_id = $(this).find('#module_id').val();
		var exam_id = $(this).find('#exam_id').val();
		var baseURL = $(this).find('#baseURL').val();
		var messages = 'submit';
		$.ajax({
		 	url:baseURL+'eexam/course/courseController/update_submition_c/',
		 	type:'POST',
		 	data:
		 	{
	 			moduleID: module_id,
	 			message: messages,
	 			examID: exam_id
			},
			success: function(data)
			{
				document.close();
				document.write(data);
			}
		 });
	// }
}

// -------------------------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------------------------











	// the start of the real codes 
// ---------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------


if (permit>=70) 
{
	$('.choiceBox').css('display','none');
	$('#validateEyeTrainingOverlay').css('display','none');
}
else
{
	// For exam_assign_question_page.php
	$('.choiceBox').css('display','none');
	var questionLink = $('.questionLink');
	questionLink.on('click', function(event)
	{
		event.preventDefault();
		$('.choiceBox').slideUp();
		var choiceBox_id = $(this).find('#choiceBox_id').val();
		$('#'+choiceBox_id).slideDown();
	});

	var submition_status  = $('#submition_status').val();
	var startTimestamp  = $('#startTimestamp').val();
	var endTimestamp  = $('#endTimestamp').val();
	var now  = $('#now').val();

	if (submition_status == 'submit' || startTimestamp > now || endTimestamp < now )
	{
		$('#saveBtn').css('display','none');
		$('#saveBtn2').css('display','none');
		$('#validateEyeTrainingOverlay').css('display','none');
	}
	else
	{
		var saveBtn2 = $('#saveBtn2');
		var saveBtn = $('#saveBtn');

							// for exam_answer_question_page.php
		// -------------------------------------------------------------------//
		
		saveBtn2.on('click', function(event)
		{
		  	event.preventDefault();

	 		var module_id = $('#module_id').val();
	 		var question_id = $(this).parent().find('#question_id').val();
	 		var exam_id = $('#exam_id').val();
	 		var answer_title = $('.answer_title:checked').val();
	 		var baseURL = $('#baseURL').val();
	 		var answered_notification = $(this).parent().parent().parent().find('.answered_notification');
	 		var choiceBox = $(this).parent().parent();
			if (answer_title!='')
			{	
				// alert(question_id);
				$.ajax(
				{
					url:baseURL+'eexam/course/courseController/insert_exam_answer_question_c/',
					type:'POST',
					data:
					{
						course_id: module_id,
						question_id: question_id,
						exam_id: exam_id,
						answer_title: answer_title
					},
					success: function(data)
					{
						answered_notification.html( '&#10004;' );
						choiceBox.slideUp();
					}
				});
			}
		});


			// For essay_or_short_answer_page.php
		// --------------------------------------------------//
		
		saveBtn.on('click', function(event)
		{
			event.preventDefault();
		 	var module_id = $('#module_id').val();
			var question_id = $(this).parent().find('#question_id').val();
			var exam_id = $('#exam_id').val();
			var answer_title = $('#answer_title').val();
			var baseURL = $('#baseURL').val();
			var answered_notification = $(this).parent().parent().parent().find('.answered_notification');
			var choiceBox = $(this).parent().parent();

			// alert(question_id);

			if (answer_title!='')
			{
				$.ajax(
				{
					url:baseURL+'eexam/course/courseController/insert_exam_answer_question_c/',
					type:'POST',
					data:
					{
						course_id: module_id,
						question_id: question_id,
						exam_id: exam_id,
						answer_title: answer_title
					},
					success: function(data)
					{
						answered_notification.html( '&#10004;' );
						choiceBox.slideUp();
					}
				});
			}
		});



		// for Start Button
	// ------------------------------------------//
 		var questBox = $('.questionsBox');
 		questBox.css('display','none');
 		$('#submitBtn').css('display','none');

		var startBtn = document.querySelector('#startBtn');
		startBtn.style.width = '20%';
		startBtn.addEventListener('click', startExam);


		// for submit Button
	// ------------------------------//
 		var submitBtn = document.querySelector('#submitBtn');
		submitBtn.style.width = '20%';
		submitBtn.addEventListener('click', submitExam);

		eyeTracking();
		
	}

}
