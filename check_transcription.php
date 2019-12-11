<?php 
//this page checks if the current image has been labelled YES or NO before moving to next image.

$media_file = $_GET['media_file'];
$task_question = $_GET['question'];
$path = $_GET['path'];
$task_id = $_GET['task_id'];


	$media = array();

	foreach (glob("{$path}main/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
		$p = pathinfo($filename);
		$media[] = $p['filename'];
	}

	$transcriptions = array(); //all files that fit the requested description

	foreach (glob("{$path}transcriptions/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
		$p = pathinfo($filename);
		$transcriptions[] = $p['filename'];
	}


	if (sizeof($transcriptions) !== 0)
	{ 
		//check if file is empty
		$file =  $path."transcriptions/".$media[$media_file].".txt";
		$text = file_get_contents($file);

		if ($text != "")
		{ //if the file is not empty
			$next_media = $media_file + 1;

			if($next_media < sizeof($media))
			{
				$next_media = $media_file + 1;
				header("Location: next_transcription.php?media_file=$next_media&question=$task_question&path=$path&task_id=$task_id");
			}
			else
			{
				header("Location: next_transcription.php?media_file=$media_file&question=$task_question&path=$path&task_id=$task_id"); 
			}

		}
		else
		{ //if it is empty, do not open next vid/audio
			header("Location: next_transcription.php?media_file=$media_file&question=$task_question&path=$path&task_id=$task_id");
		}

	}
	else
	{
		//if not, do not open next image, alert the error.
		header("Location: next_transcription.php?media_file=$media_file&question=$task_question&path=$path&task_id=$task_id");
	}

?>