<?php
$this->pageTitle = "Search: " . $_GET['s'];
$this->breadcrumbs=array(
	'Ideas',
);
?>

<h1>Search: <i><?php echo $_GET['s']; ?></i></h1>

<?php $this->widget('zii.widgets.CListView', array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
'template'=>"{items}\n{pager}",
)); ?>