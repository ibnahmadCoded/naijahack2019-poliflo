<?php

//Bismil Ilaahil Aalamina Azeema, Ar-Rahmaani Raheemi, Maaliki Dayyaaan
//Allahumma Solli Alaa seyyidi Muhammad, waalihi washaabihi.
//Allahumma inni abrou min haoli wamin quwwatii ilaa haulika waquwwatika. Allahumma ini ataqorrobu ilayka bihaadha l amr, fataqobbal minni, Amin. 

include("includes/connection.php");

#session_start();

$ip = $_SERVER['REMOTE_ADDR'];

#$int_ip = ip2long($ip);

$insert_visitor = "INSERT INTO site_visitors (ip_address, date) VALUES ('$ip', NOW())"; //always register site visitors!
$run_insert = mysqli_query($con, $insert_visitor);

include("main.php");
?>