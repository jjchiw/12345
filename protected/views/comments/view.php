<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	$model->id,
);
?>
<h1>View Comments #<?php echo $model->id; ?></h1>

<ul class="actions">
	<li><?php echo CHtml::link('List Comments',array('index')); ?></li>
	<li><?php echo CHtml::link('Create Comments',array('create')); ?></li>
	<li><?php echo CHtml::link('Update Comments',array('update','id'=>$model->id)); ?></li>
	<li><?php echo CHtml::linkButton('Delete Comments',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure to delete this item?')); ?></li>
	<li><?php echo CHtml::link('Manage Comments',array('admin')); ?></li>
</ul><!-- actions -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
		'content',
		'status',
		'idea_id',
		'create_time',
	),
)); ?>
