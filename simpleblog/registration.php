<?php 
//включить конфигурацию
require_once('includes/config.php');
?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Регистрация пользователя</title>
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

	<h1><a href="index.php">Blog</a></h1>

	<h2>Регистрация</h2>

	<?php

	//если форма была отправлена запустить ее
	if(isset($_POST['submit'])){

		//собрать форму данных
		extract($_POST);

		//очень простая проверка
		if($username ==''){
			$error[] = 'Пожалуйста введите логин.';
		}

		if($password ==''){
			$error[] = 'Пожалуйста введите пароль.';
		}

		if($passwordConfirm ==''){
			$error[] = 'Пожалуйста введите пароль повторно.';
		}

		if($password != $passwordConfirm){
			$error[] = 'Пароль не указан.';
		}

		if($email ==''){
			$error[] = 'Пожалуйста введите адрес почты.';
		}

		if(!isset($error)){

			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

			try {

				//обновление в базе данных
				$stmt = $db->prepare('INSERT INTO blog_members (username,password,email) VALUES (:username, :password, :email)') ;
				$stmt->execute(array(
					':username' => $username,
					':password' => $hashedpassword,
					':email' => $email
				));

				//перенаправить на страницу index
				header('Location: index.php?action=added');
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

		<p><label>Ваш Логин</label><br />
		<input type='text' name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>'></p>

		<p><label>Пароль</label><br />
		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'></p>

		<p><label>Подтверждение пароля</label><br />
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'></p>

		<p><label>Почта</label><br />
		<input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'></p>
		
		<p><input type='submit' name='submit' value='Зарегистрироваться'"<?php echo "checked";?>"></p>

	</form>

</div>