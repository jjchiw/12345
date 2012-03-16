<div class="view">
	<?php if(Yii::app()->user->hasFlash('friendRemoved')): ?>
		<div class="success">
			<?php echo Yii::app()->user->getFlash('friendRemoved'); ?>
		</div>
	<?php endif; ?>
	<div class="title">
		<?php echo CHtml::link($data->friend->username, array('ideas/user/','user'=>$data->friend->username)); ?>
		<?php echo CHtml::link('Remove', array('friend/remove/','friend'=>$data->friend->username)); ?>
		<?php echo CHtml::beginForm(Yii::app()->createUrl('groups/addFriends',array('friend'=> $data->friend->id))); ?>

		
		
		<?php 
		//$data is a Friend Model
		$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$data->get_groups_data_provider(),
		'itemView'=>'_groups',
		'viewData'=> array('friend'=>$data),
		'emptyText'=>$data->friend->username . ' does not exist in any group',
		'template'=>"{items}\n{pager}",
		)); ?>
		
		
		<?php $friends = Groups::loggedUserGroupsFriends($data->id); ?>
			<?php if(!empty($friends)): ?>
			<?php 
			$this->widget('application.components.Relation', array(
			   'model' => 'Friends',
			   'relation' => 'groups',
			   'parentObjects' => $friends,
			   'showAddButton' => false,
			   'style' => 'listBox',
			   'fields' => 'name' // show the field "username" of the parent element
			  )); ?>
			<?php echo CHtml::submitButton('Add'); ?>
		<?php endif; ?>
		<?php echo CHtml::endForm(); ?>
	</div>


</div>