<?php

	

	require_once "cfg.php";
	session_start();


	if (isset($_POST['reg'])) {
		
		$user=$_POST['login'];
		$password=$_POST['password'];

		$result=$connect->query("select * from user where login='$user' and password='$password'");
		$row=$result->fetch();
		if ($row) {

			
			session_start();
			$_SESSION['login']=$user;
			echo "Вход выполнен";
			
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
	<title>Вход</title>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<a href="index.php">На главную</a>

<?php

if (isset($_SESSION['login'])) {
	echo '<form action="authorization.php" method="post">
			<input type="submit" name="exit" value="Выход">
		</form><br>';
	echo '<a href="records.php">Мои записи</a>';
}
	else 
	{
	echo '
	<div id="wrapper">
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
	
<form name="login-form" class="login-form" action="authorization.php" method="post">

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