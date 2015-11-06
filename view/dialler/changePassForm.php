<div class="container marketing">

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-md-offset-3 col-sm-offset-2" id="regForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Новый пароль</h4>
                </div>
                <div class="modal-body">
                    <p>Введите новый пароль</p>
                    <div class="container" style="width: 50%">
                        <form action="<?=$SITE."changePass"?>" method="post">

                            <label>
                                Пароль:<input type="password" name="password">
                            </label>
                            <input type="submit" value="Изменить пароль">
                            <input type="hidden" name="cod" value="<?=$_GET['cod']?>"/>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>