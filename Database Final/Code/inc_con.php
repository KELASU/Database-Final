<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name ="databasefinal";
$connection = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

if(!$connection){
    die ("No Connection");
}
