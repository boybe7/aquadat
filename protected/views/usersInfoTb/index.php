<?php
$this->breadcrumbs=array(
	'Users Info Tbs',
);

$this->menu=array(
	array('label'=>'Create UsersInfoTb','url'=>array('create')),
	array('label'=>'Manage UsersInfoTb','url'=>array('admin')),
);
?>

<h1>Users Info Tbs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
