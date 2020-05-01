<?php require('includes/config.php');//включить конфигурацию ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Blog</title>
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

		<h1><a href="">Blog</a></h1>
		
		<p>
		<a href="registration.php"> Регистрация </a>
		</p>
		<a href="admin/login.php"> Войти </a>
				
		<hr />

		<?php
			try {

				$stmt = $db->query('SELECT postID, postTitle, postDesc, postDate FROM blog_posts ORDER BY postID DESC');
				while($row = $stmt->fetch()){
					
					echo '<div>';
						echo '<h1><a href="viewpost.php?id='.$row['postID'].'">'.$row['postTitle'].'</a></h1>';
						echo '<p>Был написан '.date('Y-m, время H:i:s', strtotime($row['postDate'])).'</p>';
						echo '<p>'.$row['postDesc'].'</p>';				
						echo '<p><a href="viewpost.php?id='.$row['postID'].'">Читать дальше</a></p>';				
					echo '</div>';

				}

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		?>
		<br>
    <a href="#top">Вверх</a>
	    <br>
	</div>


</body>
</html>
