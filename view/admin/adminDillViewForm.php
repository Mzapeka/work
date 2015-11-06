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
                            <tr>
                                <td><?=$j?></td>
                                <td><?=$dialler['idDiller']?></td>
                                <td><?=$dialler['compName']?></td>
                                <td><?=$dialler['firstName']?> <?=$dialler['lastName']?></td>
                                <td><?=$dialler['mail']?></td>
                                <td><?=$dialler['phone']?></td>
                                <td><?=$dialler['createData']?></td>
                                <td><?=$dialler['status']?></td>
                                <td><button type="button" class="btn btn-default btn-xs">Action</button></td>
                            </tr>
                    <?php $j++;
                    }?>
                    </tbody>
                </table>
            </div>
        </div>
</div>

