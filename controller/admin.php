<?php

function index(){
    loadheader();
    loadmainpage();
    loadfooter();
}

function audit(){
    if ($_SESSION['status'] == "adm"){
        adminMainForm();
    }
    else {
        loadheader();
        loadmenu(1);
        include_once("view/admin/adminAuthForm.php");
        loadfooter();
    }
}

function adminAuth(){
    include_once("model/admin.php");
    $result = adminAuthAction();
    if ($result){
        adminMainForm();
    }
    else {
        header ("Location:/");
    }
}

function exitAction(){
    include_once("model/admin.php");
    exitAuthAdm();
    header ("Location:/");
}

function diallerConfirmation(){
    include_once("model/admin.php");
    $result = diallerActivation($_GET['dil']);
    header("Refresh:2;url=".SITE);
    loadheader();
    if($result[0]){
    echo "Диллер успешно активирован";
    }
    else {
        echo "Ошибка активации";
    }
    loadfooter();
}

function adminMainForm(){
    include_once("model/admin.php");
    $info = getAdminInfoAll();
    loadheader();
    loadmenu(1);
    include_once("view/admin/adminMainForm.php");
    loadfooter();
}

function regBill(){
    include_once("model/admin.php");
    $error = regBillAction();
    header ("Refresh:2;url=".SITE."admin/audit");
    loadheader();
    if ($error[0]){
        echo "Номер счета записан";
    }
    else{
        echo "Ошибка записи";
    }
    loadfooter();
}

function settingView(){
    include_once("model/admin.php");
    $price = getPriceInfo();
    loadheader();
    loadmenu(4);
    include_once("view/admin/adminSettingForm.php");
    loadfooter();
}

function priceChange(){
    include_once("model/admin.php");
    priceChangeAction();
    header ("Refresh:2;url=".SITE."admin/settingView");
}

function dillersList(){
    include_once("model/admin.php");
    $dilList = getDillList();
    loadheader();
    loadmenu(2);
    include_once("view/admin/adminDillViewForm.php");
    loadfooter();
}

function usersList(){
    include_once("model/admin.php");
    $usersList = getUserList();
    loadheader();
    loadmenu(3);
    include_once("view/admin/adminUserViewForm.php");
    loadfooter();
}

function dillerDelete(){
    /*echo "Hello Nikolay: ".$_POST['idDil'];*/
    echo "success";
}

function testDBclass(){
    include_once("model/admin.php");
    test();
}

/*function hashDillPass(){
    global $db;
    $allDial = $db->select('dillers', ['idDiller', 'pass']);
    foreach($allDial as $value){
        $newPass = md5($value['pass']);
        $db->update('dillers',['pass'=>$newPass],['idDiller', $value['idDiller']]);
    }

    //var_dump($allDial);
}*/