<?php

	require_once "cfg.php";
	session_start();

	if (!isset($_SESSION['login'])) {
	header('Location: index.php');
	}

	if(!empty($_GET['change']))
{
	$idrecord=$_GET['change'];
	$_SESSION['idrecord']=$idrecord;
	$query="select * from record where id_record=$idrecord";
	//echo $query;
	$result=$connect->query($query);
	foreach ($result as $row ) {
		$title=$row['title'];
		$content=$row['content'];
	}

}



	if (isset($_POST['save'])) {

				$user=$_SESSION['login'];
				$content=htmlspecialchars("{$_POST['content']}");
				$title=htmlspecialchars("{$_POST['title']}");
				

				$query="update record set title=:title,content=:content where id_record=:idrecord";
				$stmt = $connect->prepare($query);
				$stmt->bindParam(':title',$title);
				$stmt->bindParam(':content',$content);
				$stmt->bindParam(':idrecord',$_SESSION['idrecord']);
				
				if ($stmt->execute()) {
					//echo "Запись успешно изменена </br>";
					//echo "<a href='records.php'>Вернуться к записям</a>";
				}
				else 
				{
					//echo "Ошибка при изменении";
				}
			
				$idrecord=$_SESSION['idrecord'];
				$query="select * from record where id_record=$idrecord";
				//echo $query;
				$result=$connect->query($query);
				foreach ($result as $row ) {
					$title=$row['title'];
					$content=$row['content'];
				}



			}


?>

<html>
<head>
	<meta charset="utf8">
	<title>Изменение записи</title>


	<link rel="stylesheet"  href="css/style.css">

</head>
<body>
	
<a href="records.php">Вернуться к записям</a>
	<form action="changerecord.php" method="POST" class="record-form">
		<div class="content">
		<input type="text" name="title" value="<?php echo $title; ?>" class="input"> 
		<textarea rows=10 cols=50 name="content" class="input" required><?php echo $content; ?></textarea>
		</div>
		<input type="submit" name="save" class="button" value="Сохранить"> 
	</form>



</body>
</html>