<?php
/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 9/19/16
 * Time: 2:19 PM
 */


session_start();


$parent = basename(dirname($_SERVER['PHP_SELF']));
if($parent == "" || $parent == "Stonestreet"){
    $file = "../stonestreet_config.txt";
}else{
    $file = "../../stonestreet_config.txt";
}
//echo $parent;
//exit;

$json = "";
if (file_exists($file))
{
    // Note: You should probably do some more checks
    // on the filetype, size, etc.
    $contents = file_get_contents($file);

    // Note: You should probably implement some kind
    // of check on filetype

    $json = $contents;
}
$json = json_decode($json);
//echo "Username= ". $json->{'username'};
//exit;
//TODO change this for when the server is live.
$dbhost = $json->{'host'};
$dbname = 'pr_tracker'; // the name of the database that you are going to use for this project

$dbuser = $json->{'username'}; // the username that you created, or were given, to access your database
$dbpass = $json->{'password'}; // the password that you created, or were given, to access your database
$port = $json->{'port'};

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname,$port);

if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
