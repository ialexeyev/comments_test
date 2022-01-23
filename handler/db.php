<?php
	define("DB_SERVER", "127.0.0.1");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DATABASE", "comments");
	$commentsDB = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DATABASE);
	if($commentsDB === false)
	{
		die("ERROR: DATABASE CONNECTION: " . mysqli_connect_error());
	}

?>