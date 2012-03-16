<ul>
	<?php foreach($this->getRecentComments() as $comment): ?>
	<li><?php echo CHtml::link(CHtml::encode($comment->idea->idea), $comment->getUrl()); ?>
	</li>
	<?php endforeach; ?>
</ul>