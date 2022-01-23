/*For picture uploading */
$("#userpicture").on('change', function()
{
	var splittedFakePath = this.value.split('\\');
	$("#picturename").text(splittedFakePath[splittedFakePath.length - 1]);
});
$("#userpicture").on('change', function(event)
{
	var tmppath = URL.createObjectURL(event.target.files[0]);
	$("#PreviousImg").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
});





/*For previous control */
$("#SendOtzPrevius").on("click", function()
{
/*Checking */
	var username = $("#username").val().trim();
	var useremail = $("#useremail").val().trim();
	var usertext = $("#usertext").val().trim();
	let picture = document.getElementById("userpicture").files[0];
	if(username == "")
	{
		$("#ErrorMessage").text("Введите Имя")
		return false;
	}
	else if(useremail == "")
	{
		$("#ErrorMessage").text("Введите Email")
		return false;
	}
	else if(usertext.length < 10)
	{
		$("#ErrorMessage").text("Напишите отзыв размером не менее 10 символов")
		return false;
	}
	else if(picture)
	{
		if ((picture.type != "image/jpeg") && (picture.type != "image/png") && (picture.type != "image/gif"))
		{
			$("#ErrorMessage").text("Доступные типы файлов: jpg/png/gif!");
			return false;
		}
		else if (picture.size > 1000000)
		{
			$("#ErrorMessage").text("Размер изображения превышает 1 MB!");
			return false;
		}
	}
	else if (!picture)
	{
		document.getElementById("PreviousImg").src = "img/fb.ico";
	}
	
	$("#ErrorMessage").text("");
	
/*Getting CurrentDate */
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	today = mm + '/' + dd + '/' + yyyy;

/*Main Block: writing data and activating */
	

	$('#PreviousView').css('display','block');
	$("#PreviousName").text(username);
	$("#PreviousEmail").text(useremail);
	$("#PreviousDate").text(today);
	$("#PreviousText").text(usertext);
	
	$("#SendOtz").css('opacity', '1');
	$("#SendOtz").prop("disabled", false);
	
	
	
});
