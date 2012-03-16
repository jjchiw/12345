<?php foreach($comments as $comment): ?>
<div class="comment" id="c<?php echo $comment->id; ?>">

	<?php if(Yii::app()->user->hasFlash('voteSubmitted')): ?>
		<div class="success">
			<?php echo Yii::app()->user->getFlash('voteSubmitted'); ?>
		</div>
	<?php endif; ?>
	
	<?php echo CHtml::link("#{$comment->id}", $comment->getUrl($idea), array(
		'class'=>'cid',
		'title'=>'Permalink to this comment',
	)); ?>
	
	<?php echo CHtml::link("Down", array('comments/vote','comment'=>$comment->id, 'vote' => '-1'), array(
		'class'=>'cid',
		'title'=>'Down',
	)); ?>
	
	<?php echo CHtml::link("Up", array('comments/vote', 'comment'=>$comment->id, 'vote' => '1'), array(
		'class'=>'cid',
		'vote'=>'Up',
	)); ?>
	
	<?php echo CHtml::link("Convert to Idea", array('ideas/convert','comment'=>$comment->id), array(
		'class'=>'cid',
		'title'=>'Conver to idea',
	)); ?>
	
	<?php echo 'Rank ' . CHtml::label($comment->rank, 'rank', array('class'=>'cid',));?>

	<div class="author">
		<?php echo $comment->author->username; ?> thinks:
	</div>

	<div class="time">
		<?php echo date('F j, Y \a\t h:i a',$comment->create_time); ?>
	</div>

	<div class="content">
		<?php echo nl2br(CHtml::encode($comment->content)); ?>
	</div>
	
	<?php $this->renderPartial('_comments_ideas',array(
			'ideas'=>$comment->ideas
		));
	?>
</div><!-- comment -->
<?php endforeach; ?>