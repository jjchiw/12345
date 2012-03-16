<div class="view idea">

	<div class="details">
		<span class="author">
			posted by <?php echo CHtml::link($data->author->username, Users::getUrl($data->author->username)) . ' on ' . date('F j, Y',$data->create_time); ?>
			| Last updated on <?php echo date('F j, Y',$data->update_time); ?>
		</span>
	<span class="public">
		<?php if($data->is_public): ?>
			| Public
		<?php else: ?>
			| Private
		<?php endif; ?>
		</span>
	</div>

	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo CHtml::link($data->idea, $data->url);
			$this->endWidget();
		?>
	</div>

	<div class="info">
		<ul class="tags">
			<?php foreach($data->tagLinks as $tag): ?>
			<li><?php echo $tag ?></li>
			<?php endforeach; ?>
		</ul>
		<div class="groups">
			<h3>Groups:</h3>
			<ul>
				<?php foreach($data->groupsNames as $groupsName): ?>
				<li><?php echo $groupsName ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<span class="comments-count">
			<?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		</span>
	</div>
	
	<div class="title">
		<?php if(!Yii::app()->user->isGuest): ?>
			<?php if(!Users::isIdeaFavorite(Yii::app()->user->id, $data->id)): ?>
				<?php echo CHtml::link('Mark as Favorite', array('ideas/addFavorite', 'id'=>$data->id)); ?>
			<?php else: ?>
				<?php echo CHtml::link('Remove as Favorite', array('ideas/removeFavorite', 'id'=>$data->id)); ?>
			<?php endif; ?>	
			<?php 	if(!empty($data->comment_origin->id)): ?>
				<?php echo CHtml::link("Coming from comment",$data->comment_origin->url); ?>
			<?php	endif;?>
		<?php	endif;?>
		<?php $full_url = Yii::app()->request->hostInfo . Yii::app()->request->url; ?>
		<a class="a2a_dd" href="http://www.addtoany.com/share_save?linkname=&amp;linkurl=<?php echo $full_url; ?>"><img src="http://static.addtoany.com/buttons/share_save_120_16.gif" width="120" height="16" border="0" alt="Share/Bookmark"/></a><script type="text/javascript">a2a_linkurl="<?php echo $full_url; ?>";</script><script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>
	</div>
</div>