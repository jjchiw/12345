<?php
$this->breadcrumbs=array(
	'Idea'=>array('index'),
	'Create',
);
?>
<h1>Is there something in your mind?</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>