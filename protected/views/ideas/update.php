<?php
$this->breadcrumbs=array(
	'Ideas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update Ideas <?php echo $model->id; ?></h1>

<ul class="actions">
	<li><?php echo CHtml::link('List Ideas',array('index')); ?></li>
	<li><?php echo CHtml::link('Create Ideas',array('create')); ?></li>
	<li><?php echo CHtml::link('View Ideas',array('view','id'=>$model->id)); ?></li>
</ul><!-- actions -->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>