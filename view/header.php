<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Диагностический сканер KTS 540 Unlimited. Професиональная диагностика автомобилей от Bosch">
    <meta name="author" content="Bosch Украина">
    <link rel="alternate" hreflang="RU" href="alternateURL">


    <title>KTS 540 Unlimited</title>

    <!-- CSS-ядро Bootstrap -->
    <link href="<?=SITE?>system/css/bootstrap.min.css" rel="stylesheet">

    <!-- Вставка HTML5 поєднується з Respond.js для підтримки в IE8 елементів HTML5 та медіа-запитів -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Підібрані стилі саме для цього сайту-->
    <link href="<?=SITE?>system/bosch.css" rel="stylesheet">
    <!--
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-66306415-1', 'auto');
        ga('send', 'pageview');

    </script>
    -->
</head>
<!-- NAVBAR
================================================== -->
<body>
<div class="navbar-wrapper">


    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="brandn" class="navbar-brand" href="<?=SITE?>">Пакет KTS Unlimited</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="http://ua-ww.bosch-automotive.com/uk/ww/about_us_workshopworld/dealers_search/dealer_search">Контакты дилеров</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Сайт Bosch<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="http://ua-ww.bosch-automotive.com/uk/">Диагностика</a></li>
                            <li><a href="http://ua.bosch-automotive.com/uk/">Автозапчасти</a></li>
                            <li><a href="http://ua-ww.bosch-automotive.com/uk/ww/services_support_workshopworld/bosch_training_center/bosch_training_center">Курсы для механиков</a></li>
                            <li class="divider"></li>
<!--                            <li class="dropdown-header">Навігаційний заголовок</li>
                            <li><a href="#">Відокремлений лінк</a></li>
                            <li><a href="#">Ще один відокремлений лінк</a></li>
-->                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav" id="second">
                    <?php if ($_SESSION['status']) {
                        if ($_SESSION['status'] == 'dialler') {
                            ?>
                            <li><a href="<?= SITE ?>dialler/mainFormLoad">Личный кабинет</a></li>
                            <li><a href="<?= SITE ?>user/exitAction">Выйти</a></li>
                        <?php
                        } elseif ($_SESSION['status'] == 'user') {
                            ?>
                            <li><a href="<?= SITE ?>user/userFormLoad">Личный кабинет</a></li>
                            <li><a href="<?= SITE ?>user/exitAction">Выйти</a></li>
                        <?php }
                        elseif ($_SESSION['status'] == 'adm') {
                            ?>
                            <li><a href="<?= SITE ?>admin/adminMainForm">Личный кабинет</a></li>
                            <li><a href="<?= SITE ?>admin/exitAction">Выйти</a></li>
                        <?php }
                    } else {
                        ?>
                        <li>
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal">
                                Войти
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#dilModal">
                                Дилер
                                <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>
                            </button>
                        </li>
                    <?php }; ?>
                </ul>


            </div>

        </div>
    </nav>
    <div class="Logo">
        <a href="http://www.bosch.ua/uk/ua/startpage_6/country-landingpage.php">
            <img src="<?=SITE?>sourses/logo_ua.png" width="128" height="63" alt="" title="" border="0">
        </a>
    </div>
</div>

<!-- Модаль Хедера -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                <h4 class="modal-title" id="myModalLabel">Личный кабинет</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="/user/userAuthAction">
                    <div class="form-group">
                        <label for="inputLogin" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="login" required="" autofocus="">
                            <!--<input type="text" class="form-control" id="inputLogin" placeholder="Логін" name="login">-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Пароль" name="password" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="rememberMe"> Запомнить меня
                                    </label>

                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-4">
                                <div class="pull-right" style="margin-right: 5%">
                                    <p class="navbar-text navbar-right"><a href="<?=SITE?>user/changePassForm" class="navbar-link">Восстановить пароль</a></p>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <input type="submit" class="btn btn-primary" name="log" value="Войти"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Модаль Дилера -->

<div class="modal fade" id="dilModal" tabindex="-1" role="dialog" aria-labelledby="dilModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                <h4 class="modal-title" id="dilModalLabel">Личный кабинет дилера</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="POST" action="/dialler/diallerAuth">
                    <div class="form-group">
                        <label for="inputLogin" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="login" required="" autofocus="">
                            <!--<input type="text" class="form-control" id="inputLogin" placeholder="Логін" name="login">-->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Пароль" name="password" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-offset-2 col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="rememberMe"> Запомнить меня
                                    </label>

                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-4">
                                <div class="pull-right" style="margin-right: 5%">
                                    <p class="navbar-text navbar-right"><a href="<?=SITE?>dialler/regForm" class="navbar-link">Регистрация дилера</a></p>
                                </div>
                                <div class="pull-right" style="margin-right: 5%">
                                    <p class="navbar-text navbar-right"><a href="<?=SITE?>dialler/fogotDilPass" class="navbar-link">Восстановит пароль</a></p>
                                </div>

                            </div>

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <input type="submit" class="btn btn-primary" name="log" value="Войти"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="maincontainer">