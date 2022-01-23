<?php
if(isset($_POST['do_login']))
{
	$errors = array();
	if((($_POST['login'])=="admin") and (($_POST['pass'])== '123'))
	{
		header('Location: ../AdminPage.php');
		exit();
	}
	else
	{
		$errors[] = 'Некорретные данные! Попробуйте еще раз!';
	}
	if(!empty($errors))
	{
		echo '<div style = "color: red; font-size: 48px; font-family: Courier, monospace; widt0h: 1200px;
			height: 50px; margin-top: 200px; margin-left: 220px;">' . array_shift($errors) . '</div><hr>';
		echo '<script>setTimeout(\'location="../AdminAccess.php"\', 2400)</script>';
	}
}
?>
