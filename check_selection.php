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

	$true_media = array(); //all files that fit the requested description

	foreach (glob("{$path}true/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
		$p = pathinfo($filename);
		 $true_media[] = $p['filename'];
	}

	$false_media = array(); //all files that do not fit the requested description

		foreach (glob("{$path}false/*.*") as $filename) { //the directory in glo() should be changed to particular task media directory!
		$p = pathinfo($filename);
		$false_media[] = $p['filename'];
	}

	if (in_array($media[$media_file], $false_media, TRUE) || in_array($media[$media_file], $true_media, TRUE))
	{ 
		//if file is in false folder or false folder, increase $media file and open next image!
		$next_media = $media_file + 1;

		if($next_media < sizeof($media))
		{
			$next_media = $media_file + 1;
			header("Location: next_media.php?media_file=$next_media&question=$task_question&path=$path&task_id=$task_id");
		}
		else
		{
			header("Location: next_media.php?media_file=$media_file&question=$task_question&path=$path&task_id=$task_id"); 
		}

	}
	else
	{
		//if not, do not open next image, alert the error.
		header("Location: next_media.php?media_file=$media_file&question=$task_question&path=$path&task_id=$task_id");
	}

?>