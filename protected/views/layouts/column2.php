<?php $this->beginContent('application.views.layouts.main'); ?>
<div class="container">
	<div class="span-18">
		<div id="content">
			<?php echo $content; ?>
		</div>
	</div>
	<div class="span-6 last">
		<div id="sidebar">
			<?php $this->widget('SearchIdeas'); ?>
			
			<?php $this->widget('SearchUsers'); ?>
		
			<?php if(!Yii::app()->user->isGuest) $this->widget('UserMenu'); ?>
			
			<?php if($this->beginCache('tagCloud', array('duration'=>36000))) { ?>
				<?php $this->widget('TagCloud', array(	'maxTags'=>Yii::app()->params['tagCloudCount'],
												)); ?>
			<?php $this->endCache(); } ?>								
			<?php $this->widget('RecentComments', array('maxComments'=>Yii::app()->params['recentCommentsCount'],
														)); ?>
		</div>
	</div>
</div>
<?php $this->endContent(); ?>