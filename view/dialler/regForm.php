<div class="container marketing">

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-md-offset-3 col-sm-offset-2" id="regForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Добро пожаловать!</h4>
                </div>
                <div class="modal-body">

    <div class="container" style="width: 50%">
        <h4>Регистрация дилера</h4>
        <form action="<?=$SITE."registration"?>" method="post">
            
            <label>
                Ваш e-mail:<input type="email" name="email" required="">
            </label>
            <label>
                Пароль:<input type="password" name="password" required="">
            </label>
            <label>
                Повторите пароль:<input type="password" name="password_confirm" required="">
            </label>
			<label>
                Компания:<input type="text" name="company" required="">
            </label>
			<fieldset>
				<legend>Контактное лицо</legend>
				<label>
					Имя:<input type="text" name="first_name" required="">
				</label>
				<label>
					Фамилия:<input type="text" name="last_name">
				</label>
			</fieldset>
            <label>
                Адрес:<input type="text" name="adress" required="">
            </label>
            <label>
                Контактный телефон:<input type="text" name="phone" placeholder="+380xxxxxxxxx" required="">
            </label>
            
            <input type="submit" value="Зарегистрироваться">
        </form>


    </div>
                </div>
            </div>
        </div>
    </div>