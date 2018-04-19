<?php
$this->breadcrumbs=array(
	'Users Info Tbs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UsersInfoTb','url'=>array('index')),
	array('label'=>'Create UsersInfoTb','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('users-info-tb-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users Info Tbs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'users-info-tb-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'user_id',
		'name',
		'position',
		'username',
		'password',
		/*
		'mobiletemplate_id',
		'exceltemplate_id',
		'user_group_id',
		'approver',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
