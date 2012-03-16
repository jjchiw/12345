<div class="form">

<?php echo CHtml::beginForm(); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo CHtml::errorSummary($model); ?>

	<?php if(Yii::app()->user->isGuest): ?>
		<div class="row">
			You must log in to give an idea...
		</div>
		<?php else: ?>
		<div class="row">
			<?php echo "Loggued as: " . Yii::app()->user->name; ?>
		</div>	
		<div class="row">
		<?php echo CHtml::activeLabelEx($model,'content'); ?>
		<?php echo CHtml::activeTextArea($model,'content',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo CHtml::error($model,'content'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	<?php endif; ?>
	

<?php echo CHtml::endForm(); ?>

</div><!-- form -->