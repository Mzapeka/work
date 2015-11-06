<div class="container marketing">

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-md-offset-3 col-sm-offset-2" id="regForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Забыли пароль?</h4>
                </div>
                <div class="modal-body">
                    <p>Введите зарегистрированный E-mail и на него будет отправлено письмо с новым паролем</p>
                    <div class="container" style="width: 50%">
                        <form action="<?=$SITE."changePass"?>" method="post">

                            <label>
                                <input type="email" name="email" placeholder="E-mail">
                            </label>
                            <input type="submit" value="Выслать пароль">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>