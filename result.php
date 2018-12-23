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
		 		.exit{
			    display: inline-block;
    padding: 8px;
    border: 3px solid #C38438;
    background: #C3B438;
    border-radius: 6px;
    box-shadow: 0 2px 1px rgba(0, 0, 0, 0.2), inset 0 2px 1px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    font-size: 14px;
    text-transform: uppercase;
    color: white!important;
		}
		.exit:hover{
		    display: inline-block;
    padding: 8px;
    border: 3px solid #C3B438;
    background: #C38438;
    border-radius: 6px;
    box-shadow: 0 2px 1px rgba(0, 0, 0, 0.2), inset 0 2px 1px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    font-size: 14px;
    text-transform: uppercase;
    color: white!important;
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
		<?php if($_SESSION['nick'])echo '<ul class="navbar-nav mr-auto"><li class="nav-item">
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
			if($_SESSION['nick']){
				if(!$_GET['id']){
					echo '<div class="container col-4 border rounded p-4 px-5 my-5 ml-5 shadow-sm vcenter" style="align-content:center; background: #343A87;color:white">
							<h1 class="text-center">Нет идентификатора</h1>
							</div>';
				}else{

							$id = $_GET['id'];
					$q = "SELECT * FROM hashs WHERE id ='$id'";
					$rz = mysqli_query($db,$q);
					if(mysqli_num_rows($rz) > 0){			
				$row = mysqli_fetch_object($rz);
				}
                        
			// Чтобы сервер помнил клиента, зашедшего на сайт
			// под правильным ником и паролем, сохраняем его ник
			// в сессии

					$ch = curl_init();

// установка URL и других необходимых параметров
curl_setopt($ch, CURLOPT_URL, "http://10.177.0.218:9191/storage/".$row->hash);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); 
// загрузка страницы и выдача её браузеру
$answ=curl_exec($ch);
$jo=json_decode($answ, true);
echo '<div class="container col-4 border rounded p-4 px-5 my-5 ml-5 shadow-sm vcenter" style="align-content:center; background: #343A87;color:white">
							<h1 class="text-center">'.$jo['sname'].' '.$jo['name'].' '.$jo['lname'].'</h1>';

echo "Результаты крови: " . $jo['blood'];
echo "<br>Результаты мочи: " . $jo['urina'];
echo "<br>Дата добавления: " . $jo['time'];

curl_close($ch);
							
							echo '</div>';
				}
			}
		?>
		</div>
	</div>
</div>
</body>
</html>