<h2>Тарифные планы:</h2>

<table class="well formpadding">
    <tr>
        <form action="" method="POST">
        <td>Название тарифа: </td>
        <td> <input type="text" name="newName" value="" maxlength="32"  /></td>
        <td>Описание тарифа: </td>
        <td><input type="text" name="newDescr" value="" maxlength="32"  /></td>
        <td colspan="2"><input type="submit" name="newTSubmit" value="Добавить тариф" /></td>
        </form>
    </tr>
</table>
<br/>
<table class="table .table-responsive table-striped table-bordered table-hover ">
    <thead>
        <th>Название тарифа</th>
        <th>Описание</th>
        <th>Подробнее</th>
    </thead>
    <tbody>
        <?php foreach ($tariffs as $tariff){ ?>
        <tr>
            <td><?php echo $tariff->name ?></td>
            <td><?php echo $tariff->descr ?></td>
            <td class="tariffdetail"><?php echo CHtml::link('Детали тарифа #'.$tariff->id,array('detail','id'=>$tariff->id),array('class'=>'btn btn-info')); ?></a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>