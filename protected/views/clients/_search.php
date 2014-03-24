<?php
/* @var $this ClientsController */
/* @var $model Clients */
/* @var $form CActiveForm */
?>

<div class="well">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <table>
        <tr>
            <td><?php echo $form->label($model,'id'); ?>: </td>
            <td><?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->label($model,'name'); ?>: </td>
            <td><?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->label($model,'contact'); ?>: </td>
            <td><?php echo $form->textField($model,'contact',array('size'=>60,'maxlength'=>255)); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->label($model,'ip'); ?>: </td>
            <td><?php echo $form->textField($model,'ip',array('size'=>15,'maxlength'=>15)); ?></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo CHtml::submitButton('Искать'); ?></td>
        </tr>
    </table>
<?php $this->endWidget(); ?>

</div><!-- search-form -->