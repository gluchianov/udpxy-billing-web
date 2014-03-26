<table class="table .table-responsive table-striped table-bordered">
    <tbody>
        <tr>
            <td>Название тарифа:</td>
            <td><?php echo $tariff->name; ?></td>
        </tr>
            <td>Описание:</td>
            <td><?php echo $tariff->descr; ?></td>
        </tr>
        <tr>
            <td>Переименовать тариф:</td>
            <td>
                <form action="" method="POST">
                    <input type="text" name="newName" value="" maxlength="32"  />
                    <input type="submit" name="newNameSubmit" value="Переименовать" />
                </form>
            </td>
        </tr>
        <tr>
            <td>Изменить описание:</td>
            <td>
                <form action="" method="POST">
                    <input type="text" name="newDescr" value="" maxlength="32"  />
                    <input type="submit" name="newDescrSubmit" value="Изменить описание" />
                </form>
            </td>
        </tr>
        <tr>
            <td>Удалить тарифный план:</td>
            <td>
                <form action="" method="POST">
                    <input type="hidden" name="deleteTid" value="<?php echo $tariff->id; ?>">
                    <?php echo CHtml::button('Удалить', array('submit' =>Yii::app()->createUrl("tariffs/detail",array("id" => $tariff->id)), 'confirm'=>'Вы ТОЧНО желаете удалить тариф "'.$tariff->name.'" ?', 'name'=>'accept')); ?>
                </form>
            </td>
        </tr>
    </tbody>
</table>

<?php $this->renderPartial('_channels',array(
    'chanells'=>$chanells,
    'tariff'=>$tariff,
)); ?>