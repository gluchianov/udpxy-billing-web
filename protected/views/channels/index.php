<div class="well">
    <h4 style="margin: 5px;">Добавление каналов вручную:</h4>
    <table class="formpadding" style="border-bottom: 1px solid darkslategray; margin-bottom: 10px; width: 100%;">
        <tr>
            <form action="" method="POST">
                <td>Название канала: </td>
                <td> <input type="text" name="newChName" value="" maxlength="32"  /></td>
                <td>
				<select size="1" name="newChType">
					<option disabled>Выберите тип</option>
					<option value="UDP" selected>UDP</option>
					<option value="HTTP">HTTP</option>
			   </select>
				</td>
                <td>Адрес потока: </td>
                <td><input type="text" name="newChAddress" value="" size="20" maxlength="255"  /></td>
                <td colspan="2"><input type="submit" name="newChSubmit" value="Добавить канал" /></td>
            </form>
        </tr>
    </table>
    
    <table class="formpadding" style="width: 100%">
        <tr>
            <form action="" method="POST">
                <td style="width: 1px;">
                    <input name="clearchannels" type="hidden" value="1" />
                </td>
                <td>
                    <input type="submit" name="submit" value="Очистить список каналов!" />
                </td>
            </form>
        </tr>
    </table>
</div>

<table class="table .table-responsive table-striped table-bordered">
<?php foreach ($chanells as $ch){ ?>
<tr>
    <td><?php echo $ch->ch_name; ?></td>
    <td><?php echo $ch->stream_type; ?></td>
    <td><?php echo $ch->stream_address; ?></td>
    <td>
        <form action="" method="POST">
            <input type="hidden" name="deleteChId" value="<?php echo $ch->id; ?>">
            <?php echo CHtml::button('Удалить канал', array('submit' =>Yii::app()->createUrl("channels/index"), 'confirm'=>'Вы ТОЧНО желаете удалить канал "'.$ch->ch_name.'" ?', 'name'=>'accept')); ?>
        </form>
    </td>
</tr>


<?php } ?>
</table>