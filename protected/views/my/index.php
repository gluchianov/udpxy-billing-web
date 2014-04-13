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
<table class="table table-responsive table-striped table-bordered ">
    <tr>
        <td style="width: 200px; text-align: center; vertical-align: middle;">
            <?php echo CHtml::link('Скачать плейлист',array('GetPlaylist'),array('class'=>'btn btn-default')); ?>
        </td>
        <td>
            Ссылка на плейлист:<br/>
            <input style="width: 96%;" readonly="readonly" value="http://<?php echo Yii::app()->request->serverName.$this->createUrl('GetPlaylist'); ?>" />
        </td>
    </tr>
</table>
<div style="text-align: center;">
    <span id="showallorders" class="btn btn-default">Показать список активных подписок</span>
</div>
<div id="allorders">
<hr />
<?php $this->renderPartial('_allowed',array(
    'allowed_list'=>$allowed_list
)); ?>
</table>
<?php $this->renderPartial('_orders',array(
    'orders'=>$orders
)); ?>
</div>
<script>
    $('#showallorders').click(function(){
       $('#allorders').show();
       $('#showallorders').hide();
    });
</script>