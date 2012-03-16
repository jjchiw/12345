<?php
$this->breadcrumbs=array(
	'Comments',
);
?>

<h1>List Comments</h1>

<ul class="actions">
	<li><?php echo CHtml::link('Create Comments',array('create')); ?></li>
	<li><?php echo CHtml::link('Manage Comments',array('admin')); ?></li>
</ul><!-- actions -->

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
