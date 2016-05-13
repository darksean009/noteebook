<?php
require_once "cfg.php";

session_start();
if (isset($_SESSION['login'])) {
	header('Location: index.php');
}



if(isset($_POST['reg']))
{
	$login=trim($_POST['login']);
	$pass=md5(trim($_POST['password']));



	$query="select * from user where login='$login'";
	$result=$connect->query($query);
	$row=$result->fetch();
	if (!empty($row)) {
		echo "Пользователь с таким логином уже существует";
	}

	else
	{

		$query="insert into user(login,password) values('$login','$pass')";


		if ($connect->exec($query)) {
			
			//echo "Регистрация прошла успешно </br>";
			$_SESSION['login']=$login;
			//echo "Вход выполнен";
			header('Location: records.php');

		}
		else
		{
			echo "Ошибка при регистрации";
		}
	}
}



?>


<html>
<head>
	<meta charset="utf8">
	<title></title>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="wrapper">	
	<form action="reg.php" method="POST" class="login-form">

	<div class="header">
		<h1>Регистрация</h1>
		<span>Введите ваши регистрационные данные. </span>
    </div>

	<div class="content">		
		<input type="text" name="login" class="input username" placeholder="Логин" required>
		<input type="password" name="password" class="input password" placeholder="Пароль" required>
	</div>	 

	<div class="footer">
		<input type="submit" value="РЕГИСТРАЦИЯ" name="reg" class="button" />
		<a href="index.php" class="register">Вход</a>
	</div>

	</form>	
</div>
<div class="gradient"></div>



</body>
</html>