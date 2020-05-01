<?php require('includes/config.php'); 

$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();

//если пост не существует перенаправить пользователя
if($row['postID'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['postTitle'];?></title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
	<style>
   body {
         background-image: url(images/bg.jpg);
         background-size: 100% ;
		 
   }
  </style>
</head>
<body>

	<div id="wrapper">

	<a href="index.php" >
	<h1>Blog</h1>
	</a>
		<hr />
		<p><a href="./">Блог главная страница</a></p>


		<?php	
			echo '<div>';
				echo '<h1>'.$row['postTitle'].'</h1>';
				echo '<p>Posted on '.date('jS M Y', strtotime($row['postDate'])).'</p>';
				echo '<p>'.$row['postCont'].'</p>';				
			echo '</div>';
		?>
    <a href="#top">Вверх</a>
	</div>

</body>
</html>