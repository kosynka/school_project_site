<?php
//включить конфигурацию
require_once('../includes/config.php');

//выход пользователя
$user->logout();
header('Location: ../index.php'); 

?>