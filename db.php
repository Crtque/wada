<?php

	// Перед тем как писать информацию в базу
	// наладим соединение с сервером
	
	$db = mysqli_connect('localhost',
					'admin', 'yourpassword', 'main_db');
					
	// Устанавливаем кодировку соединения utf8
	mysqli_query($db, "SET NAMES utf8");

?>