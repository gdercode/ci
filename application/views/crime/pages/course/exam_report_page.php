<?php
	$permit = $this->session->userdata('permit');
	$needed = $this->session->userdata('courseCreatePermit');

	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
	$module_id = isset($courseData) ? $courseData['module_id'] : '';
	$exam_id = isset($examData) ? $examData['exam_id'] : '';
?>
	<div class="content">	
		<h5><?php echo $error; ?> </h5>
	    <b id="report_notification"><?php echo $courseData['module_name']; ?></b>
	</div>

	<div class="content">
				<b id="report_notification"> Report table </b>
				<hr>
				<a href="<?php echo base_url('eexam/course/courseController/download_report_c/'.$exam_id.'/'.$module_id); ?>" > 
					Download Excel Format
				</a>

				<?php
					if (!empty($student_report) AND !empty($allQuestions))
					{	
				?>
					<div class="tables">
						<b id="report_notification"> <?php echo $examData['exam_title']; ?> </b>
						<table>
							<thead>
								<th>Username</th>
							<?php
								$i = 1;	
								foreach($allQuestions as $question)
								{
									echo '<th>Q'.$i.' /'.$question['question_grade'].'</th>';
									$i++;
								} 
							?>
								<th>Total/ <?php echo $maximum; ?></th>
								<th>Eye lost</th>
								<th>Page lost</th>
							</thead>
							<tbody>
						<?php 
							foreach($student_report as $student_id => $report)
							{
						?>
								<tr>
									<td><?php echo $report['info']['username']; ?></td>
									<?php
										foreach($allQuestions as $question)
										{
											if (isset($report['answer'][$question['question_id']])) 
											{
												if ($report['answer'][$question['question_id']]['result']>1000)
												{
													echo '<td> <b id="wrong_report_notification" > not graded </b> </td> ';
												}
												elseif ($report['answer'][$question['question_id']]['result'] >= $question['question_grade']/2)
												{
													echo '<td> <b id="vrai">'.$report['answer'][$question['question_id']]['result'].'</b></td>';
												}
												else
												{
													echo '<td> <b id="faux"> '.$report['answer'][$question['question_id']]['result'].'</b></td>';
												}
												
											}
											else
											{
												echo '<td> <b id="faux"> 0 </b></td>' ;
												// echo 'not answered';
											}
										} 
									?>
									<td>
										<?php 
												if ($report['total_result'] < 1000)
												{
													if ($report['total_result'] >= $maximum/2) {
														 echo '<b id="vrai">'.$report['total_result'].'</b>';
													}
													else
													{
														 echo '<b id="faux">'.$report['total_result'].'</b>';
													}
													
												}
										?>
											
									</td>
									<td>
										<?php echo $report['exam_monitoring']['eye_focus_lost']; ?>
									</td>
									<td>
										<?php echo $report['exam_monitoring']['page_focus_lost']; ?>
									</td>
								</tr>
						<?php			
							}
						?>
							</tbody>
						</table>
					</div>
				<?php 
					}
				?>


<br>
	<?php

		if (!empty($student_report) AND !empty($allQuestions))
		{
			foreach($student_report as $student_id => $report)
			{
				echo "<h3>".$report['info']['username']."<hr> </h3>";
				$user_id = $report['info']['user_id'];

				foreach($allQuestions as $question)
				{
					?>
						<a href="<?php echo base_url() ?>eexam/course/courseController/exam_grade_manual_page_c/<?php echo $user_id."/".$module_id."/".$question['question_id']."/".$examData['exam_id']; ?>" >
									<?php echo $question['question_title'] ;?>
						</a>
					<?php
					if (isset($report['answer'][$question['question_id']])) 
					{
						if ($report['answer'][$question['question_id']]['result']>1000)
						{
							echo '<b id="report_notification"> not graded </b> <br>';
						}
						elseif ($report['answer'][$question['question_id']]['result'] >= $question['question_grade']/2)
						{
							echo '<b id="vrai"> &#10004;</b> ';
							echo $report['answer'][$question['question_id']]['result']."/".$question['question_grade']." pts <br>" ;
						}
						else
						{
							echo '<b id="faux"> &#x2718;</b>';
							echo $report['answer'][$question['question_id']]['result']."/".$question['question_grade']." pts <br>" ;
						}
						
					}
					else
					{
						echo "0/".$question['question_grade']." pts " ;
						echo '<b id="wrong_report_notification"> not answered </b> <br>';
					}
				}

				if ($report['total_result']>1000)
				{
					echo '<h5> Some marks are missing <h5><hr>';
				}
				else
				{
					echo "<br>TOTAL = ".$report['total_result']."/".$maximum." pts <hr>" ;
				}


			}
		}
?>


	
	</div>

<?php 
 	$this->load->view('eexam/main_parts/footer');
 ?>

