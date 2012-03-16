<?php echo CHtml::beginForm(array('search'), 'get'); ?>
<ul>
	<li>
		<?php echo CHtml::textField('s','',array('maxlength'=>60)); ?>
	</li>
	<li>
	<div class="row buttons">
		<?php echo CHtml::linkButton('Search'); ?>
	</div>
	</li>
	

<?php echo CHtml::endForm(); ?>