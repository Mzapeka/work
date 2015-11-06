<?php

function loadPage(){

	if ($_COOKIE['status']){
		
		$_SESSION['auth'] = $_COOKIE['auth'];
		$_SESSION['status'] = $_COOKIE['status'];
        $_SESSION['diallerStatus'] = $_COOKIE['diallerStatus'];
	}
    $url = $_SERVER['REQUEST_URI'];
    $url = preg_replace("/\?.*$/", "", $url);
    $array = explode("/", $url);
    if (!$array[1]) {
        $array[1] = "main";
    }
    elseif ($array[1] == 'dialler') {
        if ($_SESSION['status'] != 'dialler'){
            if($array[2] == 'regForm' | $array[2] == 'registration' |
                $array[2] == 'diallerAuth' |
                $array[2] == 'fogotDilPass' |
                $array[2] == 'recallDilPass' |
                $array[2] == 'changePassForm' |
                $array[2] == 'changePass'){
            }
            else {
                $array[1] = "main";
            }
    }
    }
    elseif ($array[1] == 'admin'){
        if ($_SESSION['status'] != 'adm'){
            if ($array[2] == 'diallerConfirmation' |
                $array[2] == 'audit' |
                $array[2] == 'adminAuth'
            ){

            }
            else {
                $array[1] = "main";
            }
        }
    }
	$fileName = "controller/".$array[1].".php";
   	if (file_exists($fileName)){
		include_once($fileName);
		$functionName = $array[2];
		if (!$functionName) $functionName = "index";
		//if (($functionName != 'authForm' & $functionName != 'regForm' & $functionName != 'authAction' & $functionName != 'regAction') & !$_SESSION['auth']) $functionName = "index"; // если не регистрация и авторизация - перенаправляет на главную
		//var_dump ($functionName);
		if (function_exists($functionName)){
			$functionName(); //визов функции с именем, которое записано в массиве $array[2]
		}
		else {
			$functionName = "index";
			$functionName();
			//echo "404";
		}
	}
	else {
		//echo "404";
            loadheader();
            loadmainpage();
            loadfooter();
    }
  }


?>