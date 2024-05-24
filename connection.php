<?php

$dbhost = "localhost";
$dbuser = "admin";
$dbpass = "168168";
$dbname = "login_sample_db";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{

	die("failed to connect!");
}

