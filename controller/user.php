<?php

function loadMailForm(){
    include_once "view/hero.html";
}

function index(){
	loadheader();
	loadmainpage();
	loadfooter();
}

function regFormLoad(){
    loadheader();
    include_once "view/user/regForm.php";
    loadfooter();
}


function infoUser(){

	include_once "model/user.php";
    $userID = newUserAction();
	if($userID[0]){
        //var_dump($userID[0]);
        userAuth($userID[0]);
        $textMail = regUserMailPrepare($userID['discountNum'], $userID['firstName'], $userID['pass']);
        sendUserMail($textMail, $userID['mail']);
        header("Refresh:2;url=".SITE."user/userFormLoad");
        loadheader();
        echo $userID[1];
        loadfooter();
    }
    else {
        header("Refresh:2;url=".SITE."user/regFormLoad");
        loadheader();
        echo $userID[1];
        loadfooter();
    }

	
}

function userFormLoad(){
	if ($_SESSION['status'] != 'user') header ("Location:".SITE);
	include_once("model/user.php");
	$discountData = getDisNum($_SESSION['auth']);
	$diallerData = getDiallerData($discountData);
	//var_dump($diallerData);
    $userName = getUserName($_SESSION['auth']);
    $price = getPriceData();
	loadheader();
	include_once ("view/user/userForm.php");
	loadfooter();
}

function createDis(){
	if ($_SESSION['status'] != 'user') header ("Location:".SITE);
	include_once("model/user.php");
	if(createNewDisc($_SESSION['auth'])){
		header ("Location:".SITE."user/userFormLoad");
	}
	else {
		header ("Refresh:2;url=".SITE."user/userFormLoad");
		loadheader();
		echo "Максимальное колличество неактивированных скидок - 3";
		loadfooter();
	}
	
}



function userAuthAction(){
	include_once("model/user.php");
        $idUser = getUserId();
        //var_dump($idUser);
        if($idUser){
            exitAuth();
            session_start();
            userAuth($idUser);
            if ($_SESSION['status'] == 'user'){
                userFormLoad();
            }
        }
        else {
			loadheader();
            echo "Ошибка авторизации";
			loadfooter();
        }
}

function exitAction(){
	include_once("model/user.php");
	exitAuth();
    header ("Location:/");
}

function changePassForm(){
    loadheader();
    include_once "view/user/changePassForm.php";
    loadfooter();
}

function changePass(){
    include_once("model/user.php");
    $result = changePassAction();
    if ($result){
        header ("Refresh:3;url=".SITE."user");
        loadheader();
        echo "Новый пароль был отправлен на Ваш E-mail";
        loadfooter();
    }
    else {
        header ("Refresh:3;url=".SITE."user");
        loadheader();
        echo "Не корректный E-mail";
        loadfooter();
    }

}
