<?php
$this->breadcrumbs=array(
	'Point Value Tbs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PointValueTb','url'=>array('index')),
	array('label'=>'Create PointValueTb','url'=>array('create')),
	array('label'=>'View PointValueTb','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage PointValueTb','url'=>array('admin')),
);
?>

<h1>Update PointValueTb <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>