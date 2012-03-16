<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update Groups <?php echo $model->id; ?></h1>

<ul class="actions">
	<li><?php echo CHtml::link('List Groups',array('index')); ?></li>
	<li><?php echo CHtml::link('Create Groups',array('create')); ?></li>
	<li><?php echo CHtml::link('View Groups',array('view','id'=>$model->id)); ?></li>
	<li><?php echo CHtml::link('Manage Groups',array('admin')); ?></li>
</ul><!-- actions -->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>