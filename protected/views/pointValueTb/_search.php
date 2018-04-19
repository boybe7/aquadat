<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'point_id',array('class'=>'span5','maxlength'=>9)); ?>

	<?php echo $form->textFieldRow($model,'datetime_record',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'point_value',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>8)); ?>

	<?php echo $form->textFieldRow($model,'status_flag',array('class'=>'span5','maxlength'=>1)); ?>

	<?php echo $form->textFieldRow($model,'remark',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'created_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'modified_date',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
