<!DOCTYPE html>
<?php
setlocale(LC_ALL, 'ru_RU.utf8');
Header("Content-Type: text/html;charset=UTF-8");
	session_start();
	// eсли запрашиваетс¤ выход из сайта, перегенерируем session_id
	if($_GET['page'] == 'exit'){
		session_regenerate_id();
        session_destroy();
		header("location:index.php");
	}
	
  include('db.php');
?>

 

<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>WADA - Verificator</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	<link rel="shortcut icon" href="https://banner2.kisspng.com/20180504/cwq/kisspng-computer-icons-globe-icon-5aec89fa2a7194.7562561815254512581739.jpg" type="image/x-icon">
	<style>
		body {background-image: url(./background.jpg);}
		table { border-collapse: collapse; width: 100%; cursor: default; }
		th, td { border-right: none; border-bottom: 1px solid black; padding: 10px; border-color: #00BFFF;}
		legend {cursor: default;}
		details[open] {outline: 0 !important;}
		.info tr:hover { background-color: lightgrey; }
		.users th:not(:first-child), .users td:not(:first-child) { text-align: center; width: 47%;}
		.users td { padding: 10px; }
		i:hover {text-decoration: underline;}
		.overlay {
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			z-index: 10;
			display: none;
			background-color: rgba(0, 0, 0, 0.65);
			position: fixed;
			cursor: default;
		}
		 
		.overlay:target {
			display: block;
		}
		 
		.overlay:target+.popup, .overlay:target+.photo_change {
			-webkit-transform: translate(-50%, 0);
			-ms-transform: translate(-50%, 0);
			-o-transform: translate(-50%, 0);
			transform: translate(-50%, 0);
			top: 20%;
		}
		.exit{
			    display: inline-block;
    padding: 8px;
    border: 2px solid #C38438;
    background: #C3B438;
    border-radius: 6px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2), inset 0 2px 1px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    font-size: 14px;
    text-transform: uppercase;
    color: white!important;
		}
		.exit:hover{
		    display: inline-block;
    padding: 8px;
    border: 2px solid #C3B438;
    background: #C38438;
    border-radius: 6px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2), inset 0 2px 1px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    font-size: 14px;
    text-transform: uppercase;
    color: white!important;
		}
		
		.close {
			top: -10px;
			right: -10px;
			width: 20px;
			height: 20px;
			position: absolute;
			padding: 0;
			border: 2px solid #ccc;
			-webkit-border-radius: 15px;
			-moz-border-radius: 15px;
			-ms-border-radius: 15px;
			-o-border-radius: 15px;
			border-radius: 15px;
			background-color: rgba(61, 61, 61, 0.8);
			-webkit-box-shadow: 0px 0px 10px #000;
			-moz-box-shadow: 0px 0px 10px #000;
			box-shadow: 0px 0px 10px #000;
			text-align: center;
			text-decoration: none;
			font: 13px/20px 'Tahoma', Arial, sans-serif;
			font-weight: bold;
			-webkit-transition: all ease .8s;
			-moz-transition: all ease .8s;
			-ms-transition: all ease .8s;
			-o-transition: all ease .8s;
			transition: all ease .8s;
		}
		 
		.close:before {
			color: rgba(255, 255, 255, 0.9);
			content: "X";
			text-shadow: 0 -1px rgba(0, 0, 0, 0.9);
			font-size: 12px;
		}
		 
		.close:hover {
			background-color: rgba(252, 20, 0, 0.8);
			-webkit-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-ms-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	</style>
</head>
<body>
<div class="tired">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100" style="
    background-color: #343A87!important;
    box-shadow: 0 0 20px 17px rgba(0,0,0,.35);">
      <div class="container" style="color:white"><a class="navbar-brand mb-0 h1" href="./" title="">WADA - Verificator</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
		<?php if($_POST['auth']){
		
		$nick = $_POST['nick'];
		$pass = $_POST['pass'];
		
		// Делаем запрос в БД на предмет того, есть пользователь
		// с указанным ником и паролем или нет
		$z = "
			SELECT
			  * FROM
			  users
			  WHERE login = '$nick' AND pass = '".SHA1($pass)."'";
			  
		
		$rz = mysqli_query($db, $z);
		
		if(mysqli_num_rows($rz) > 0){
			
			// Получим из запроса id пользователя, чтобы
			// сохранить его в сессии
			
			$row = mysqli_fetch_object($rz);
			$_SESSION['user_id'] = $row->id;
            
                        
			// Чтобы сервер помнил клиента, зашедшего на сайт
			// под правильным ником и паролем, сохраняем его ник
			// в сессии
			$_SESSION['nick'] = $nick;
			header("Location: ./index.php");
		}else{
			// Такого юзера нет, показываем форму входа на сайт
			// с сообщением об ошибке аутентификации
			echo "<div style='color:red'>Ник или пароль указаны неверно.
				  Попробуйте еще раз.</div><br>";
		}
	}
		
		if($_SESSION['nick'])echo '<ul class="navbar-nav mr-auto "><li class="nav-item">
              <a class="nav-link exit" style="color: rgba(255,255,255,1);" href="./?page=exit">Выйти из аккаунта ('.$_SESSION['nick'].')</a>
            </li> </ul>'; ?>
        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto"><li class="nav-item active">
             </ul></div>
      </div>
    </nav>
    <div class="d-inline-flex mt-5 ml-3" style="width: 100%;">
    	
<div style="width:32%;height:100%"> </div>
	<?php 
	
	if(!$_SESSION['nick']){ echo '<div class="container col-4 border rounded p-4 px-5 my-5 ml-5 shadow-sm vcenter" style="align-content:center; background: #343A87;color:white">
			<h1 class="text-center">Авторизация</h1>';
		
	// Определим была ли нажата кнопка Войти

	echo '	<form method="POST" action="">
	<input
    	type="text" name="nick"
    	class="textinput textInput form-control" placeholder="Имя пользователя"    
    />

	<input
    	type="password" name="pass"
    	class="textinput textInput form-control" placeholder="Пароль"      
    
    />
    
    <input
    	type="submit" name="auth" class ="btn btn-outline-dark mt-2 exit" value="Войти"
    
    />

</form>'; }else{ if(!$_GET['type']){
				echo '<div class="container col-4 border rounded p-4 px-5 my-5 ml-5 shadow-sm vcenter" style="align-content:center; background: #343A87;color:white">
			<h1 class="text-center">Выберите возможность</h1>	<form method="GET" action="./">

			<input type="submit" name="type" class="btn btn-outline-dark mt-2 exit" value="Добавить результат">
			<input type="submit" name="type" class="btn btn-outline-dark mt-2 exit" value="Проверить">
			<a class="btn btn-outline-dark mt-2 exit" href="check.php">Проверка БД</a>
		</form>
		</div>';
			}else if($_GET['type']=="Проверить"){
				echo '<div class="container col-4 border rounded p-4 px-5 my-5 ml-5 shadow-sm vcenter" style="align-content:center; background: #343A87;color:white">
			<h1 class="text-center">Посмотреть результат</h1>	<form method="POST" action="./?type=Проверить">
	<input type="text" name="sname" class="textinput textInput form-control" placeholder="Фамилия">
	<input type="text" name="name" class="textinput textInput form-control" placeholder="Имя">
    <input type="text" name="lname" class="textinput textInput form-control" placeholder="Отчество">
    <input type="submit" name="check" class="btn btn-outline-dark mt-2 exit" value="Проверить">

</form>';
			if($_POST['check']){
				$name = $_POST['name'];
				$sname = $_POST['sname'];
				$lname = $_POST['lname'];
				if($_POST['lname']){
					$z = "SELECT * FROM `hashs` WHERE sname='$sname' AND name='$name' AND lname='$lname'";
				}else{
					$z = "SELECT * FROM `hashs` WHERE sname='$sname' AND name='$name'";
				}
				
		
		$rz = mysqli_query($db, $z);
		
		if(mysqli_num_rows($rz) == 1){
			echo "Найден один результат:<br>";
			 while ($row = $rz->fetch_assoc()) {
				printf ("<a href='./result.php?id=%s'>%s %s %s</a><br>\n", $row["id"], $row["sname"],$row["name"],$row["lname"]);
			}
		}else if(mysqli_num_rows($rz) > 0){
			
			// Получим из запроса id пользователя, чтобы
			// сохранить его в сессии
			echo "Найдено больше одного результата:<br>";
			 while ($row = $rz->fetch_assoc()) {
				printf ("<a href='./result.php?id=%s'>%s %s %s</a><br>\n", $row["id"], $row["sname"],$row["name"],$row["lname"]);
			}

		}else{
			echo "Результаты не найдены<br>";
		}
			}
			echo '</div>';
			}else if($_GET['type']=="Добавить результат"){
				echo '<div class="container col-4 border rounded p-4 px-5 my-5 ml-5 shadow-sm vcenter" style="align-content:center; background: #343A87;color:white">
			<h1 class="text-center">Добавить результаты</h1>	<form method="POST" action="./?type=Добавить+результат">
	<input type="text" name="sname" class="textinput textInput form-control" placeholder="Фамилия">
	<input type="text" name="name" class="textinput textInput form-control" placeholder="Имя">
    <input type="text" name="lname" class="textinput textInput form-control" placeholder="Отчество">
	<input type="text" name="blood" class="textinput textInput form-control" placeholder="Результаты крови">
	<input type="text" name="urina" class="textinput textInput form-control" placeholder="Результаты мочи">
    <input type="submit" name="add" class="btn btn-outline-dark mt-2 exit" value="Добавить">

</form>';
			if($_POST['add']){
				$z = "
			SELECT * FROM `hashs` ORDER BY `id` DESC LIMIT 0,1 
			  	
		";
		
		$rz = mysqli_query($db, $z);
		
		if(mysqli_num_rows($rz) > 0){
			
			// Получим из запроса id пользователя, чтобы
			// сохранить его в сессии
			
			$row = mysqli_fetch_object($rz);
			$lastid = $row->id;
			$prev = $row->hash;
		}
				$arr = array('id' => $lastid, 'sname' => $_POST['sname'], 'name' => $_POST['name'], 'lname' => $_POST['lname'], 'blood' => $_POST['blood'],'urina' => $_POST['urina'],'prev'=>$prev, 'time'=>date('d-m-Y H:i:s'), 'ip'=>$_SERVER["REMOTE_ADDR"]);
				$jsarr=json_encode($arr);
				
				$ch = curl_init();

// установка URL и других необходимых параметров
curl_setopt($ch, CURLOPT_URL, "10.177.0.218:9191/storage");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Originator-Ref: 0xaaaEEC4e25c011deA7fBb53fa9C59d08960C9d1c', 'Content-Length: ' . strlen($jsarr)));     
    
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsarr); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); 
// загрузка страницы и выдача её браузеру
$output = curl_exec($ch);  
$jo=json_decode($output, true);
$hash = $jo['ref_id'];
$name=$_POST['name'];
$sname=$_POST['sname'];
$lname=$_POST['lname'];
$ip=$_SERVER["REMOTE_ADDR"];
$q = "INSERT INTO hashs (`name`,`sname`,`lname`,`hash`,`ip`) VALUES('$name','$sname','$lname','$hash','$ip')";
$rq = mysqli_query($db, $q);
echo "Результаты анализов успешно добавлены";
// завершение сеанса и освобождение ресурсов
curl_close($ch);
			}
			echo '</div>';
			}
		}
		?>
		</div>
	</div>
</div>
</body>
</html>
