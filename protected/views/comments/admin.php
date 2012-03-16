<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	'Manage',
);
?>
<h1>Manage Comments</h1>

<ul class="actions">
	<li><?php echo CHtml::link('List Comments',array('index')); ?></li>
	<li><?php echo CHtml::link('Create Comments',array('create')); ?></li>
</ul><!-- actions -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'email',
		'content',
		'status',
		'idea_id',
		'create_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
