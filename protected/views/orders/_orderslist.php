<table class="table table-bordered table-striped">
    <thead><tr>
        <th>Дата начала подписки</th>
        <th>Дата окончания подписки</th>
        <th>Статус подписки</th>
        <th>&nbsp;</th>
    </tr></thead>
    <tbody>
        <?php
            if ($t_data==NULL){echo '<tr><td colspan="4" style="text-align: center">Нет активных подписок</td></tr>';}
            else
            foreach ($t_data as $my_order){ ?>
                <td>
                        <?php echo $my_order->start_date; ?>
                </td>
                <td>
                    <?php echo $my_order->end_date; ?>
                </td>
                <td>
                    <?php
                        switch ($my_order->status){
                            case 1: echo "<span style='color: green;'>Оформлена</span>"; break;
                            case 0: echo "<span style='color: red;'>Окончена</span>"; break;
                            default: break;
                    } ?>
                </td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="deleteOId" value="<?php echo $my_order->id; ?>">
                        <?php echo CHtml::button('Закрыть подписку', array('submit' =>Yii::app()->createUrl("orders/view",array("client" => (int)$_GET['client'])), 'confirm'=>'Вы ТОЧНО желаете закрыть данную подписку?', 'name'=>'accept')); ?>
                    </form>
                </td>
            <?php } ?>
    </tbody>
</table>