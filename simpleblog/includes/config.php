<?php
ob_start();
session_start();

//данные о Базе данных
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','simple');

$db = new PDO('mysql:host=localhost;dbname='.DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//выбор временной зоны
date_default_timezone_set('Asia/Almaty');

//загрузка нужных классов
function __autoload($class) {
   
   $class = strtolower($class);

	//если вызов изнутри меняет путь
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 	
	
	//если вызов изнутри администратора настраивает путь
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}
	
	//если вызов изнутри администратора настраивает путь
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 		
	 
}

$user = new User($db); 
?>
