<?php

	

	require_once "cfg.php";
	session_start();

	if (isset($_SESSION['login'])) {
	header('Location: records.php');
}

	
	if (isset($_POST['reg'])) {
		
		$user=trim($_POST['login']);
		$password=md5(trim($_POST['password']));

		$result=$connect->query("select * from user where login='$user' and password='$password'");
		$row=$result->fetch();
		if ($row) {

			
			session_start();
			$_SESSION['login']=$user;
			//echo "Вход выполнен";
			header('Location: records.php');
			
		}
		else
		{
			echo "Неверный логин или пароль";
		}


	}

	if (isset($_POST['exit'])) {

		unset($_SESSION['login']);
		session_destroy();
		# code...
	}

	
?>

<html>
<head>
	<meta charset="utf8">
	<title>Входаs</title>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>



<?php

if (!isset($_SESSION['login'])) {

	
	echo '
	<div id="wrapper">
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
	
<form name="login-form" class="login-form" action="index.php" method="post">

    <div class="header">
		<h1>Авторизация</h1>
		<span>Введите ваши регистрационные данные для входа. </span>
    </div>

    <div class="content">
		<input name="login" type="text" class="input username" placeholder="Логин">
		<input name="password" type="password" class="input password" placeholder="Пароль">
    </div>

    <div class="footer">
		<input type="submit" name="reg" value="ВОЙТИ" class="button" />
		<a href="reg.php" class="register">Регистрация</a>
    </div>

</form>
</div>
<div class="gradient"></div>';	
}
?>
</body>
</html>