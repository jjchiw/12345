<?php if(!empty($_GET['tag'])): ?>
	<?php $this->pageTitle = "Posts Tagged with ".$_GET['tag']; ?>
<?php elseif(isset($_GET['user']) && !empty($_GET['user'])): ?>
	<?php if(Yii::app()->user->name == $_GET['user']): ?>
		<?php $this->pageTitle = "My ideas"; ?>
	<?php else: ?>
		<?php $this->pageTitle = "Ideas from: ". $_GET['user']; ?>
	<?php endif; ?>
<?php elseif(isset($_POST['user']) && !empty($user)): ?>
	<?php if(Yii::app()->user->name == $user): ?>
		<?php $this->pageTitle = "My Ideas"; ?>
	<?php else: ?>
		<?php $this->pageTitle = "Ideas from: ".$user; ?>
	<?php endif; ?>
<?php else: ?>
		<?php $this->pageTitle = "Ideas"; ?>
<?php endif; ?>

<?php
$this->breadcrumbs=array(
	'Ideas',
);
?>

<?php if(!empty($_GET['tag'])): ?>
<h1>Posts Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php elseif(isset($_GET['user']) && !empty($_GET['user'])): ?>
	<?php if(Yii::app()->user->name == $_GET['user']): ?>
		<h1>My ideas</h1>
		<?php echo CHtml::link('Feed', array('ideas/userFeed', 'user'=>Yii::app()->user->name)); ?>
	<?php else: ?>
		<?php if(Yii::app()->user->hasFlash('friendAdded')): ?>
		<div class="success">
			<?php echo Yii::app()->user->getFlash('friendAdded'); ?>
		</div>
		<?php endif; ?>
		<h1>Ideas from: <i><?php echo $_GET['user']; ?></i> 
		<?php if(!Friends::areFriendsByFriendName(Yii::app()->user->id, $_GET['user']) && !Yii::app()->user->isGuest): ?>
			<?php echo CHtml::link('add as friend', array('friends/add', 'friend'=>$_GET['user'])); ?>
		<?php endif; ?>
		</h1>
		<?php echo CHtml::link('Feed', array('ideas/userFeed', 'user'=>$_GET['user'])); ?>
	<?php endif; ?>
<?php elseif(isset($_POST['user']) && !empty($user)): ?>
	<?php if(Yii::app()->user->name == $user): ?>
		<h1>My ideas</h1>
		<?php echo CHtml::link('Feed', array('ideas/userFeed', 'user'=>$user)); ?>
	<?php else: ?>
		<h1>Ideas from: <i><?php echo $user; ?></i></h1>
		<?php echo CHtml::link('Feed', array('ideas/userFeed', 'user'=>$user)); ?>
	<?php endif; ?>
<?php else: ?>
		<h1>Ideas</h1>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('message')): ?>
		<div class="success">
			<?php echo Yii::app()->user->getFlash('message'); ?>
		</div>
	<?php endif; ?>


<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_viewSimple',
	'template'=>"{items}\n{pager}",
)); ?>
<?php  
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'/js/viewSimple.js');
?>
