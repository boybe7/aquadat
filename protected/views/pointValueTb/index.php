<?php
$this->breadcrumbs=array(
	'Point Value Tbs',
);

$this->menu=array(
	array('label'=>'Create PointValueTb','url'=>array('create')),
	array('label'=>'Manage PointValueTb','url'=>array('admin')),
);
?>

<h1>Point Value Tbs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
