<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#clients-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление клиентами</h1>

<p>
Вы можете использовать выражения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) для в расширенном поиске.
</p>

<div class="btn-group">
<?php echo CHtml::link('Добавить клиента',array('create'),array('class'=>'btn btn-default')); ?>
<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button btn btn-default')); ?>
</div>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'clients-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'ajaxType'=>'GET',
    'ajaxUpdate'=>true,
    'ajaxUrl'=> Yii::app()->request->getUrl(),
	'columns'=>array(
        array
        (
            'class'=>'CButtonColumn',
            'template'=>'{order}',
            'buttons'=>array
            (
                'order' => array
                (
                    'label'=>'Заказы клиента',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/img/icon_order.png',
                    'url'=>'Yii::app()->createUrl("orders/view", array("client"=>$data->id))',
                ),
            ),
        ),
		'id',
		'name',
		'contact',
		'ip',
		array(
            'header'=>'Действия',
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
		),
	),
)); ?>
