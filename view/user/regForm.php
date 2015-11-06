<div class="container marketing">

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-md-offset-3 col-sm-offset-2" id="regForm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Добро пожаловать!</h4>
            </div>
            <div class="modal-body">
                    <form role="form" method="POST" id="regForm" action="<?=SITE?>user/infoUser">
                        <div class="form-group">
                            <h3>Зарегистрируйтесь и получите скидку 3%!</h3>
                            <p>Информация о стоимости комплекта и размере скидки доступна для зарегистрированных пользователей</p>
                            <div class="form-group has-feedback">
                                <label for="fname">Ваше имя:</label>
                                <input class="form-control" id="fname" placeholder="Имя" type="text" name="first_name" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label for="lname">Ваша фамилия:</label>
                                <input type="text" class="form-control" id="lname" placeholder="Фамилия" name="last_name">
                            </div>
                            <div class="form-group has-feedback">
                                <label for="em">Ваш E-mail:</label>
                                <input type="email" class="form-control" id="em" placeholder="E-mail" name="email" data-toggle="tooltip" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label for="city1">Город:</label>
                                <input type="text" class="form-control" id="city1" placeholder="Город" name="city" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label for="phone1">Контактный телефон:</label>
                                <input type="text" class="form-control" id="phone1" placeholder="Телефон в формате +380ххххххххх" name="phone" data-toggle="tooltip" required="">
                            </div>
                        </div>
                        <div class="form-group">

                            <label>
                                <input type="checkbox" name="agree" value="agree">Я согласен на обработку личных данных согласно <a href="http://www.bosch.ua/imprint/uk/imprints.php?tab=2&KeepThis=true&TB_iframe=true&height=600&width=980&content=[.cntWrapper]" target="_blank">условий</a>
                            </label>
                        </div>
                        <input type="submit" class="btn btn-primary btn-lg btn-block" id="sendForm" value="Получить скидку"">
                    </form>

                </div>


        </div>
    </div>
    </div>