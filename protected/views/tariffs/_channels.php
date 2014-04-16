<table class="table .table-responsive table-striped table-bordered">
    <?php foreach ($channels as $ch){ ?>
        <tr>
            <td><?php echo $ch->ch_name; ?></td>
            <td><?php echo $ch->m_ip; ?></td>
            <td><?php echo $ch->m_port; ?></td>
            <td>
                <form action="" method="POST">
                    <input type="hidden" name="deleteChId" value="<?php echo $ch->id; ?>">
                    <?php echo CHtml::button('Удалить канал из тарифа', array('submit' =>Yii::app()->createUrl("tariffs/detail",array("id" => $tariff->id)), 'confirm'=>'Вы ТОЧНО желаете удалить канал "'.$ch->ch_name.'" ?', 'name'=>'accept')); ?>
                </form>
            </td>
        </tr>


    <?php } ?>
</table>