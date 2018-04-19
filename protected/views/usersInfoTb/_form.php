<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'users-info-tb-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5','maxlength'=>8)); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'position',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'mobiletemplate_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'exceltemplate_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'user_group_id',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'approver',array('class'=>'span5','maxlength'=>1)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
