<?php
//включить конфигурацию
require_once('../includes/config.php');

//если не вошел в систему, перенаправить в страницу авторизации
if(!$user->is_logged_in()){ header('Location: login.php'); }

//показать сообщение с страницы добавления / редактирования
if(isset($_GET['deluser'])){ 

	//если идентификатор пользователя равен 1 игнорировать
	if($_GET['deluser'] !='1'){

		$stmt = $db->prepare('DELETE FROM blog_members WHERE memberID = :memberID') ;
		$stmt->execute(array(':memberID' => $_GET['deluser']));

		header('Location: users.php?action=deleted');
		exit;

	}
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Админ - Пользователи</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  <script language="JavaScript" type="text/javascript">
  function deluser(id, title)
  {
	  if (confirm("Вы уверены что хотите удалить '" + title + "'"))
	  {
	  	window.location.href = 'users.php?deluser=' + id;
	  }
  }
  </script>
  <style>
   body {
         background-image: url(../images/bg.jpg);
         background-size: 100% ;
		 
   }
  </style>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php 
	//показать сообщение с страницы добавления / редактирования
	if(isset($_GET['action'])){ 
		echo '<h3>User '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Логин пользователя</th>
		<th>Почта</th>
		<th>Действие</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT memberID, username, email FROM blog_members ORDER BY username');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['username'].'</td>';
				echo '<td>'.$row['email'].'</td>';
				?>

				<td>
					<a href="edit-user.php?id=<?php echo $row['memberID'];?>">Редактировать</a> 
					<?php if($row['memberID'] != 1){?>
						| <a href="javascript:deluser('<?php echo $row['memberID'];?>','<?php echo $row['username'];?>')">Удалить</a>
					<?php } ?>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-user.php'>Добавить пользователя</a></p>

</div>

</body>
</html>
