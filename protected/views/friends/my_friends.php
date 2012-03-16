<?php
$this->pageTitle = "My Friends";

$this->breadcrumbs=array(
	'Friends',
);
?>

<h1>My Friends</h1>

<?php $this->widget('zii.widgets.CListView', array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
'template'=>"{items}\n{pager}",
)); ?>