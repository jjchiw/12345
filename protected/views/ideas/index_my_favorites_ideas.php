<?php
$this->pageTitle = "My Favorite Ideas";

$this->breadcrumbs=array(
	'Ideas',
);
?>

<h1>My Favorite Ideas</h1>
<?php echo CHtml::link('My Friends Feed', array('ideas/myFavoriteFeed')); ?>

<?php $this->widget('zii.widgets.CListView', array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
'template'=>"{items}\n{pager}",
)); ?>