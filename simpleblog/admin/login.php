<?php
//включить конфигурацию
require_once('../includes/config.php');

//проверить если уже вошел
if( $user->is_logged_in() ){ 
session_start();
if($_SESSION['sess_memberID'] == "1"){
    header('Location: index.php');	
} else{
	header('Location: ../user-index.php');
}

} 
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Вход</title>
  <link rel="stylesheet" href="../style/normalize.css">
  <link rel="stylesheet" href="../style/main.css">
  
    <style type="text/css">
   h1 { 
	margin-top: 1.5%;
	padding-left: 17%;
	width: 20px;

   }

   body {
         background-image: url(../images/bg.jpg);
         background-size: 100% ;
		 
   }
  </style>
</head>
<body>

<div>
	<a href="../" target="_blank">
	<h1>Blog</h1>
	</a>

</div>

<div id="login">

	<?php

	//обрабатывать регистрационную форму, если она представлена
	if(isset($_POST['submit'])){

		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		if($user->login($username,$password)){ 

			//перенаправить на страницу index пользователя, после входа
			header('Location: ../user-index.php');
			exit;
		

		} else {
			$message = '<p class="error">Неправильный логин или пароль</p>';
		}

	}//закончить если подтвердил

	if(isset($message)){ echo $message; }
	?>

	<form action="" method="post">
	<p><label>Логин</label><input type="text" name="username" value=""  /></p>
	<p><label>Пароль</label><input type="password" name="password" value=""  /></p>
	<p><label></label><input type="submit" name="submit" value="Войти"  /></p>
	    <input type="checkbox" checked="checked"> Запомнить меня
	</form>

</div>
</body>
</html>
