<?php 
//включить конфигурацию
require_once('../includes/config.php');

//если не вошел в систему, перенаправить в страницу авторизации
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Админ - Редактировать пользователя</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
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
	<p><a href="users.php">Админ Главное</a></p>

	<h2>Редактировать Пользователя</h2>


	<?php

	//если форма была отправлена запустить ее
	if(isset($_POST['submit'])){

		//собрать форму данных
		extract($_POST);

		//очень простая проверка
		if($username ==''){
			$error[] = 'Пожалуйста введите логин';
		}

		if( strlen($password) > 0){

			if($password ==''){
				$error[] = 'Пожалуйста введите пароль';
			}

			if($passwordConfirm ==''){
				$error[] = 'Пожалуйста повторно введите пароль';
			}

			if($password != $passwordConfirm){
				$error[] = 'Пароль не указан';
			}

		}
		

		if($email ==''){
			$error[] = 'Пожалуйста введите email адрес';
		}

		if(!isset($error)){

			try {

				if(isset($password)){

					$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

					//обновление в базе данных
					$stmt = $db->prepare('UPDATE blog_members SET username = :username, password = :password, email = :email WHERE memberID = :memberID') ;
					$stmt->execute(array(
						':username' => $username,
						':password' => $hashedpassword,
						':email' => $email,
						':memberID' => $memberID
					));


				} else {

					//обновить базу данных
					$stmt = $db->prepare('UPDATE blog_members SET username = :username, email = :email WHERE memberID = :memberID') ;
					$stmt->execute(array(
						':username' => $username,
						':email' => $email,
						':memberID' => $memberID
					));

				}
				

				//перенаправить на страницу index
				header('Location: users.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//проверить на ошибки
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT memberID, username, email FROM blog_members WHERE memberID = :memberID') ;
			$stmt->execute(array(':memberID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>

		<p><label>Логин пользователя</label><br />
		<input type='text' name='username' value='<?php echo $row['username'];?>'></p>

		<p><label>Пароль (только для изменений)</label><br />
		<input type='password' name='password' value=''></p>

		<p><label>Потдвердить пароль</label><br />
		<input type='password' name='passwordConfirm' value=''></p>

		<p><label>Почта</label><br />
		<input type='text' name='email' value='<?php echo $row['email'];?>'></p>

		<p><input type='submit' name='submit' value='Изменить'></p>

	</form>

</div>

</body>
</html>	
