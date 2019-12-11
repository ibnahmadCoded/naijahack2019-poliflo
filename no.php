<?php 
//script for labeling an image NO. 
	
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

	// echo json_encode($media);

	$main_media_path = $path."main/" . $media[$media_file] . ".jpg";
	$true_media_path = $path."true/" . $media[$media_file] . ".jpg";
	$false_media_path = $path."false/" . $media[$media_file] . ".jpg";



	//check for existence of file in false folder and delete before copying to true folder.

	if (in_array($media[$media_file], $true_media, TRUE))
	{ 
		//copy to true folder, delete in false folder , then go to media page
		unlink($true_media_path);
		copy($main_media_path, $false_media_path);

		header("Location: next_media.php?media_file=$media_file&question=$task_question&path=$path&task_id=$task_id");

	}
	else if (in_array($media[$media_file], $false_media, TRUE))
	{
		// if it already exists in true media, don't copy! just go to media page!
		header("Location: next_media.php?media_file=$media_file&question=$task_question&path=$path&task_id=$task_id");
	}
	else
	{
		//copy as default if none of the above conditions are met, go to media page.
		copy($main_media_path, $false_media_path); 
		header("Location: next_media.php?media_file=$media_file&question=$task_question&path=$path&task_id=$task_id");
	}

?>