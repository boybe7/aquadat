<?php
$this->breadcrumbs=array(
	'Users Info Tbs'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UsersInfoTb','url'=>array('index')),
	array('label'=>'Create UsersInfoTb','url'=>array('create')),
	array('label'=>'Update UsersInfoTb','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete UsersInfoTb','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UsersInfoTb','url'=>array('admin')),
);
?>

<h1>View UsersInfoTb #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'name',
		'position',
		'username',
		'password',
		'mobiletemplate_id',
		'exceltemplate_id',
		'user_group_id',
		'approver',
	),
)); ?>
