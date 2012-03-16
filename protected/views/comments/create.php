<?php
$this->breadcrumbs=array(
	'Comments'=>array('index'),
	'Create',
);
?>
<h1>Create Comments</h1>

<ul class="actions">
	<li><?php echo CHtml::link('List Comments',array('index')); ?></li>
	<li><?php echo CHtml::link('Manage Comments',array('admin')); ?></li>
</ul><!-- actions -->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>