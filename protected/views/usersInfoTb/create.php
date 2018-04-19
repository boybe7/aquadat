<?php
$this->breadcrumbs=array(
	'Users Info Tbs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UsersInfoTb','url'=>array('index')),
	array('label'=>'Manage UsersInfoTb','url'=>array('admin')),
);
?>

<h1>Create UsersInfoTb</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>