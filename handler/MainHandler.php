<?php
	define("DB_SERVER", "127.0.0.1");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DATABASE", "comments");

	//OPENING CONNECTION
	$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS);
	if($mysqli === false)
	{
		die("ERROR: CONNECTION FAILED: " . $mysqli->connect_error);
	}
	
	//Database creation
	$db_comments = mysqli_select_db($mysqli, DATABASE);
	if (!$db_comments)
	{
		$create = "CREATE SCHEMA `comments` DEFAULT CHARACTER SET utf8";
		if ($mysqli->query($create) === true){}
		else
		{
			die("ERROR: DATABASE CREATION FAILED: " . $mysqli->error);
		}
	}
	
	//Connection and table creation
	$commentsDB = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DATABASE);
	if($commentsDB === false)
	{
		die("ERROR: DATABASE CONNECTION: " . mysqli_connect_error());
	}
	
	$table_creation = "CREATE TABLE IF NOT EXISTS `comments`.`table` (
					  `id` INT NOT NULL AUTO_INCREMENT,
					  `img` MEDIUMBLOB NULL,
					  `name` VARCHAR(50) NULL,
					  `email` VARCHAR(60) NULL,
					  `comment` TEXT(7000) NULL,
					  `date` DATE NULL,
					  `validated` TINYINT(1) NULL,
					  `changed` TINYINT(1) NULL,
					  `declined` TINYINT(1) NULL,
					  PRIMARY KEY (`id`))";
	if(mysqli_query($commentsDB, $table_creation)){}
	else
	{
		echo "ERROR: TABLE CREATION FAILED: " . mysqli_error($commentsDB);
		exit();
	}
	
	//for image data 
	$img_type = substr($_FILES['userpicture']['type'], 0, 5);
	if(!empty($_FILES['userpicture']['tmp_name']) and $img_type === 'image')
	{ 
		$img = addslashes(file_get_contents($_FILES['userpicture']['tmp_name']));
	}
	else
	{
		$img = addslashes(file_get_contents('../img/fb.ico'));
	}
	
	
	//for text data
	$name = $_POST['username'];
	$mail = $_POST['useremail'];
	$com = $_POST['usertext'];
	$date = date('Y-m-d');
	//INSERT DATA TO DATABASE
	$insert_data = "INSERT INTO `table` (`id`, `img`, `name`, `email`, `comment`, `date`, `validated`, `changed`, `declined`)
					VALUES (NULL, '$img', '$name', '$mail', '$com', '$date', '0', '0', '0')";
	if(mysqli_query($commentsDB, $insert_data)){}
	else
	{
		echo " INSERT DATA ERROR: " . mysqli_error($commentsDB);
		exit();
	}
	
	//CLOSING CONNECTION

	mysqli_close($mysqli);
	echo "<h1 style ='color: green; margin-top: 200px; text-align: center; font-size: 48px; font-weight: 700'>ОТЗЫВ УСПЕШНО ОТПРАВЛЕН НА МОДЕРАЦИЮ!</h1>";
	echo '<script>setTimeout(\'location="../index.php"\', 2000)</script>';
	exit();
?>