<?php

function adminAuthAction(){
    global $db;
    $request = ["adminLog" => $_POST['log'], "adminPass" => $_POST['pass']];
    $admin = $db->select("admin", false, $request);
    if ($admin){
        $adminId = $admin[0]['idAdmin'];
    }
    else{
      return false;
    }
    $_SESSION['auth'] = $adminId;
    $_SESSION['status'] = 'adm';
    if ($_POST['remember'] == "on"){
        setcookie("auth", $adminId, time()+60*60*24*3, '/');
        setcookie("status", 'adm', time()+60*60*24*3, '/');
    }
    return true;
}

function exitAuthAdm(){
    session_destroy();
    if ($_COOKIE['auth']){
        setcookie("auth", $_COOKIE['auth'], time()-120, '/');
        setcookie("status", $_COOKIE['status'], time()-120, '/');
    }
}


function diallerActivation($idDialler){
    global $db;
    $idExist = $db->select('dillers', false, ['idDiller' => $idDialler]);
    if (!$idExist){
       return false;
    }
    $result = $db->update('dillers', ['status' => '1'], ['idDiller', $idDialler]);
    actMail($idExist);
    return $result;
}

function actMail($dillerInfo = array()){
    $tempText = file_get_contents("view/admin/mailActivation.php");
    //подстановка данных пользователя в шаблон
    $patternArray = ['/#name#/', '/#company#/', '/#site#/'];
    $ReplaceArray = [$dillerInfo[0]['firstName'], $dillerInfo[0]['compName'], SITE];
    $preparedFile = preg_replace($patternArray, $ReplaceArray, $tempText);
    $subject = "Ваш аккаунт активирован";
    $result = sendMessage ($preparedFile, $dillerInfo[0]['mail'], $subject);
    return $result;
}


function sendMessage ($textMail, $recipientMail, $subject){
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

function getAdminInfoAll(){
    global $db;
    $allDiallers = $db->select('dillers', ['compName', 'idDiller']);
    array_push($allDiallers, ['compName' => 'Незарегистрированные скидки', 'idDiller' => '777']);

    $adminInfo = $db->select('auditviewall');
    foreach ($adminInfo as &$val){
        if ($val['idDiller'] == NULL){
            $val['idDiller'] = '777';
            $val['compName'] = 'Незарегистрированные скидки';
        }
    }
    foreach ($allDiallers as &$diller){
        $i = NULL;
        foreach ($adminInfo as $vall){
            if ($vall['idDiller'] == $diller['idDiller']){
                $i++;
            }
        }
        $diller += ["count" => "$i"];
    }

     /* echo "<pre>";
    var_dump($allDiallers);
    echo "</pre>";*/
    return [$allDiallers, $adminInfo];
}

function regBillAction(){
    global $db;
    $result = $db->update('discount',['invoice'=>$_POST['bill']],['discountNum', $_POST['trans']]);
    return $result;
}

function getPriceInfo(){
    $price = unserialize(file_get_contents(SITE.'system/price.php'));
    $priceUA = round($price['kurs']*($price['esi'] + $price['kts']), 2);
    $price['ua'] = $priceUA;
    return $price;
}

function priceChangeAction(){
    $priceArray = [
        'kurs' => $_POST['kurs'],
        'esi' => $_POST['esi'],
        'kts' => $_POST['kts']
    ];
    //echo '/system/price.php';
    $error = file_put_contents('system/price.php', serialize($priceArray));
    return $error;
}

function getDillList(){
    global $db;
    $allDiallers = $db->select('dillers');
    return $allDiallers;
}

function getUserList(){
    global $db;
    $allUsers = $db->select('users');
    return $allUsers;
}

function dillDeleteAction($idDill){
    global $db;
    $tableName = 'dillers';
    return $db->delete($tableName,['idDiller', $idDill]);
}

function dillUpdateAction($dillInfo = array()){
    global $db;
    $dillInfoArray = $dillInfo['dillerInfo'];
    $id = array_pop($dillInfoArray);
    $er = $db->update('dillers', $dillInfoArray, ['idDiller', $id]);
    return $er[0];
}

function test(){
    global $db;
    $query = ["idUser" => "777", "idDiller" => "888"];
    $text = $db->select('dillers', false, ['mail' => "putin@ukr.net", 'pass' => "12345"]);
    echo "<pre>";
    var_dump ($text);
    echo "</pre>";
    $test ="SELECT `dillers`.`idDiller`, `dillers`.`compName`, `dillers`.`status`,
		`users`.`iduser`, `users`.`mail`, `users`.`firstName`,
		`users`.`phone`, `users`.`city`,
		`discount`.`discountNum`, `discount`.`apdateDate`, `discount`.`createDate`,
		`discount`.`invoice`
FROM `discount`
LEFT JOIN `dillers` USING(`idDiller`)
LEFT JOIN `users` USING(`idUser`)";
}