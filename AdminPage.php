<!DOCTYPE html>
<html lang = "RU">
<head>
	<meta charset = "UTF-8">
	<title>Страница администратора</title>
	<link rel = "stylesheet" href = "styles/main.css" type = "text/css"></link>
	<link rel = "shortcut icon" href = "img/fb.ico" type = "image/x-icon">
	<style>
		body
		{
			background: linear-gradient(45deg, #000080, white);
		}
		
	</style>
</head>
<body>
	<header>
		<h1 id = "AdminPageHeader">Страница администратора</h1>
		<input type = "button" value = "MAIN PAGE" name = "BackToMainPageButton" id = "BackToMainPageButton" target = "_blank" onclick = 'location.href="index.php"'></input>
	</header>
	<main>
		<?php
			
		?>
		<div class = "AdminBlock">
			<table id = "MyTable">
				<thead>
					<tr class = "TRow" id = "FristTRow">
						<th  class = "THeadCell" onclick="sortTable(0)"><button type = "button" class = "FilterButtons">Фильтровать по Дате</button></th>
						<th class = "THeadCell" onclick="none"></th>
						<th  class = "THeadCell"><button type = "button" class = "FilterButtons">Фильтровать по имени</button></th>
						<th  class = "THeadCell"><button type = "button" class = "FilterButtons">Фильтровать по Email</button></th>
						<th  class = "THeadCell"><button type = "button" disabled class = "FilterDisabledButtons"></button></th>
						<td  class = "THeadCell"><button type = "button" disabled class = "FilterDisabledButtons"></button></td>
					</tr>
				</thead>
				<tbody>
					
				<?php
					include_once 'handler/db.php';
					$result_upload = mysqli_query($commentsDB, "SELECT * FROM `table`");
					if($result_upload === false)
					{
						die("ERROR: БАЗА ДАННЫХ ПУСТА. " . $mysqli->error);
					}
					while($comments_array = mysqli_fetch_assoc($result_upload))
					{
						?>
						<tr class = "TRow">
							<td class = "TCell" onclick="sortTable(0)"><?php $date_output = $comments_array['date']; echo $date_output; ?></td>
							<td class = "TCell" id = "TImg">
							<?php $show_img = base64_encode($comments_array['img']);?><img src="data:image/jpeg;base64, <?=$show_img ?>" height = "130px" width = "170px" alt=""></td>
							<td class = "TCell" style = "max-width: 120px;"><?php $username_output = $comments_array['name']; echo $username_output;?></td>
							<td class = "TCell" style = "max-width: 200px;"><?php $usermail_output = $comments_array['email']; echo $usermail_output; ?></td>
						<form action = "handler/AdminHandler.php" method = "POST" enctype="multipart/form-data">
							<td class = "TCell" id = "TComment">
								<textarea name = "admincomment" id = "admincomment"<?php 
									if(($comments_array['validated'] != 0) || ($comments_array['changed'] == 1) || ($comments_array['declined'] == 1))
									{
										?> disabled <?php
									}
								?>
								><?php $usertext_output = $comments_array['comment']; echo $usertext_output; ?>
								</textarea>
							</td>
							<td class = "TCell" id = "ValidatedByAdmin" style = "<?php if($comments_array['declined'] == 1){?> color: red;<?php } ?>">
								<?php 
									if($comments_array['validated'] == 0)
									{
										if($comments_array['declined'] == 1)
										{
											echo "Отклонен";
										}
										else
										{
											?> 
												<button type = "submit" name = "1" value = "<?=$comments_array['id'];?>" id = "ValidateButton">Валидировать</button>
												<button type = "submit" name = "0" value = "<?=$comments_array['id'];?>" id = "DeclineButton">Отклонить</button>
											<?php
										}
									} 
									else 
									{ 
										echo "Валидирован";
										echo "<br>";
										if ($comments_array['changed'] == 1)
										{
											echo "Изменен";
										}
									}
								?>
							</td>
						</form>
						</tr>
						<?php
					}
					mysqli_close($commentsDB);
				?>
				</tbody>
			</table>
		</div>
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