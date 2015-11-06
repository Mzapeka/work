<div class="col-md-10">
    <h3 class="bg-info">Страница администратора</h3>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php
        $i = "a";
        foreach ($info[0] as $dialler){?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?=$i?>">
                <h4 class="panel-title">
                    <a <?php if ($i != "a") echo "class=\"collapsed\"";?> data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i?>" aria-expanded="<?php if ($i != "a"){ echo "false";} else {echo "true";}?>" aria-controls="collapse<?=$i?>">
                        <?=$dialler['compName']?>    <span class="badge"><?=$dialler['count']?></span>
                    </a>
                </h4>
            </div>
            <div id="collapse<?=$i?>" class="panel-collapse collapse <?php if ($i == "a") echo "in";?>" role="tabpanel" aria-labelledby="heading<?=$i?>">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>ФИО</th>
                                <th>Город</th>
                                <th>E-mail</th>
                                <th>Телефон</th>
                                <th>№ скидки</th>
                                <th>Дата активации</th>
                                <th>Счет</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
								 $j = 1;
                                foreach ($info[1] as $adminInfo){
                                  if ($adminInfo['idDiller'] == $dialler['idDiller']){
                            ?>
                            <tr>
                                <td><?=$j?></td>
                                <td><?=$adminInfo['firstName']?></td>
                                <td><?=$adminInfo['city']?></td>
                                <td><?=$adminInfo['mail']?></td>
                                <td><?=$adminInfo['phone']?></td>
                                <td><?=$adminInfo['discountNum']?></td>
                                <td><?=$adminInfo['apdateDate']?></td>
                                <td><?=$adminInfo['invoice']?></td>
                                <td><button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#exampleModal" data-names="<?=$adminInfo['discountNum']?>">Вписать счет</button></td>
                            </tr>
                            <?php $j++;}
                                    }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            <?php $i++; } ?>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрити</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Номер счета</h4>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="<?=SITE."admin/regBill"?>">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Введите номер счета:</label>
                        <input type="text" class="form-control" id="recipient-name" name="bill">
                        <input type="hidden" class="transfer" name="trans"/>
                    </div>
                    <button type="submit" class="btn btn-primary">OK</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
            </div>
        </div>
    </div>
</div>