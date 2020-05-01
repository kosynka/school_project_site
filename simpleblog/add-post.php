<?php 
//включить конфигурацию
require_once('includes/config.php');

//если не вошел в систему, перенаправить в страницу авторизации
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Добавить пост</title>
  <link rel="stylesheet" href="style/normalize.css">
  <link rel="stylesheet" href="style/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
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
	<p><a href="user-index.php">Блог Главная</a></p>

	<h2>Добавить пост</h2>

	<?php

	//если форма была отправлена запустить ее
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//собрать форму данных
		extract($_POST);

		//очень простая проверка
		if($postTitle ==''){
			$error[] = 'Пожалуйста введите заглавие';
		}

		if($postDesc ==''){
			$error[] = 'Пожалуйста введите описание';
		}

		if($postCont ==''){
			$error[] = 'Пожалуйста введите контент';
		}

		if(!isset($error)){

			try {

				//обновление в базе данных
				$stmt = $db->prepare('INSERT INTO blog_posts (postTitle,postDesc,postCont,postDate) VALUES (:postTitle, :postDesc, :postCont, :postDate)') ;
				$stmt->execute(array(
					':postTitle' => $postTitle,
					':postDesc' => $postDesc,
					':postCont' => $postCont,
					':postDate' => date('Y-m-d H:i:s')
				));

				//перенаправить на страницу index
				header('Location: user-index.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//проверить на ошибки
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<p><label>Заглавие</label><br />
		<input type='text' name='postTitle' value='<?php if(isset($error)){ echo $_POST['postTitle'];}?>'></p>

		<p><label>Описание</label><br />
		<textarea name='postDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postDesc'];}?></textarea></p>

		<p><label>Контент</label><br />
		<textarea name='postCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['postCont'];}?></textarea></p>

		<p><input type='submit' name='submit' value='Подтвердить'></p>

	</form>

</div>
