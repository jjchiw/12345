<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<?php echo CHtml::link('Remove', Yii::app()->createUrl('groups/removeFriend',array('group'=> $data->id, 'friend'=>$friend->id))); ?>
	<br />
</div>