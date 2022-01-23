<!DOCTYPE html>
<html lang = "RU">
<head>
	<meta charset = "UTF-8">
	<title>Вход для администратора</title>
	<link rel = "stylesheet" href = "styles/main.css" type = "text/css"></link>
	<link rel = "shortcut icon" href = "img/fb.ico" type = "image/x-icon">
	<style>
		body
		{
			background-size: 2400px 1000px;
		}
	</style>
</head>
<body>
	<div id = "AdminAccessFormBlock">
			<form action = "handler/AdminAccessHandler.php" method = "POST" name = "AccessForm">
				<p id = "HeaderConnection">Вход для администратора</p>
				<p id = "AdminLogin">Логин:<input type = "text" name = "login" required value = "<?php htmlspecialchars($_POST['login'], ENT_QUOTES);?>"></input></p>
				<p id = "AdminPassword">Пароль:<input type = "password" name = "pass" required value = "<?php htmlspecialchars($_POST['pass'], ENT_QUOTES);?>"></input></p>
				<input type = "submit" value = "Войти" id = "AdminEnter" name = "do_login"></input> 
			</form>
	</div>
</body>
</html>