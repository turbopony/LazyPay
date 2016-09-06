<?php
error_reporting(E_NONE); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.
	function DelDir($dir)   
	{  
		//если не открыть директорию  
		if (!$dd = opendir($dir)) return false;  
		  
		//читаем директорию в цикле  
		while (false !== ($obj = readdir($dd)))  
		{  
			//пропускаем системные каталоги  
			if($obj=='.' || $obj=='..') continue;  
			  
			//пробуем удалить объект, если это не удается, то применяем функцию к этому объекту вновь 
			if (!@unlink($dir.'/'.$obj)) DelDir($dir.'/'.$obj);  
		}  
		closedir($dd);  
		  
			//удаляем пустую директорию  
			@rmdir($dir);  
	}
$db_config_path = '../application/config/database.php';
// Only load the classes in case the user submitted the form
if($_POST) {

	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');

	$core = new Core();
	$database = new Database();


	// Validate the post data
	if($core->validate_post($_POST) == true)
	{

		// First create the database, then create tables, then write config file
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"Не удалось создать базу данных!");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"Не удалось создать таблицы в базе данных!");
		} else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"Файл конфигурации БД не можеть быть записан, убедитесь что chmod application/config/database.php равен 777");
		} else if ($core->write_scconf($_POST) == false) {
			$message = $core->show_message('error',"Файл конфигурации скрипта не можеть быть записан, убедитесь что chmod application/config/config.php равен 777");
		}

		// If no errors, redirect to registration page
		if(!isset($message)) {
			$redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
			$redir .= "://".$_SERVER['HTTP_HOST'];
			$redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
			$redir = str_replace('install/','',$redir); 
			DelDir('../install/');
			echo "<script>
			alert('Вы будете перемещены на страницу входа в админ-панель. \\r\\n\\ После входа, обязательно настройте скрипт в соотвествующем разделе!');
			window.location.href='".$redir."/admin/';
			</script>";;
			}

	}
	else {
		$message = $core->show_message('error','Все поля обязательны к заполнению!');
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Установка </title>
		<link href='../assets/css/bootstrap.min.css' rel="stylesheet" media="screen">
		<script src="http://code.jquery.com/jquery.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
	</head>
	<body>


    <?php if(is_writable($db_config_path)){?>

		<div class="container"><h1>Install</h1>
			<div class="row">
				<div class="col-lg-4 col-offset-4">
				 <?php if(isset($message)) {echo '<div class="alert alert-danger">' . $message . '</div>';}?>
				  <form id="install_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<fieldset>
					  <legend></legend>
					  <div class="form-group"><label for="hostname">Hostname</label><input type="text" id="hostname" value="localhost" class="form-control" name="hostname" /></div>
					  <div class="form-group"><label for="username">Логин</label><input type="text" id="username" class="form-control" name="username" /></div>
					  <div class="form-group"><label for="password">Пароль</label><input type="password" id="password" class="form-control" name="password" /></div>
					  <div class="form-group"><label for="database">Имя БД</label><input type="text" id="database" class="form-control" name="database" /></div>
					</fieldset>
					<fieldset>
					  <legend>Настройки входа в админ-панель</legend>
					  <div class="form-group"><label for="useremail">E-mail</label><input type="text" id="useremail" class="form-control" name="useremail" /></div>
					  <div class="form-group"><label for="userpass">Пароль</label><input type="password" id="userpass" class="form-control" name="userpass" /></div>
					  
					</fieldset>
					<input type="submit" class="btn btn-primary pull-right" value="Установить" id="submit" />
				  </form>
				</div>
			</div> Слив и расшифровка <a href ='http://andrey69rus.ru'>andrey69rus</a>
		</div>
	  <?php }?>

	</body>

</html>