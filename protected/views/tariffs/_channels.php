<table class="table .table-responsive table-striped table-bordered">
    <?php foreach ($channels as $ch){ ?>
        <tr>
            <td><?php echo $ch->ch_name; ?></td>
            <td><?php echo $ch->stream_type; ?></td>
            <td><?php echo $ch->stream_address; ?></td>
            <td>
                <form action="" method="POST">
                    <input type="hidden" name="deleteChId" value="<?php echo $ch->id; ?>">
                    <?php echo CHtml::button('Удалить канал из тарифа', array('submit' =>Yii::app()->createUrl("tariffs/detail",array("id" => $tariff_id)), 'confirm'=>'Вы ТОЧНО желаете удалить канал "'.$ch->ch_name.'" ?', 'name'=>'accept')); ?>
                </form>
            </td>
        </tr>


    <?php } ?>
</table>