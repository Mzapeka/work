<div class="container marketing">
    <div>
        <h1><?=$userName?>, здравствуйте!</h1>
        <p>Рекомендуемая розничная стоимость комплекта KTS 540 Unlimited - <kbd><?=$price['ua']?></kbd> Грн. с НДС</p>
        <p>Ваша скидка - <kbd><?=$price['discount']?></kbd> Грн. с НДС</p>
        <p>Рекомендуемая стоимость комплекта со скидкой - <kbd><?=$price['ua']-$price['discount']?></kbd> Грн. с НДС</p>
        <p>
            Для того, чтобы воспользоваться специальным предложением, и получить скидку на диагностический
            сканер Bosch KTS 540 c программным обеспечением ESI[tronic]2.0 (SD+SIS) без абонентской платы, Вам необходимо
            сделать две вещи:
        </p>
        <ul>
            <li>обратится к любому дилеру диагностического оборудования Bosch. Список можно найти
                <a href="http://ua-ww.bosch-automotive.com/uk/ww/about_us_workshopworld/dealers_search/dealer_search">здесь</a>
            </li>
            <li>передать один из свободных номеров скидки дилеру диагностического оборудования Bosch</li>
        </ul>
        <p>
            Важно! При необходимости, Вы можете получить еще 2 дополнительных номера скидки, которые дают возможность приобрести диагностический сканер KTS c безлимитным ПО со скидкой.
            У Вас может быть максимум 3 свободных кода.
        </p>
    </div>
 <div class="table-responsive">
    <table class="table table-hover">
        <tr>
            <th>Номер скидки</th>
            <th>Статус</th>
            <th>Компания</th>
            <th>Дата активации</th>
        </tr>
        <?php foreach ($discountData as $kay => $row) { ?>
            <tr>
                <td><kbd><?= $row['discountNum'] ?></kbd></td>
                <td><?php if ($row['idDiller']) {
                        echo "Активирован";
                    } else {
                        echo "Свободный";
                    } ?></td>
                <td><?= $diallerData[$kay][0]['compName'] ?></td>
                <td><?= $row['apdateDate'] ?></td>
            </tr>

        <?php } ?>


    </table>
 </div>

    <BR>
    <div class="bigbut">
        <a href="<?=SITE?>user/createDis" class="btn btn-primary btn-lg btn-block" role="button">Получить еще один код</a>
    </div>