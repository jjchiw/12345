<?php foreach($ideas as $idea): ?>
<div class="comment_ideas" id="i<?php echo $idea->id; ?>">
	
	<div class="time">
		<?php echo date('F j, Y \a\t h:i a',$idea->create_time); ?>
	</div>
	
	<div class="author">
		<?php echo CHtml::link("Idea link", $idea->getUrl(), array(
		'title'=>'Permalink to the idea',
	)); ?>
		<?php echo "'Re-idea by:'". $idea->author->username; ?>
	</div>

	
	
</div>
<?php endforeach; ?>