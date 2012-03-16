<?php
$this->breadcrumbs=array(
	'Groups',
);
?>

<h1>List Groups</h1>

<ul class="actions">
	<li><?php echo CHtml::link('Create Groups',array('create')); ?></li>
	<li><?php echo CHtml::link('Manage Groups',array('admin')); ?></li>
</ul><!-- actions -->

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>"{items}\n{pager}",
)); ?>
