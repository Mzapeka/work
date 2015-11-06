<?php
function loadheader(){
	include_once "view/header.php";
}

function loadfooter(){
	include_once "view/footer.php";
}

function loadmainpage(){
	include_once "view/main/mainForm.php";
}

// генерация случайных кодов любой длинны
function genIdNum($longNum){
    $allowArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0,
        a, b, c, d, e, f, g, h, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z
    ];
    $result = '';
    for ($i = 0; $i < $longNum; $i++){
        $result .= $allowArray[rand(0,count($allowArray))];
    }
    return $result;
}



?>