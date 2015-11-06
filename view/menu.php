<div class="col-md-2" style="padding-top: 17px">
    <ul class="nav nav-pills nav-stacked">
        <li role="presentation" <?php if ($item==1){echo "class=\"active\"";} ?>><a href="<?=SITE."admin/adminMainForm"?>">Диллер - скидка</a></li>
        <li role="presentation" <?php if ($item==2){echo "class=\"active\"";};?>><a href="<?=SITE."admin/dillersList"?>">Диллеры</a></li>
        <li role="presentation" <?php if ($item==3){echo "class=\"active\"";};?>><a href="<?=SITE."admin/usersList"?>">Клиенты</a></li>
        <li role="presentation" <?php if ($item==4){echo "class=\"active\"";};?>><a href="<?=SITE."admin/settingView"?>">Настройки</a></li>
    </ul>
</div>