<?php
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name,
);
?>
<h1>Group: <?php echo $model->name; ?></h1>

<ul class="actions">
	<li><?php echo CHtml::link('List Groups',array('index')); ?></li>
	<li><?php echo CHtml::link('Create Groups',array('create')); ?></li>
	<li><?php echo CHtml::link('Update Groups',array('update','id'=>$model->id)); ?></li>
	<li><?php echo CHtml::linkButton('Delete Groups',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure to delete this item?')); ?></li>
	<li><?php echo CHtml::link('Manage Groups',array('admin')); ?></li>
</ul><!-- actions -->

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
	),
)); ?>

Friends:
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_friends',
	'template'=>"{items}\n{pager}",
)); ?>

Ideas:
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProviderIdeas,
	'itemView'=>'_ideas',
	'template'=>"{items}\n{pager}",
)); ?>