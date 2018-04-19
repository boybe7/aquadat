<?php
$this->breadcrumbs=array(
	'Point Value Tbs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PointValueTb','url'=>array('index')),
	array('label'=>'Create PointValueTb','url'=>array('create')),
	array('label'=>'Update PointValueTb','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete PointValueTb','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PointValueTb','url'=>array('admin')),
);
?>

<h1>View PointValueTb #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'point_id',
		'datetime_record',
		'point_value',
		'user_id',
		'status_flag',
		'remark',
		'created_date',
		'modified_date',
	),
)); ?>
