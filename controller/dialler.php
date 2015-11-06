<?php

function index(){
    loadheader();
    loadmainpage();
    loadfooter();
}


function regForm(){
	loadheader();
	include_once("view/dialler/regForm.php");
	loadfooter();
}

function registration()
{
    include_once("model/dialler.php");
    $regResult = createDialler();
    if ($regResult[0]) {
        sendConfRequest($regResult);
        exitAuthDil();
        session_start();
        diallAuth($regResult[0]);
        loadheader();
        $discountData = getDisNumDil($regResult[0]);
        $userData = getUserData($discountData);
        include_once("view/dialler/mainForm.php");
        loadfooter();
    } else {
        header("Refresh:2;url=" . SITE . "dialler/regForm");
        loadheader();
        echo $regResult[1];
        loadfooter();
    }
}

function mainFormLoad(){
    global $db;
	if ($_SESSION['status'] != 'dialler') header ("Location:".SITE);
	include_once("model/dialler.php");
	loadheader();
    $cheackActivation = $db->select("dillers", "status", ['idDiller' => $_SESSION['auth']]);
    if (!$_SESSION['diallerStatus'] & $cheackActivation[0]['status']){
        diallAuth($_SESSION['auth']);
    }
	$discountData = getDisNumDil($_SESSION['auth']);
	$userData = getUserData($discountData);
	include_once ("view/dialler/mainForm.php");
	loadfooter();
}

function diallerAuth(){

    include_once("model/dialler.php");
    $idDialer = getDiallerId();
    if ($idDialer){
        exitAuthDil();
        session_start();
        diallAuth($idDialer);
        if ($_SESSION['status'] == 'dialler'){
            loadheader();
            $discountData = getDisNumDil($_SESSION['auth']);
            $userData = getUserData($discountData);
            include_once ("view/dialler/mainForm.php");
            loadfooter();
        }
    }
	else {
        loadheader();
		echo "Ошибка авторизации";
        loadfooter();
	}
}

function activateAction(){
	if ($_SESSION['status'] != 'dialler') header ("Location:".SITE);
	include_once("model/dialler.php");
		//var_dump($_SESSION['auth']);
        $error = discActivate($_SESSION['auth']);
		if(!$error){
			header ("Refresh:2;url=".SITE."dialler/mainFormLoad");
            loadheader();
			echo "Код успешно активирован";
            loadfooter();
		}
		else {
			header ("Refresh:2;url=".SITE."dialler/mainFormLoad");
            loadheader();
			echo $error;
            loadfooter();
		}
	//header ("Refresh:1;url=".SITE."dialler/mainFormLoad");
}

function exitAction(){
	include_once("model/dialler.php");
    exitAuthDil();
	header ("Location:/");

}

function fogotDilPass(){
    loadheader();
    include_once("view/dialler/forgotPassForm.php");
    loadfooter();
}

function recallDilPass(){
    include_once("model/dialler.php");
    $result = recallDilPassAction();
    if ($result) {
        header ("Refresh:2;url=".SITE."dialler");
        loadheader();
        echo "Запрос на изменение пароля выслан на Ваш E-mail";
        loadfooter();
    }
    else {
        header ("Refresh:2;url=".SITE."dialler");
        loadheader();
        echo "Введен ошибочный E-mail";
        loadfooter();
    }
}

function changePassForm(){
    loadheader();
    include_once("view/dialler/changePassForm.php");
    loadfooter();
}

function changePass(){
    include_once("model/dialler.php");
    $result = changePassAction();
    if ($result[0]) {
        header ("Refresh:2;url=".SITE."dialler");
        loadheader();
        echo $result[1];
        loadfooter();
    }
    else {
        header ("Refresh:2;url=".SITE."dialler/");
        loadheader();
        echo $result[1];
        loadfooter();
    }

}

