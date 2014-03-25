<h2>Заказы клиента №<?php echo $cl->id; ?></h2>
<table  class="table table-responsive table-striped table-bordered ">
    <tr>
        <td>Ф.И.О.</td>
        <td><?php echo $cl->name; ?></td>
    </tr>
    <tr>
        <td>Контактные данные</td>
        <td><?php echo $cl->contact; ?></td>
    </tr>
    <tr>
        <td>IP адрес</td>
        <td><?php echo $cl->ip; ?></td>
    </tr>
</table>
<h3>Активные заказы по тарифам:</h3>
<table  class="table table-responsive table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Название тарифа</th>
            <th>Подписки:</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($tariffs as $t_name=>$t_data){ ?>
        <tr>
            <td><?php echo $t_name; ?></td>
            <td>
                <?php $this->renderPartial('_orderslist',array(
                    't_data'=>$t_data
                )); ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<br /><hr /><h3>История подписок:</h3>
<?php $this->renderPartial('_history_list',array(
    'history_data'=>$history_data
)); ?>