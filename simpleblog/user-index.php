<?php
//включить конфигурацию
require_once('includes/config.php');

//если не вошел в систему, перенаправить в страницу авторизации
if(!$user->is_logged_in()){ header('Location: login.php'); }

//показать сообщение с страницы добавления / редактирования
if(isset($_GET['delpost'])){ 

	$stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));

	header('Location: user-index.php?action=deleted');
	exit;
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Пользователь</title>
  <link rel="stylesheet" href="style/normalize.css">
  <link rel="stylesheet" href="style/main.css">
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title)
  {
	  if (confirm("Вы точно хотите удалить пост '" + title + "'"))
	  {
	  	window.location.href = 'user-index.php?delpost=' + id;
	  }
  }
  </script>
  <style>
   body {
         background-image: url(images/bg.jpg);
         background-size: 100% ;
		 
   }
  </style>
</head>
<body>

	<div id="wrapper">

	<?php include('user-menu.php');?>

	<?php 
	//показать сообщение с страницы добавления / редактирования
	if(isset($_GET['action'])){ 
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Заглавие</th>
		<th>Дата</th>
		<th>Действие</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT postID, postTitle, postDate FROM blog_posts ORDER BY postID DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['postTitle'].'</td>';
				echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
				?>

				<td>
					<a href="edit-post.php?id=<?php echo $row['postID'];?>">Редактировать</a> | 
					<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Удалить</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='add-post.php'>Добавить пост</a></p>

</div>

</body>
</html>
