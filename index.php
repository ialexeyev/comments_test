<!DOCTYPE html>
<html lang = "RU">
<head>
	<meta charset = "UTF-8">
	<meta http-equiv="x-ua-compatible" content="IE=edge">
	<title>Отзывы</title>
	<link rel = "stylesheet" href = "styles/main.css" type = "text/css"></link>
	<link rel = "shortcut icon" href = "img/fb.ico" type = "image/x-icon">

</head>
<body>
	<header>
		<h1 id = "HeaderOtzyvy">страница отзывов</h1>
		<input type = "button" name = "Admin" value = "Admin" onClick = 'location.href="AdminAccess.php"' target = "_blank"></input>
	</header>
	<main>
		<div class = "MainBlockOtzyvy" align  = "center">
			<table id = "MyTable">
				<thead>
					<tr class = "TRow" id = "FristTRow" style = "background:#F5FFFA;">
						<th  class = "THeadCell" onclick="sortTable(0)"><button type = "button" class = "FilterButtons">Фильтровать по Дате</button></th>
						<th class = "THeadCell" onclick="none"></th>
						<th  class = "THeadCell"><button type = "button" class = "FilterButtons">Фильтровать по имени</button></th>
						<th  class = "THeadCell"><button type = "button" class = "FilterButtons">Фильтровать по Email</button></th>
						<th  class = "THeadCell"><button type = "button" disabled class = "FilterDisabledButtons"></button></th>
						<th  class = "THeadCell"><button type = "button" disabled class = "FilterDisabledButtons"></button></th>
					</tr>
				</thead>
				<tbody>
					
					<tr class = "TRow" style = "background: #b0e0e6;">
						<td class = "TCell" onclick="sortTable(0)">01.01.2000</td>
						<td class = "TCell" id = "TImg"><img src = "img/fb.ico" style ="height: 130px; width: 170px"></img></td>
						<td class = "TCell" style = "max-width: 100px; text-align: center;">Джек</td>
						<td class = "TCell" style = "max-width: 200px;">jack.sh12464@gmail.com</td>
						<td class = "TCell" id = "TComment"><textarea name = "admincomment" id = "admincomment" disabled style="background:#e0ffff;">Это вечный отзыв! Он будет на этой странице всегда просто так.</textarea></td>
						<td class = "TCell" id = "ValidatedByAdmin" style = "max-width: 100px; font-size: 12px; "></td>
					</tr>
					
				<?php
					include_once 'handler/db.php';
					$result_upload = mysqli_query($commentsDB, "SELECT * FROM `table` ORDER BY ID DESC");
					if($result_upload === false)
					{
						die("ERROR: БАЗА ДАННЫХ ПУСТА. " . $mysqli->error);
					}
					while($comments_array = mysqli_fetch_assoc($result_upload))
					{
						if($comments_array['validated']==1)
						{
						?>
						<tr class = "TRow" style = "background: #b0e0e6;">
							<td class = "TCell" onclick="sortTable(0)"><?php $date_output = $comments_array['date']; echo $date_output; ?></td>
							<td class = "TCell" id = "TImg">
							<?php $show_img = base64_encode($comments_array['img']);?><img src="data:image/jpeg;base64, <?=$show_img ?>" height = "130px" width = "170px" alt=""></td>
							<td class = "TCell" style = "max-width: 100px; text-align: center;"><?php $username_output = $comments_array['name']; echo $username_output;?></td>
							<td class = "TCell" style = "max-width: 200px;"><?php $usermail_output = $comments_array['email']; echo $usermail_output; ?></td>
						<form action = "handler/AdminHandler.php" method = "POST" enctype="multipart/form-data">
							<td class = "TCell" id = "TComment">
								<textarea name = "admincomment" id = "admincomment" disabled style="background:#e0ffff;"><?php $usertext_output = $comments_array['comment']; echo $usertext_output; ?>
								</textarea>
							</td>
							<td class = "TCell" id = "ValidatedByAdmin" style = "max-width: 100px; font-size: 12px; ">
								<?php 
									if($comments_array['changed'] == 1)
									{
										?> Изменен администратором <?php
									} 
								?>
							</td>
						</form>
						</tr>
						<?php
						}
					}
					mysqli_close($commentsDB);
				?>
				</tbody>
			</table>	
		</div>
			
		<div class = "BlockFormSentOtzyv">
			<form action = "handler/MainHandler.php" method = "POST" enctype="multipart/form-data">
				<h2 id = "FormHeader">Оставить отзыв</h2>
				<p id = "TextName">Имя:<input type = "text" name = "username" id = "username" placeholder = "Джек"></input></p>
				<p id = "TextEmail">E-mail:<input type = "email" name = "useremail" id = "useremail" placeholder = "jaсk_ford343654@mail.ru"></input></p>
				<p id = "TextOtzyv">Ваш отзыв:<textarea name = "usertext" id = "usertext" placeholder = "Ваш отзыв"></textarea></input></p>
				<p id = "TextImg">Прикрепить картинку:</p>
				<div class="PictureWrapper">
					<input type="file" name="userpicture" id="userpicture" accept=".jpg, .png, .gif">
					<label for="userpicture" id = "userpicturelabel">
						<span class="PictureFileText">Выберите файл</span>
					</label>
					<div id = "picturename"></div>
					<div id = "pictureerrors"></div>
				</div>
				<button type = "button" id = "SendOtzPrevius" name = "SendOtzPrevius">Предварительный просмотр</button>
				<button type = "submit" id = "SendOtz" name = "SendOtz" disabled style = "opacity: 0.5">Отправить</button>
			</form>
			<div id = "ErrorMessage"></div>
			<div id = "PreviousView">
				<div id = "PreviousName"></div>
				<div id = "PreviousEmail"></div>
				<div id = "PreviousDate"></div>
				<p id = "PreviousText"></p>
				<img src = "" id = "PreviousImg"></img>
			</div>
		</div>
		<script src = "lib/jquery.js"></script>
		<script src = "js/form.js"></script>
		<script type="text/javascript" src="lib/jquerytable.js"></script>
			<script type="text/javascript" src="lib/jquerytable2.js"></script>
			<script>
				$(document).ready(function() {
					$('#MyTable').DataTable( {
					"searching" : false,
						"paging":   false,
						"ordering": true,
						"info":     false
					} );
				} );
			</script>
	</main>
	<footer>
		<p>Contacts: + 7 925 605 85 82 (WhatsApp)</p>
	</footer>
</body>
</html>