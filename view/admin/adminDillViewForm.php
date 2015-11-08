<div class="col-md-10">
    <h3 class="bg-info">Зарегистрированые диллеры</h3>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>ID</th>
                        <th>Компания</th>
                        <th>Адрес</th>
                        <th>Контактное лицо</th>
                        <th>E-mail</th>
                        <th>Телефон</th>
                        <th>Дата регистрации</th>
                        <th>Статус</th>
                        <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $j = 1;
                        foreach ($dilList as $dialler){
                    ?>
                            <tr id="<?=$dialler['idDiller']?>">
                                <td><?=$j?></td>
                                <td><?=$dialler['idDiller']?></td>
                                <td class="compName"><?=$dialler['compName']?></td>
                                <td class="adress"><?=$dialler['adress']?></td>
                                <td class="nameDil"><?=$dialler['firstName']?> <?=$dialler['lastName']?></td>
                                <td class="mail"><?=$dialler['mail']?></td>
                                <td class="phone"><?=$dialler['phone']?></td>
                                <td><?=$dialler['createData']?></td>
                                <td><?=$dialler['status']==1 ? "Активный" : ""?></td>
                                <td class="action">
                                    <button type="button" class="btn btn-default btn-xs editDill" data-idDill="<?=$dialler['idDiller']?>">
                                <span>
                                    <img src="<?=SITE."sourses/buttons/edit.png"?>" alt="#"/>
                                </span>
                                    </button>
                                    <button type="button" class="btn btn-default btn-xs deleteDill" data-toggle="modal" data-target="#deleteDillModal" data-idDill="<?=$dialler['idDiller']?>">
                                <span>
                                    <img src="<?=SITE."sourses/buttons/drop.png"?>" alt="#"/>
                                </span>
                                    </button>
                                </td>
                            </tr>
                    <?php $j++;
                    }?>
                    </tbody>
                </table>
            </div>
        </div>
</div>

<div class="modal fade" id="deleteDillModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрити</span></button>
            </div>
            <div class="modal-body">
                <form role="form">
                    <h4>Вы действительно хотите удалить дилера:</h4>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary btn-xs" id="deleteDill">Удалить</button>
            </div>
        </div>
    </div>
</div>