<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update Comments <?php echo $model->id; ?></h1>

<ul class="actions">
	<li><?php echo CHtml::link('List Comments',array('index')); ?></li>
	<li><?php echo CHtml::link('Create Comments',array('create')); ?></li>
	<li><?php echo CHtml::link('View Comments',array('view','id'=>$model->id)); ?></li>
	<li><?php echo CHtml::link('Manage Comments',array('admin')); ?></li>
</ul><!-- actions -->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>