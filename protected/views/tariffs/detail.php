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
            <form enctype="multipart/form-data" action="" method="POST">
                <td>Добавить каналы из Плейлиста SevStar:</td>
                <td>
                    <input style="display: inline;" name="playlistfile" type="file" />
                    <input type="hidden" name="tariffId" value="<?php echo $tariff->id; ?>">
                    <input type="submit" name="submit" value="Обработать" />
                </td>
            </form>
        </tr>
        <tr>
            <form action="" method="POST">
                <td>
                    Очистить список каналов пакета
                </td>
                <td>
                    <input name="clearchannels" type="hidden" value="1" />
                    <input type="hidden" name="tariffId" value="<?php echo $tariff->id; ?>">
                    <input type="submit" name="submit" value="Очистить" />
                </td>
            </form>
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
<br />
<h4>Список каналов:</h4>
<table style="width: 100%;">
    <form action="" method="POST">
    <tr>
        <td style="width: 200px;">Добавление каналов:</td>
        <td >
            <?php echo CHtml::listBox('chaddids',null,$chlist,array('style'=>'width:90%;','multiple'=>'multiple')); ?>
        </td>
        <td>
            <input name="submit" type="submit" value="Добавить каналы в тариф">
        </td>
    </tr>
    </form>
</table><br />
<?php
$this->renderPartial('_channels',array(
    'channels'=>$tariff->channels,
    'tariff_id'=>$tariff->id,
));
?>