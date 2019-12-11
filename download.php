<?php

//set time limit constraints
ini_set('max_execution_time', 0);
set_time_limit(1800);
ini_set('memory_limit', '-1'); 

$path = $_GET['path'];

if(!$path)
{
	//open error404 page
	header("Location: error404.php");
}
else
{
	// Get real path for our folder
$rootPath = realpath($path);
$file_d = "submission.zip";

// Initialize archive object
$zip = new ZipArchive();
$zip->open($file_d, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();

//outputs file
if (!file_exists($file)) {
    error_log('File doesn\'t exist.');
    echo 'Folder is empty';
    return;
}

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);
header("Content-Type: application/zip");
header("Content-Disposition: attachment; filename=" . basename($file_d) . ";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . filesize($file_d));
readfile($file_d);

//deletes file when its done...
unlink($file_d);

}

?>