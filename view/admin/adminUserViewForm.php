<div class="col-md-10">
    <h3 class="bg-info">Зарегистрированые клиенты</h3>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№</th>
                    <th>ID</th>
                    <th>Город</th>
                    <th>Контактное лицо</th>
                    <th>E-mail</th>
                    <th>Телефон</th>
                    <th>Дата регистрации</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $j = 1;
                foreach ($usersList as $user){
                    ?>
                    <tr>
                        <td><?=$j?></td>
                        <td><?=$user['idUser']?></td>
                        <td><?=$user['city']?></td>
                        <td><?=$user['firstName']?> <?=$user['lastName']?></td>
                        <td><?=$user['mail']?></td>
                        <td><?=$user['phone']?></td>
                        <td><?=$user['createTime']?></td>
                        <td>
                            <a href="#">
                                <span>
                                    <img src="<?=SITE."sourses/buttons/edit.png"?>" alt="#"/>
                                </span>
                            </a>
                            <a href="#">
                                <span>
                                    <img src="<?=SITE."sourses/buttons/drop.png"?>" alt="#"/>
                                </span>
                            </a>
                        </td>
                    </tr>
                    <?php $j++;
                }?>
                </tbody>
            </table>
        </div>
    </div>
</div>