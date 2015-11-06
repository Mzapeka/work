<div class="col-md-10">
    <h3 class="bg-info">Настройка данных</h3>
    <form role="form" method="post" action="<?=SITE."admin/priceChange"?>">
        <div class="form-group">
            <label for="esi">Цена ESI Unlimited Euro без НДС</label>
            <input type="text" class="form-control" name="esi" id="esi" value="<?=$price['esi']?>">
        </div>
        <div class="form-group">
            <label for="kts">Цена KTS Euro c НДС</label>
            <input type="text" class="form-control" name="kts" id="kts" value="<?=$price['kts']?>">
        </div>
        <div class="form-group">
            <label for="kurs">Курс Euro</label>
            <input type="text" class="form-control" name="kurs" id="kurs" value="<?=$price['kurs']?>">
        </div>
        <button type="submit" class="btn btn-default">Изменить цену</button>
    </form>
</div>

