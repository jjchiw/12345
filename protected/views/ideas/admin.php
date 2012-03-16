<?php
$this->breadcrumbs=array(
	'Ideas'=>array('index'),
	'Manage',
);
?>
<h1>Manage Ideas</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'idea',
		array(
			'name'=>'status',
			'value'=>'Lookups::item("IdeasStatus",$data->status)',
		),
		'tags',
		array(// display 'create_time' using an expression
            'name'=>'create_time',
            'value'=>'date("M j, Y", $data->create_time)',
        ),

		/*
		'update_time',
		*/
		array(
			'class'=>'CButtonColumn',
			//'class'=>'DeleteGridButton',
		),
	),
)); ?>
