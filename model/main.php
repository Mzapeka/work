<?php

function index(){
	loadheader();
  	include_once("view/main/mainPageVeiw.php");
	include_once("view/main/navpanel.php");
	loadfooter();
}

function authForm(){
	loadheader();
	include_once "view/user/authform.php";
	loadfooter();
}

function authAction() {
	include_once "model/user.php";
	$data = authModel();
}

function regForm(){
	loadheader();
	include_once "view/user/regform.php";
	loadfooter();
}

function regAction(){
	include_once "model/user.php";
	$data = regModel();
	if($data[0]){
		header ("Refresh:3;url=http://dekupaj.in.ua");
	}
	else{
		header ("Refresh:3;url=http://dekupaj.in.ua/user/regForm");
	}
	loadheader();
	include_once "view/user/regFormResult.php";
	loadfooter();
	
}
