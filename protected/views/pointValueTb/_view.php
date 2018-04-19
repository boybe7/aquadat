<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('point_id')); ?>:</b>
	<?php echo CHtml::encode($data->point_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datetime_record')); ?>:</b>
	<?php echo CHtml::encode($data->datetime_record); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('point_value')); ?>:</b>
	<?php echo CHtml::encode($data->point_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_flag')); ?>:</b>
	<?php echo CHtml::encode($data->status_flag); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remark')); ?>:</b>
	<?php echo CHtml::encode($data->remark); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($data->modified_date); ?>
	<br />

	*/ ?>

</div>