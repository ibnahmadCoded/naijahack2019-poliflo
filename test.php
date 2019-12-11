<?php 

//for making sure the needed file extension is gotten.
$media = array();

$path = "task_media/alege/";

				foreach (glob($path.'/main/*.*') as $filename) { //the directory in glo() should be changed to particular task media directory!
				    $p = pathinfo($filename);
				    $media[] = $p['filename'];
				}

				echo json_encode($media);

				//begins here..
				
				$file =  $path."main/".$media[3].".";

				$ext = array("jpg", "jpeg", "JPEG", "gif", "png", "bmp");

				for($x = 0; $x < 6; $x++)
				{

				    $src = $file.$ext[$x];

				    if(file_exists($src))
				    {

				        echo "<img id='imgFrame' src='$src' style='width:90%; height:500px;' />";
				    }
				}

				

?>