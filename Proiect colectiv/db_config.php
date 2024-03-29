<?php

	$hname = 'localhost';
	$uname = 'root';
	$pass = '';
	$db = 'inspireshere';

	$con = mysqli_connect($hname,$uname,$pass,$db);

	if(!$con){
		die("Cannot Connect to Database".myaqli_connect_error());
	}
