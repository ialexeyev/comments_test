<?php
	//var_dump($_POST);
	//echo "<br>";
	//print_r($_POST['admincomment']);
	
	$id_declined_value = $_POST[0]; 
	$id_value = $_POST[1];
	$admin_changed_comment = $_POST['admincomment'];
	include 'db.php';
	
	//To decline comment
	if($id_declined_value)
	{
		$decline_data = "UPDATE `table` SET `declined` = '1' WHERE `table`.`id` = $id_declined_value";
		if(mysqli_query($commentsDB, $decline_data)){}
		else
		{
			echo "UPDATE DATA (FOR DECLINE COMMENT) ERROR: " . mysqli_error($commentsDB);
		}
		mysqli_close($commentsDB);
		header('Location: ../AdminPage.php');
		exit();
	}
	
	
	//validation
	if($id_value)
	{
		$update_data = "UPDATE `table` SET `validated` = '1' WHERE `table`.`id` = $id_value";
		if(mysqli_query($commentsDB, $update_data)){}
		else
		{
			echo " UPDATE DATA ERROR: " . mysqli_error($commentsDB);
			exit();
		}
		
		//For changing comments by admin
		$ar_diff = 0;
		$current_value_comment_query = mysqli_query($commentsDB, "SELECT `comment` FROM `table` WHERE `table`.`id` = $id_value");
		if($current_value_comment_query === false)
		{
			die("ERROR WRITING DATA FROM DB FOR CHANGING: " . $mysqli->error);
		}
		while($current_value_comment = mysqli_fetch_assoc($current_value_comment_query))
		{
			$ar_diff = similar_text((trim($admin_changed_comment)), trim($current_value_comment['comment']));
		}
		if((strlen(trim($admin_changed_comment))) == $ar_diff){}
		else
		{
			$change_data = "UPDATE `table` SET `comment` = '$admin_changed_comment' WHERE `table`.id = $id_value";
			if(mysqli_query($commentsDB, $change_data)){}
			else
			{
				echo " CHANGE DATA ERROR: " . mysqli_error($commentsDB);
				exit();
			}
			$changed_status = "UPDATE `table` SET `changed` = '1' WHERE `table`.`id` = $id_value";
			if(mysqli_query($commentsDB, $changed_status)){}
			else
			{
				echo " CHANGE STATUS DATA ERROR: " . mysqli_error($commentsDB);
				exit();
			}
		}	
	}
	
	mysqli_close($commentsDB);
	header('Location: ../AdminPage.php');
?>