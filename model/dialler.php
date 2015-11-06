<?php

function getDisNumDil($idDialler){
	global $db;
    if(!$_SESSION['status'] == 'dialler') die;
	$tableName = 'discount';
	$value = ['idDiller' => $idDialler];
	$items = $db->select($tableName, $fildName = false, $value);
	return $items;
}

function getUserData($arrayNum){
    global $db;
	if ($arrayNum){
		//$userData = null;
		foreach ($arrayNum as $row){
			$userData[] = $db->select('users', false, ['idUser' => $row['idUser']]);
		}
		return $userData;
	}
	return false;
}

function discActivate($idDiller){
    global $db;
	$disNum = $_POST['discount'];
	$values = [
			'idDiller' => "$idDiller"
			];
	$tableName = 'discount';
	$forWhich = ['discountNum', $disNum];
    $sql = "SELECT * FROM `discount` WHERE `discountNum` = :discount AND `idUser` IS NOT NULL AND `idDiller` IS NOT NULL";
    $mask = [":discount" => $disNum];
    $isCodeActivated = $db->sendQuery($sql, $mask);
    if(!$isCodeActivated){
        $error = $db->update($tableName, $values, $forWhich);
        if ($error[0]){
            $db->setCurentTime($tableName, "apdateDate", $forWhich);
            return false;
        }
        else {
            return "Код указан неверно. Повторите пожалуйста ввод";
	    }
    }
    else {
        return "Такой код уже активирован";
    }
}



function getDiallerId(){
	global $db;
    $request = array("mail" => $_POST['login'], "pass" => md5($_POST['password']));
    $dialler = $db->select("dillers", false, $request);
	if ($dialler){
		$result = $dialler[0]['idDiller'];
	}
	else{
		$result = false;
	}
	Return ($result);
}

function diallAuth($dillerId){
    global $db;
	$_SESSION['auth'] = $dillerId;
	$_SESSION['status'] = 'dialler';
    $status = $db->select('dillers', 'status', ['idDiller' => $dillerId]);
    if (!empty($status[0]['status'])){
        $_SESSION['diallerStatus'] = 1;
    }
    else {
        $_SESSION['diallerStatus'] = 0;
    }
	if ($_POST['rememberMe'] == "on"){
		setcookie("auth", $dillerId, time()+60*60*24*3, '/');
		setcookie("status", 'dialler', time()+60*60*24*3, '/');
        setcookie("diallerStatus", $_SESSION['diallerStatus'], time()+60*60*24*3, '/');
	}
}

function exitAuthDil(){
	session_destroy();
	if ($_COOKIE['auth']){
		setcookie("auth", $_COOKIE['auth'], time()-120, '/');
		setcookie("status", $_COOKIE['status'], time()-120, '/');
        setcookie("status", $_COOKIE['diallerStatus'], time()-120, '/');
	} 
}


function createDialler(){
	$tableName = 'dillers';
    global $db;
// проверки введенных данных
	$phonePattern = "/^\+[0-9]{12}$/";
	$emailPattern = "/^[\w.]+@?([\w.]+)$/";
	$passPattern = "/[a-zA-Z0-9]{5,}/";
	
	if (!preg_match($emailPattern, $_POST['email'])){
		$result = [false, "Введите корректный Мейл"];
		return $result;
	}
	else {
		$mail = $_POST['email'];
	}
	if ($db->select($tableName, "mail", ['mail' => $mail])){
		$result = [false, "Такой e-mail уже зарегистрирован"];
		return $result;
	}
	if (!preg_match($passPattern, $_POST['password'])){
		$result = [false, "Введите корректный пароль. Пароль должен содержать более 5 цифровых символов или букв латиницы"];
		return $result;
	}
	else {
		$pass = md5($_POST['password']);
	}
	if ($pass != md5($_POST['password_confirm'])){
		$result = [false, "Введеный пароль не совпадает с первым полем"];
		return $result;
	}
		
	if (!preg_match($phonePattern, $_POST['phone'])) {
			$result = [false, "Введите номер телефона в формате +380442561565"];
			return $result;
	}
	else {
		$phone = $_POST['phone'];
	}
	$firstName = $_POST['first_name'];
	$lastName = $_POST['last_name'];
	$adress = $_POST['adress'];
	$company = $_POST['company'];
	$idDialler = genIdNum(8);
		// запросы на добавление в базу
		
		$values = [
            'idDiller' => "$idDialler",
			'mail' => "$mail",
			'pass' => "$pass",
			'firstName' => "$firstName",
			'lastName' => "$lastName",
			'phone' => "$phone",
			'adress' => "$adress",
			'compName' => "$company"	
		];
		$lastID = $db->insert($tableName, $values);
		if($lastID[0]){
			$result = [false, "Ошибка записи"];
			return $result;
		}
		$result = [$idDialler, "Дилер успешно зарегистрирован!",
            'mail' => "$mail",
            'firstName' => "$firstName",
            'lastName' => "$lastName",
            'phone' => "$phone",
            'adress' => "$adress",
            'compName' => "$company"
            ];
		return $result;	
}

