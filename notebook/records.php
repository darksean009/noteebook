<?php

require_once "cfg.php";
session_start();

if (!isset($_SESSION['login'])) {
	header('Location: index.php');
}
	
		
		$user=$_SESSION['login'];
		

			if (isset($_POST['add_record'])) {

				$user=$_SESSION['login'];
				$record=htmlspecialchars("{$_POST['record']}");
				$title=htmlspecialchars("{$_POST['title']}");

				$query="insert into record(user,title,content,date_record) values(:user,:title,:record,:date_record)";
				$dateinsert=date("Y-m-d");
				$stmt = $connect->prepare($query);
				$stmt->bindParam(':user',$user);
				$stmt->bindParam(':title',$title);
				$stmt->bindParam(':record',$record);
				$stmt->bindParam(':date_record',$dateinsert);
				if ($stmt->execute()) {
					//echo "Новая запись успешно добавлена";
				}
				else 
				{
					echo "Ошибка при добавлении";
				}
				# code...
			}

			if (isset($_GET['delete'])) {

				$recdelete=$_GET['delete'];

				$query="delete from record where id_record=:record";
				$stmt = $connect->prepare($query);
				$stmt->bindParam(":record",$recdelete);
				if ($stmt->execute()) {
					//echo "Запись успешно удалена";
				}
				else 
				{

					echo "Ошибка при удалении";
				}
				
			}

			
		$on_page = 7;

		$query="select count(*) from record where user='$user'";

$result=$connect->query($query);

$rowCount=$result->fetchColumn();
//echo $rowCount;
if ($rowCount>0) {
	# code...

$num_pages = ceil($rowCount / $on_page);
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Если текущая страница меньше единицы, то страница равна 1
if ($current_page < 1)
{
    $current_page = 1;
}
// Если текущая страница больше общего количества страница, то
// текущая страница равна количеству страниц
elseif ($current_page > $num_pages)
{
    $current_page = $num_pages;
}

$start_from = ($current_page - 1) * $on_page;


		$result=$connect->query("select id_record,title,date_record,content from record where user='$user' order by id_record desc LIMIT $start_from, $on_page");
}



?>
<html>
<head>
	<meta charset="utf8">
	<title>Записи</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet"  href="style.css">
<script src="jquery.js"></script>

<script type="text/javascript">
$(document).ready(function(){
 $('.spoiler_links').click(function(){
    if ($(this).next('.spoiler_body').css("display")=="none") {
        $('.spoiler_body').hide('normal');
        $(this).next('.spoiler_body').toggle('normal');
    }
    else $('.spoiler_body').hide('normal');
    return false;
 });
});
</script>



<style type="text/css">
 	.spoiler_body {display:none;}
 	.spoiler_links {cursor:pointer;}
</style>

</head>
<body>
	

	<?php

		if (isset($_SESSION['login'])) 
			{
				echo '<form action="index.php" method="post">
					 <input type="submit" name="exit" value="Выход" class="buttonexit">
					 </form><br>';
	
			}

	?>
<div id="divform" align="left">
	<form action="records.php" method="POST" class="record-form">
	<div class="content">
		<input type="text" name="title" placeholder="Заголовок записи" class="input"> </br>
		<textarea rows=10 cols=70 name="record" placeholder="Текст записи" required class="input"></textarea>
		
	</div>
		<input type="submit" name="add_record" value="Записать" class="button"> </br>
	
<div align="center">

<?php

	// Вывод списка страниц
echo '<div  align="center">';
echo '<p>';
for ($page = 1; $page <= $num_pages; $page++)
{
    if ($page == $current_page)
    {
        echo '<strong>'.$page.'</strong> &nbsp;';
    }
    else
    {
        echo '<a href="records.php?page='.$page.'" class="pages">'.$page.'</a> &nbsp;';
    }
}
echo '</p>';
echo '</div>';
	
?>

<table class="table_price">
	
	<tr>
		<th>Запись</th>
		<th>Дата</th>
		<th colspan="2">Действия</th>
	</tr>
<?php

	if ($rowCount==0)
	{
		echo "Нет записей";
	}
		foreach ($result as $row) {
			echo "<tr>";
			echo "<input type=hidden name=idrecord value=".$row['id_record'].">";
			//echo "<td>{$row['title']}</td>";
			echo "<td><div class='spoiler_links'><strong>{$row['title']}</strong></div>";
			echo "<div class='spoiler_body'>{$row['content']}</div></td>";
			echo "<td>{$row['date_record']}</td>";
			echo "<td><a href='?delete={$row['id_record']}'>Удалить</a></td>";
			echo "<td><a href='changerecord.php?change={$row['id_record']}'>Изменить</a></td>";
			//echo "<td>","<input type=submit value='Постановочная группа' formaction=prdteam.php class=button>","</td>";
			echo "</tr>";

		}
		

?>
</table>
</div>


</form>

</div>

</body>
</html>	

	
