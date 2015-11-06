<form class="form-horizontal" role="form" action="<?=SITE?>admin/adminAuth" method="POST" style="max-width: 90%; margin-top: 15px">
    <div class="form-group">
        <label for="inputLogin" class="col-sm-2 control-label">Login</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="log" id="inputLogin" placeholder="Login" required="" autofocus="">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" name="pass" id="inputPassword3" placeholder="Password" required="">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Запомнить меня
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Войти</button>
        </div>
    </div>
</form>