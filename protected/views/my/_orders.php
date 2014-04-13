<h3>Пользовательские подписки:</h3>
<table class="table table-bordered table-striped">
    <thead><tr>
        <th>#Код</th>
        <th>Название подписки</th>
        <th>Дата начала подписки</th>
        <th>Дата окончания подписки</th>
    </tr></thead>
    <tbody>
    <?php
    if ($orders==NULL){echo '<tr><td colspan="3" style="text-align: center">Нет активных подписок</td></tr>';}
    else
        foreach ($orders as $order){ ?>
            <tr>
                <td>
                    <?php echo $order->id; ?>
                </td>
                <td>
                    <?php echo $order->tvpack->descr; ?>
                </td>
                <td>
                    <?php echo $order->start_date; ?>
                </td>
                <td>
                    <?php echo $order->end_date; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>