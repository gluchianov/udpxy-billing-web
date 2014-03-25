<table class="table table-bordered table-striped">
    <thead><tr>
        <th>ID</th>
        <th>Тариф</th>
        <th>Дата начала подписки</th>
        <th>Дата окончания подписки</th>
        <th>Статус подписки</th>
        <th>Открывший оператор</th>
        <th>Закрывший оператор</th>
    </tr></thead>
    <tbody>
    <?php
    if ($history_data==NULL){echo '<tr><td colspan="7" style="text-align: center">Нет архивных подписок</td></tr>';}
    else
        foreach ($history_data as $my_order){ ?>
            <tr>
            <td>
                <?php echo $my_order['ord_data']->id; ?>
            </td>
            <td>
                <?php echo $my_order['tariff']; ?>
            </td>
            <td>
                <?php echo $my_order['ord_data']->start_date; ?>
            </td>
            <td>
                <?php echo $my_order['ord_data']->end_date; ?>
            </td>
            <td>
                <?php
                switch ($my_order->status){
                    case 1: echo "<span style='color: green;'>Оформлена</span>"; break;
                    case 0: echo "<span style='color: red;'>Закрыта</span>"; break;
                    default: break;
                } ?>
            </td>
            <td>
                <?php echo $my_order['start_operator']; ?>
            </td>
            <td>
                <?php echo $my_order['end_operator']; ?>
            </td>
            </tr>
        <?php } ?>
    </tbody>
</table>