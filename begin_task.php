<?php
//not working for now
$next_media = $_GET['media_file'];

$task_question = $_GET['question'];

$path = $_GET['path'];
$task_id = $_GET['task_id'];

$beginbutton= $_POST['begin_task'];

$media = array();

foreach (glob("{$path}/main/*.*") as $filename) 
{ //the directory in glo() should be changed to particular task media directory!
	$p = pathinfo($filename);
	$media[] = $p['filename'];
}




// if ($beginbutton)
// {
// 	//create files, 

// 	//open tasks
	header("Location: next_transcription.php?media_file=0&question=$task_question&path=$media_path&task_id=$task_id"); 
// }

?>