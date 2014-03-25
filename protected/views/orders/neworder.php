<h2>Оформление подписки:</h2>

<table style="margin: 5px auto;" class="well formpadding">
        <tr>
            <td>Клиент:</td>
            <td><?php echo $client->name.'(#'.$client->id.')';?></td>
        </tr>
    <form action="" method="POST">
        <input type="hidden" name="clientid" value="<?php echo $client->id; ?>"/>
        <tr>
            <td>Тариф: </td>
            <td><?php echo CHtml::dropDownList('tariffid',NULL,$tariffs) ?></td>
        </tr>
        <tr>
            <td>Действует c: <br/>Начало в 00:00:00</td>
            <?php if(isset($_POST['startdate'])) $d=$_POST['startdate']; else $d=date("Y-m-d");  ?>
            <td><?php echo CHtml::dateField('startdate',$d); ?></td>
        </tr>
        <tr>
            <td>Действует до: <br/>Окончание в 23:59:59</td>
            <td><?php echo CHtml::dateField('enddate',$_POST['enddate']); ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input type="submit" name="newOrderSubmit" value="Оформить подписку" /></td>
        </tr>
    </form>
</table>