<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Manage',
);
?>
<h1>Manage Groups</h1>

<ul class="actions">
	<li><?php echo CHtml::link('List Groups',array('index')); ?></li>
	<li><?php echo CHtml::link('Create Groups',array('create')); ?></li>
</ul><!-- actions -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
