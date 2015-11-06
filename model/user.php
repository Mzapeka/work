<?php

function getDisNum($idUser){
    global $db;
	if(!$_SESSION['status'] == 'user') die;
	$tableName = 'discount';
	$value = ['idUser' => $idUser];
	$items = $db->select($tableName, $fildName = false, $value);
	return $items;
}

function getPriceData(){
    $priceData = unserialize(file_get_contents('system/price.php'));
    $priceUa['ua'] = round(($priceData['esi'] + $priceData['kts']) * $priceData['kurs'], 2);
    $priceUa['discount'] = round($priceUa['ua']*0.03, 2);
    return $priceUa;
}

function getUserName($idUser){
    global $db;
    $user = $db->select('users', 'firstName', ['idUser' => $idUser]);
    $userName = $user[0]['firstName'];
    //var_dump($userName);
    return $userName;
}

function getDiallerData($arrayNum){
    global $db;
    if ($arrayNum){
		$userData = null;
		foreach ($arrayNum as $row){
			$diallerData[] = $db->select('dillers', false, ['idDiller' => $row['idDiller']]);
		}
		return $diallerData;
	}
	return false;
}

function getUserId(){
    global $db;
	$request = ["mail" => $_POST['login'], "pass" => $_POST['password']];
	$user = $db->select("users", false, $request);
	if ($user){
		$result = $user[0]['idUser'];
	}
	else{
		$result = false;
	}
	Return($result);
}

function userAuth($userId){
	$_SESSION['auth'] = $userId;
	$_SESSION['status'] = 'user';
	if ($_POST['rememberMe'] == "on"){
		setcookie("auth", $userId, time()+1200, '/');
		setcookie("status", 'user', time()+1200, '/');
	}
}

function exitAuth(){
		session_destroy();
	if ($_COOKIE['auth']){
		setcookie("auth", $_COOKIE['auth'], time()-120, '/');
		setcookie("status", $_COOKIE['status'], time()-120, '/');
	}
}


function createNewDisc($idUser){
    global $db;
	//проверка количества записей
	$sql = "SELECT COUNT(`discountNum`) FROM `discount` WHERE `idUser` = :iduser AND `idDiller` IS NULL";
    $mask = [":iduser" => $idUser];
	$count = $db->sendQuery($sql, $mask);
	//var_dump ($sql);
	//var_dump ($count[0]['COUNT(`discountNum`)']);
	if ($count[0]['COUNT(`discountNum`)'] > 2) return false;
	$discNum = genIdNum(6);
	$values = [
		'discountNum' => $discNum,
		'idUser' => $idUser
	];
	$tableName = 'discount';
	$db->insert($tableName, $values);
	return true;
}


function newUserAction(){
    global $db;
	$regUser = regUser();
	//var_dump ($regUser);

	if (!$regUser[0]){
		return $regUser;
	}
	else {
		$discNum = genIdNum(6);
		$values = [
			'discountNum' => "$discNum",
			'idUser' => "$regUser[0]"
			];
		$tableName = 'discount';
		$db->insert($tableName, $values);
        $regUser += ['discountNum' => "$discNum"];
        return $regUser;
	}
}

function regUser(){
    global $db;
	$tableName = 'users';
// проверки введенных данных
	$phonePattern = "/^\+[0-9]{12}$/";
	$emailPattern = "/^[\w.]+@?([\w.]+)$/";

	if (!preg_match($emailPattern, $_POST['email'])){
		$result = [false, "Введите корректный адресс Email"];
		return $result;
	}
	else {
		$mail = $_POST['email'];
	}

	if ($db->select($tableName, "mail", ['mail' => $mail])){
		$result = [false, "Такой e-mail уже зарегистрирован"];
		return $result;
	}

	if (!preg_match($phonePattern, $_POST['phone'])) {
			$result = [false, "Введите номер телефона в формате +380442561565"];
			return $result;
	}
	else {
		$phone = $_POST['phone'];
	}
    $pass = genIdNum(8);
	$firstName = $_POST['first_name'];
	$lastName = $_POST['last_name'];
	$city = $_POST['city'];
    $idUser = genIdNum(8);
		// запросы на добавление в базу
		$values = [
            'idUser' => "$idUser",
			'mail' => "$mail",
			'pass' => "$pass",
			'firstName' => "$firstName",
			'lastName' => "$lastName",
			'phone' => "$phone",
			'city' => "$city"
		];
        $error = $db->insert($tableName, $values);
        //var_dump($lastID);
		if($error[0]){
			$result = [false, "Ошибка записи"];
			return $result;
		}
		//$reqUserLogin = "INSERT INTO `user_login` (`idUser`, `email`, `pass`, `createData`)
		//VALUES ('".$NewIndexUserLogin."','".$_POST['email']."', '".$_POST['pass']."', (NOW()))";
		$result = [$idUser, "Вы успешно зарегистрированы! Через 2 секунды вы будете переадресованы на Вашу личную страницу",
                'firstName' => "$firstName", 'mail' => "$mail", 'pass' => "$pass"];
		return $result;

}

function regUserMailPrepare($discount, $userName, $userPass){
    //загрузка шаблона письма
   $tempText = file_get_contents("view/user/mailForm.php");
    //подстановка данных пользователя в шаблон
    $patternArray = ['/#name#/', '/#discount#/', '/#site#/', '/#pass#/'];
    $ReplaceArray = ["$userName", "$discount", SITE, "$userPass"];
    $preparedFile = preg_replace($patternArray, $ReplaceArray, $tempText);
    return $preparedFile;
}

function sendUserMail($textMail, $recipientMail, $subject = "Код скидки на покупку KTS Unlimited"){
    include_once "system/Mail.php";
    $mail = new Mail(ADMINMAIL); // Создаём экземпляр класса
    $mail->setFrom(ADMINMAIL);
	//$mail->setSmtpServer("ssl://smtp.gmail.com");
	//$mail->setSmtpPort(465);
    $mail->setSmtpLogin("bosch.adw@gmail.com");
    $mail->setSmtpPass("Bosch2015");
    $mail->setFromName("KTS Unlimited"); // Устанавливаем имя в обратном адресе
    $result = $mail->smtpSend($recipientMail, $subject, $textMail);
    if ($result[0]) {
        return true;
    }
    else {
        return false;
    }
}

function changePassAction(){
    global $db;
    if (!$idExist = $db->select('users', false, ['mail' => $_POST['email']])){
        return false;
    }
    $newPass = genIdNum(6);
    $db->update('users', ['pass' => $newPass], ['idUser', $idExist[0]['idUser']]);

    $tempText = file_get_contents("view/user/mailRecallPass.php");
    //подстановка данных пользователя в шаблон
    $patternArray = ['/#name#/', '/#site#/', '/#pass#/'];
    $replaceArray = [$idExist[0]['firstName'], SITE, $newPass];
    $preparedFile = preg_replace($patternArray, $replaceArray, $tempText);
    $result = sendUserMail($preparedFile, $_POST['email'], $subject = "Восстановление пароля");
    return $result;

}