<h2>Личный кабинет:</h2>
<table  class="table table-responsive table-striped table-bordered ">
    <?php if ($user!=NULL){ ?>
    <tr>
        <td>Ф.И.О.</td>
        <td><?php echo $user->name; ?></td>
    </tr>
    <tr>
        <td>Контактные данные</td>
        <td><?php echo $user->contact; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td>IP адрес</td>
        <td><?php echo $ip; ?></td>
    </tr>
</table>
<hr />
<?php $this->renderPartial('_allowed',array(
    'allowed_list'=>$allowed_list
)); ?>