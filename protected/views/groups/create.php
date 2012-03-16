<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	'Create',
);
?>
<h1>Create Groups</h1>

<ul class="actions">
	<li><?php echo CHtml::link('List Groups',array('index')); ?></li>
	<li><?php echo CHtml::link('Manage Groups',array('admin')); ?></li>
</ul><!-- actions -->

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>