function regDilMailPrepare($idDialler, $diallerName, $diallerLastName, $company, $mail, $phone, $adress){
    $tempText = file_get_contents("view/dialler/mailFormDiller.php");
    $patternArray = ['/#diallerId#/', '/#dillerInformation#/'];
    $table = "<table>
                <tr>
                    <th>Компания</th>
                    <th>Контактное лицо</th>
                    <th>E-mail</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                </tr>
                <tr>
                    <td>$company</td>
                    <td>$diallerName $diallerLastName</td>
                    <td>$mail</td>
                    <td>$phone</td>
                    <td>$adress</td>
                </tr>
                </table>
    ";
    $ReplaceArray = ["$idDialler", "$table"];
    $preparedFile = preg_replace($patternArray, $ReplaceArray, $tempText);
    return $preparedFile;
}

function sendConfRequest($diallerInfo){
    include_once "system/Mail.php";
    $textMail = regDilMailPrepare($diallerInfo[0], $diallerInfo['firstName'],
        $diallerInfo['lastName'], $diallerInfo['compName'], $diallerInfo['mail'],
        $diallerInfo['phone'], $diallerInfo['adress']);
    $mail = new Mail(ADMINMAIL); // Создаём экземпляр класса
    $mail->setFrom(ADMINMAIL);
    $mail->setSmtpServer("ssl://smtp.gmail.com");
    $mail->setSmtpPort(465);
    $mail->setSmtpLogin("bosch.adw@gmail.com");
    $mail->setSmtpPass("Bosch2015");
    $mail->setFromName("KTS Unlimited"); // Устанавливаем имя в обратном адресе
    $result = $mail->smtpSend(MYMAIL, "Запрос на авторизацию диллера", $textMail);
    if ($result[0]) {
        return true;
    }
    else {
        return false;
    }
}

function recallDilPassAction(){
    global $db;
    if (!$idExist = $db->select('dillers', false, ['mail' => $_POST['email']])){
        return false;
    }
    $recallCode = genIdNum(6);
    $db->update('dillers', ['recallPassword' => $recallCode], ['idDiller', $idExist[0]['idDiller']]);

    $tempText = file_get_contents("view/dialler/mailRecallPassDill.php");
    $patternArray = ['/#name#/', '/#codid#/'];
    $ReplaceArray = [$idExist[0]['firstName'], $recallCode];
    $preparedFile = preg_replace($patternArray, $ReplaceArray, $tempText);

    include_once "system/Mail.php";
    $mail = new Mail(ADMINMAIL); // Создаём экземпляр класса
    $mail->setFrom(ADMINMAIL);
    $mail->setSmtpServer("ssl://smtp.gmail.com");
    $mail->setSmtpPort(465);
    $mail->setSmtpLogin("bosch.adw@gmail.com");
    $mail->setSmtpPass("Bosch2015");
    $mail->setFromName("KTS Unlimited"); // Устанавливаем имя в обратном адресе
    $result = $mail->smtpSend($_POST['email'], "Восстановление пароля", $preparedFile);
    if ($result[0]) {
        return true;
    }
    else {
        return false;
    }
}

function changePassAction(){
    global $db;
    if (!$codExist = $db->select('dillers', false, ['recallPassword' => $_POST['cod']])){
        return [false, "Пароль не удалось изменить"];
    }
    $db->update('dillers', ['recallPassword' => '0', 'pass' => md5($_POST['password'])], ['recallPassword', $_POST['cod']]);
    return [true, "Пароль успешно изменен. Теперь Вы можете зайти на личную сраничку под новым паролем."];
}
