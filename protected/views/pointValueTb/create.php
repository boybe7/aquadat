<?php
$this->breadcrumbs=array(
	'Point Value Tbs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PointValueTb','url'=>array('index')),
	array('label'=>'Manage PointValueTb','url'=>array('admin')),
);
?>

<h1>Create PointValueTb</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>