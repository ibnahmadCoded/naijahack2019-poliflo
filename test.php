<?php
//include file that lets us get duration of video/audio files
include_once('getid3/getid3.php');

$media = array();

$fPath = "ibrahim";

$file_dir  = "task_media\\{$fPath}\\main";

$destination_dir = "task_media\\{$fPath}\\transcriptions\\";

$transcription_files = array();


            foreach (glob("{$file_dir}/*") as $filename) 
            { //the directory in glo() should be changed to particular task media directory!
                 $p = pathinfo($filename);
                 $transcription_files[] = $p['filename'];
            }

            for ($y=0; $y < sizeof($transcription_files); $y++)
            {
                $newfile = $destination_dir.$transcription_files[$y].".txt";
                $fh = fopen($newfile, 'w') or die("Can't create file");
            }

            if($fh)
            {
                echo "DONE";
            }

?>