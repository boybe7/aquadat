<?php
$this->breadcrumbs=array(
	'Users Info Tbs'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UsersInfoTb','url'=>array('index')),
	array('label'=>'Create UsersInfoTb','url'=>array('create')),
	array('label'=>'View UsersInfoTb','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage UsersInfoTb','url'=>array('admin')),
);
?>

<h1>Update UsersInfoTb <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>