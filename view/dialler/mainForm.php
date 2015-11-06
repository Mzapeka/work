<div class="container marketing">




<div class="table-responsive">
                    <table class="table table-hover">
						<tr>
							<th>Номер скидки</th>
							<th>Имя клиента</th>
							<th>фамилия</th>
							<th>Город</th>
							<th>Дата активации</th>
						</tr>
						<?php if (is_array($discountData)){
                            foreach($discountData as $kay => $row){?>
							<tr>
								<td><h2><span class="label label-default"><?=$row['discountNum']?></span></h2></td>
								<td><?=$userData[$kay][0]['firstName']?></td>
								<td><?=$userData[$kay][0]['lastName']?></td>
								<td><?=$userData[$kay][0]['city']?></td>
								<td><?=$row['apdateDate']?></td>
							</tr>
						
						<?php } } ?>
						
						
					</table>
</div>
	
	<BR>
    <?php
    if ($_SESSION['diallerStatus'] == 1){
        //echo $_SESSION['diallerStatus'];?>
        <form action="<?=SITE."dialler/activateAction"?>" method="post">
            
            
			<label>
                Введите код скидки:<input type="text" name="discount">
            </label>
			
			  
            <input type="submit" value="Активировать">
        </form>
    <?php }
    else {?>
        <h3>Ваш аккаунт ожидает авторизации администратора.</h3>
        <p>На Ваш почтовый ящик придет уведомление о авторизации. После этого Вы сможете регистрировать коды скидок клиентов.</p>
    <?php }?>
