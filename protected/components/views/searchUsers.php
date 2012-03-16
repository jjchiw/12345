<?php echo CHtml::beginForm(array('searchUser')); ?>
<ul>
	<li>
		<?php echo CHtml::textField('user','',array('maxlength'=>60)); ?>
	</li>
	<li>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>
	</li>
	

<?php echo CHtml::endForm(); ?>