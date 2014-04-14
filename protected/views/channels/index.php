<hr />
<table class="well formpadding">
    <tr>
        <form action="" method="POST">
            <td>Название канала: </td>
            <td> <input type="text" name="newChName" value="" maxlength="32"  /></td>
            <td>IP адрес: </td>
            <td><input type="text" name="newChIP" value="" maxlength="15"  /></td>
            <td>Порт: </td>
            <td><input type="text" name="newChPort" value="" size="5" maxlength="5"  /></td>
            <td colspan="2"><input type="submit" name="newChSubmit" value="Добавить канал" /></td>
        </form>
    </tr>
</table>


<table class="table .table-responsive table-striped table-bordered">
<?php foreach ($chanells as $ch){ ?>
<tr>
    <td><?php echo $ch->ch_name; ?></td>
    <td><?php echo $ch->m_ip; ?></td>
    <td><?php echo $ch->m_port; ?></td>
    <td>
        <form action="" method="POST">
            <input type="hidden" name="deleteChId" value="<?php echo $ch->id; ?>">
            <?php echo CHtml::button('Удалить канал', array('submit' =>Yii::app()->createUrl("channels/index"), 'confirm'=>'Вы ТОЧНО желаете удалить канал "'.$ch->ch_name.'" ?', 'name'=>'accept')); ?>
        </form>
    </td>
</tr>


<?php } ?>
</table>