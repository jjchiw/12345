<?php
$this->pageTitle = "My Friends Ideas";

$this->breadcrumbs=array(
	'Ideas',
);
?>

<h1>My Friends Ideas</h1>
<?php echo CHtml::link('My Friends Feed', array('ideas/myFriendsFeed')); ?>

<?php $this->widget('zii.widgets.CListView', array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
'template'=>"{items}\n{pager}",
)); ?>