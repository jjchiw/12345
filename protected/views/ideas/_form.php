<div id="new-idea" class="form">

<?php echo CHtml::beginForm(); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo CHtml::errorSummary($model); ?>

	<div class="row idea">
		<?php echo CHtml::activeLabelEx($model,'idea'); ?>
		<?php echo CHtml::activeTextArea($model,'idea',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo CHtml::error($model,'idea'); ?>
		<?php echo CHtml::activeLabelEx($model,'description'); ?>
		<?php echo CHtml::activeTextArea($model,'description',array('size'=>60)); ?>
	</div>
	
	<div class="row">
	<?php if($model->isNewRecord): ?>
			<?php $groups = Groups::loggedUserGroups(); ?>
			<?php if(!empty($groups)): ?>
				Groups:
				<?php
					$this->widget('application.components.Relation', array(
					   'model' => 'Ideas',
					   'relation' => 'groups',
					   'parentObjects' => $groups,
					   'showAddButton' => false,
					   'style' => 'listBox',
					   'fields' => 'name' // show the field "username" of the parent element
					  ));
				?>
			<?php endif; ?>
			  
	<?php else: ?>
			<?php $groups = $model->get_groups_data_provider(); ?>
			<?php if(!empty($groups)): ?>
				Groups:
				<?php 
					//$data is a Idea Model
					$this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$groups,
					'itemView'=>'_groups',
					'viewData'=> array('idea'=>$model),
					'emptyText'=>$model->idea . ' does not exist in any group',
					'template'=>"{items}\n{pager}",
					));
						$this->widget('application.components.Relation', array(
						   'model' => 'Ideas',
						   'relation' => 'groups',
						   'parentObjects' => Groups::loggedUserGroupsIdeas($model->id),
						   'showAddButton' => false,
						   'style' => 'listBox',
						   'fields' => 'name' // show the field "username" of the parent element
						  ));
				?>
			<?php endif; ?>
		  
	<?php endif; ?>
		 
	</div>
	
	<?php if($model->isNewRecord): ?>
	<div class="row visibility">
		<?php echo CHtml::activeLabelEx($model,'is_public'); ?>
		<?php echo CHtml::activeCheckBox($model,'is_public'); ?>
		<?php echo CHtml::error($model,'is_public'); ?>
	</div>
	<?php endif ?>
	
	<div class="row tags">
		<?php echo CHtml::activeLabelEx($model,'tags'); ?>
		<?php echo CHtml::activeTextField($model,'tags',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo CHtml::error($model,'tags'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->