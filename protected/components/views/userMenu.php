<ul>
	<li><?php echo CHtml::link('There is something in my mind...', array('/ideas/create')); ?> </li>
	<li><?php echo CHtml::link('Favorite Ideas',array('/ideas/myFavoritesIdeas')); ?></li>
	<li><?php echo CHtml::link('My Ideas',array('/ideas/user/','user'=>Yii::app()->user->name)); ?></li>
	<li><?php echo CHtml::link('My Friends Ideas',array('/ideas/myFriendsIdeas')); ?></li>
</ul>

<ul>
	<li><?php echo CHtml::link('My Friends',array('/friends/myFriends')); ?></li>
	<li><?php echo CHtml::link('My Groups',array('/groups/user/','user'=>Yii::app()->user->name)); ?></li>
	<li><?php echo CHtml::link('Manage Ideas', array('/ideas/admin','user'=>Yii::app()->user->name)); ?> </li>
	<li><?php echo CHtml::link('Profile', array('/user/profile')); ?> </li>
	<li><?php echo CHtml::link('Logout', array('/user/logout')); ?></li>
</ul>