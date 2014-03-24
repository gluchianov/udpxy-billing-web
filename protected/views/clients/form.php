<div class="form well">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clients-form',
	'enableAjaxValidation'=>false,
    'htmlOptions'=>array('class'=>'class="form-horizontal"'),
)); ?>
    <fieldset>
    <legend>
        <?php
         if($model->isNewRecord) echo '<h2>Добавление клиента:</h2>';
        else echo '<h2>Редактирование клиента #'.$model->id.':</h2>';
        ?>

    </legend>
	<p class="note">Поля с <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="form-group">
		<?php echo $form->labelEx($model,'name',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
        <?php echo $form->error($model,'name'); ?>
        </div>

	</div>
    <div class="form-group">
		<?php echo $form->labelEx($model,'contact',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
		<?php echo $form->textField($model,'contact',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'contact'); ?>
        </div>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'ip',array('class'=>'col-lg-2 control-label')); ?>
        <div class="col-lg-10">
		<?php echo $form->textField($model,'ip',array('size'=>15,'maxlength'=>15,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'ip'); ?>
        </div>
	</div>

    <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить',array('class'=>'btn btn-default')); ?>
	    </div>
    </div>
    </fieldset>
<?php $this->endWidget(); ?>

</div><!-- form -->