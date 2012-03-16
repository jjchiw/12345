<?php
Yii::import('application.vendors.*');
require_once('Zend/Feed.php');
require_once('Zend/Feed/Rss.php');


class IdeasController extends Controller
{
	const PAGE_SIZE=10;
	public $layout="column2";

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(	'allow', // allow all users to perform 'list' and 'show' actions
					'actions'=>array('index', 'view', 'user', 'searchUser', 'userFeed', 'allFeed', 'ideaFeed'),
					'users'=>array('*'),
			),
			
			array(	'allow', // allow authenticated users to perform any action
					'users'=>array('@'),
			),
			
			
			array(	'deny', // deny all users
					'actions'=>array('update', 'create'),
					'users'=>array('*'),
			),
		
			
			
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$idea = $this->loadModel();
		$comment=$this->newComment($idea);
		
		$this->render('view',array(
			'model'=>$idea,
			'comment'=>$comment,
		));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Ideas;
		if(isset($_POST['Ideas']))
		{
			$model->attributes=$_POST['Ideas'];
			if($model->save()){
				if(isset($_POST['Ideas']['Groups'])){
					$model->groups = array_merge($model->groups, array_values($_POST['Ideas']['Groups']));
					$model->save();
				}
				$this->redirect(array('view', 'id'=>$model->id, 'idea'=>$model->idea));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		if(isset($_POST['Ideas']))
		{
			$model->attributes=$_POST['Ideas'];
			if($model->save())
				if(isset($_POST['Ideas']['Groups'])){
					$model->groups = array_merge($model->groups, array_values($_POST['Ideas']['Groups']));
					$model->save();
				}
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$criteria = $this->criteria_user_feed();
	
		$dataProvider=new DataProvider(	'Ideas', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												'criteria'=>$criteria,
												)
											);

		$dataProvider->joinAll = true;
											
		$this->render('index',array('dataProvider'=>$dataProvider,));
	
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		if(isset($_GET['user']) && Yii::app()->user->name == $_GET['user']){
			$criteria=new CDbCriteria(array('order'=>'update_time DESC',
										'with'=>array('author'=>array('select'=>'username')),
			));
			$criteria->addCondition('author.username = \'' . $_GET['user'] . '\'');
			
			$dataProvider=new CActiveDataProvider('Ideas', array('criteria'=>$criteria,));
				

			$this->render('admin',array(
				'dataProvider'=>$dataProvider,
			));
			return;
		}
		$this->redirect('/ideas');
	}
	
	/**
	* List my ideas
	*/
	public function actionMyIdeas()
	{
		$this->redirect(array('/ideas/user/', 'user'=>Yii::app()->user->name));
	}
	
	/**
	* List my friends ideas
	*/
	public function actionMyFriendsIdeas()
	{
		$criteria = $this->criteria_user_friends_feed();
		
		$dataProvider=new DataProvider(	'Ideas', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												'criteria'=>$criteria,
												)
											);
		$dataProvider->joinAll = true;
		
		$this->render('index_my_friends_ideas',array('dataProvider'=>$dataProvider));
	}

	
	/**
	* Set ideas as favorite for the logged user
	*/
	public function actionAddFavorite()
	{
		$model = $this->loadModel();
		if(isset($model))
		{
			$model->user_favorites = array_merge($model->user_favorites, array(Yii::app()->user->id));
			$model->update_time_automatically = false;
			$model->save();
		}
		
		$this->redirect(array('view', 'id'=>$model->id));
	
	
	}
	
	
	/**
	* Remove ideas as favorite of the logged user
	*/
	public function actionRemoveFavorite()
	{
		$model = $this->loadModel();
		if(isset($model))
		{
			$model->user_favorites = ArrayUtils::rem_array_obj_id($model->user_favorites, Yii::app()->user->id);
			$model->update_time_automatically = false;
			$model->save();
		}
		$this->redirect(array('view', 'id'=>$model->id));
	
	}
	
	/**
	* Remove ideas as favorite of the logged user
	*/
	public function actionMyFavoritesIdeas()
	{
		
		$criteria = $this->criteria_user_favorites_feed();
		
	
		$dataProvider=new DataProvider(	'Ideas', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												'criteria'=>$criteria,
												)
											);

		$dataProvider->joinAll = true;
	
		$this->render('index_my_favorites_ideas',array('dataProvider'=>$dataProvider));
	}
	
	/**
	* List all ideas of the user
	*/
	public function actionUser()
	{
		$criteria = $this->criteria_user_feed();
	
		$dataProvider=new DataProvider(	'Ideas', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												'criteria'=>$criteria,
												)
											);

		$dataProvider->joinAll = true;
				
		$this->render('index',array('dataProvider'=>$dataProvider));
	}
	
	public function actionsearchUser()
	{
		$criteria=new CDbCriteria(array('order'=>'update_time DESC',
										'with'=>array('commentCount', 'author'),
		));
		
		if(isset($_POST['user'])){
			$criteria->addSearchCondition('author.username',$_POST['user']);
			$criteria->addCondition('t.is_public = ' . true);
			
			if(!Yii::app()->user->isGuest)
			{
				//Buscando tambien por los grupos en los cuales se encuentre el usuario
				$group_criteria = new CDbCriteria(array('select' => 'id',
													 'condition' => 'friends.friend_id=:friend_id',
													 'params' => array(':friend_id'=>Yii::app()->user->id),
													'with'=>array('friends'),
												));
			
				$belongs_group = Groups::model()->findAll($group_criteria);

				$ids_array = create_function('&$item1, $key', '$item1 = $item1->id;');
			
				array_walk($belongs_group, $ids_array);
				
				$criteria->with[] = 'groups';
				$criteria->addInCondition('groups.id', $belongs_group, 'OR');
			}
			
			
		}
	
		$dataProvider=new DataProvider(	'Ideas', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												'criteria'=>$criteria,
												)
											);

		$dataProvider->joinAll = true;
											
		$this->render('index',array('dataProvider'=>$dataProvider, 'user' => $_POST['user']));
	}
	
	/*
	* Search between comments and ideas
	*/
	public function actionSearch()
	{
		$criteria=new CDbCriteria(array('with'=>array('comments'),
										'order'=>'update_time DESC',

		));
		$criteria->addSearchCondition('t.idea',$_GET['s'], true);
		$criteria->addSearchCondition('t.tags',$_GET['s'], true,  'OR');
		$criteria->addSearchCondition('comments.content',$_GET['s'], true,  'OR');
		$criteria->addCondition('t.is_public = ' . true);
		
		if(!Yii::app()->user->isGuest)
		{
			//Buscando tambien por los grupos en los cuales se encuentre el usuario
			$group_criteria = new CDbCriteria(array('select' => 'id',
												 'condition' => 'friends.friend_id=:friend_id',
												 'params' => array(':friend_id'=>Yii::app()->user->id),
												'with'=>array('friends'),
											));
		
			$belongs_group = Groups::model()->findAll($group_criteria);

			$ids_array = create_function('&$item1, $key', '$item1 = $item1->id;');
		
			array_walk($belongs_group, $ids_array);
			
			$criteria->with[] = 'groups';
			$criteria->addInCondition('groups.id', $belongs_group, 'OR');
		}
		
		
		
		$dataProvider=new DataProvider(	'Ideas', array(
													'pagination'=>array(
														'pageSize'=>Yii::app()->params['postsPerPage'],
													),
												'criteria'=>$criteria,
												)
											);
											
		//Set new property
        $dataProvider->joinAll = true;


		$this->render('search',array('dataProvider'=>$dataProvider));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
			{
				if(Yii::app()->user->isGuest)
					$condition='status='.Ideas::STATUS_PUBLISHED.' OR status='.Ideas::STATUS_ARCHIVED;
				else
					$condition='';
				$this->_model=Ideas::model()->findbyPk($_GET['id'], $condition);
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	public function actionUserFeed()
	{
		// retrieve the latest 20 posts
		$criteria = $this->criteria_user_feed();
		$criteria->limit = 20;
		
		$feed = $this->create_feed($criteria, $_GET['user'] . ' feed');
		
		$feed->send();  
	}
	
	public function actionAllFeed()
	{
		// retrieve the latest 20 posts
		$criteria=new CDbCriteria(array('order'=>'update_time DESC',
										'with'=>array('commentCount', 'author'),
		));
		$criteria->addCondition('t.is_public = ' . true);
		$criteria->limit = 20;
		
		$feed = $this->create_feed($criteria, 'All feed');
		$feed->send();  
	}
	
	public function actionMyFriendsFeed()
	{
		// retrieve the latest 20 posts
		$criteria = $this->criteria_user_friends_feed();
		$criteria->limit = 20;
		
		$feed = $this->create_feed($criteria, 'My friends feed');
		$feed->send();  
	}
	
	public function actionMyFavoriteFeed()
	{
		// retrieve the latest 20 posts
		$criteria = $this->criteria_user_favorites_feed();
		$criteria->limit = 20;
		
		$feed = $this->create_feed($criteria, 'My favorite feed');
		$feed->send();  
	}
	
	public function actionIdeaFeed()
	{
		$idea = $this->loadModel();
		
		// convert to the format needed by Zend_Feed
		$entries=array();
		foreach($idea->comments as $comment)
		{
			$entries[]=array(
				'title'=>$comment->content,
				'link'=>$comment->getUrl(),
				'description'=>$comment->content,
				'lastUpdate'=>$comment->create_time,
			);
		}
		// generate and render RSS feed
		$feed=Zend_Feed::importArray(array(
			'title'   => $idea->idea . " comments",
			'link'    => $this->createUrl(''),
			'charset' => 'UTF-8',
			'entries' => $entries,      
		), 'rss');
		
		$feed->send(); 
		
	}
	
	public function actionConvert()
	{
		$model=new Ideas;
		
		if(isset($_GET['comment']))
		{
			$comment = Comments::model()->findByPk($_GET['comment']);
			if($comment->idea->author->id == Yii::app()->user->id || $comment->idea->is_public || $this->user_can_read_idea($comment->idea->id)){
				$model->tags=$comment->idea->tags;
				$model->idea = $comment->content;
				$model->is_public = true;
				$model->comment_id = $comment->id;
				
				if($model->save()){
					$this->redirect(array('view', 'id'=>$model->id, 'idea'=>$model->idea));
					return;
				}
			}else{
				Yii::app()->user->setFlash('message','Comment can not be reconverted.');
			
			}
		}

		$this->redirect(array('/'));
	}
		
	private function create_feed($criteria, $title)
	{
		$ideas=Ideas::model()->findAll($criteria);
		
		// convert to the format needed by Zend_Feed
		$entries=array();
		foreach($ideas as $idea)
		{
			$entries[]=array(
				'title'=>$idea->idea,
				'link'=>$this->createUrl('ideas/view',array('id'=>$idea->id)),
				'description'=>$idea->description,
				'lastUpdate'=>$idea->update_time,
			);
		}
		// generate and render RSS feed
		$feed=Zend_Feed::importArray(array(
			'title'   => $title,
			'link'    => $this->createUrl(''),
			'charset' => 'UTF-8',
			'entries' => $entries,      
		), 'rss');
		
		return $feed;
		
	}
	
	protected function newComment($idea)
	{
		$comment=new Comments;
		if(isset($_POST['Comments']))
		{
			$comment->attributes=$_POST['Comments'];
			if($idea->addComment($comment))
			{
				$idea->save();
				if($comment->status==Comments::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
	}
	
	private function user_can_read_idea($idea_id)
	{
		$criteria = $this->criteria_user_feed();
		$criteria->addCondition('t.id = ' . $idea_id);
		
		$result = Ideas::model()->find($criteria);
		
		if(!empty($result))
			return true;
			
		$criteria = $this->criteria_user_friends_feed();
		$criteria->addCondition('t.id = ' . $idea_id);
		
		$result = Ideas::model()->find($criteria);
		
		if(!empty($result))
			return true;
			
		$criteria = $this->criteria_user_favorites_feed();
		$criteria->addCondition('t.id = ' . $idea_id);
		
		$result = Ideas::model()->find($criteria);
		
		if(!empty($result))
			return true;
			
		return false;
	
	}
	
	
	private function criteria_user_feed()
	{
		$criteria=new CDbCriteria(array('order'=>'update_time DESC',
										'with'=>array('commentCount', 'author', 'groups'),
		));
		
		if(isset($_GET['user'])){
			$criteria->addCondition('author.username = \'' . $_GET['user'] . '\'');
			
			if($_GET['user'] != Yii::app()->user->name){
				$criteria->addCondition('t.is_public = ' . true);
			}
			
			if (!Yii::app()->user->isGuest)
			{
				//Buscando tambien por los grupos en los cuales se encuentre el usuario
				$group_criteria = new CDbCriteria(array('select' => 'id',
													 'condition' => 'friends.friend_id=:friend_id',
													 'params' => array(':friend_id'=>Yii::app()->user->id),
													'with'=>array('friends'),
												));
			
				$belongs_group = Groups::model()->findAll($group_criteria);

				$ids_array = create_function('&$item1, $key', '$item1 = $item1->id;');
			
				array_walk($belongs_group, $ids_array);

				$criteria->addCondition('t.is_public = ' . true);
				
				$criteria->addInCondition('groups.id', $belongs_group, 'OR');
				$criteria->addCondition('author.username = \'' . $_GET['user'] . '\'');
				
				

			}
		}
		else if (!Yii::app()->user->isGuest)
		{
			//Buscando tambien por los grupos en los cuales se encuentre el usuario
			$group_criteria = new CDbCriteria(array('select' => 'id',
												 'condition' => 'friends.friend_id=:friend_id',
												 'params' => array(':friend_id'=>Yii::app()->user->id),
												'with'=>array('friends'),
											));
		
			$belongs_group = Groups::model()->findAll($group_criteria);

			$ids_array = create_function('&$item1, $key', '$item1 = $item1->id;');
		
			array_walk($belongs_group, $ids_array);

			$criteria->addInCondition('groups.id', $belongs_group);
			
			$criteria->addCondition('t.is_public = ' . true, 'OR');

		}
		else
		{
			$criteria->addCondition('t.is_public = ' . true);
		}
		
		if(isset($_GET['tag']))
		{
			$criteria->addSearchCondition('tags',$_GET['tag']);
		}
		
		return $criteria;
	}
	
	private function criteria_user_friends_feed()
	{
		$friend_criteria = new CDbCriteria(array('select' => 'friend_id',
												 'condition' => 'user_id=:user_id',
												 'params' => array(':user_id'=> Yii::app()->user->id)
											));
		
		$friends = Friends::model()->findAll($friend_criteria);

		$ids_array = create_function('&$item1, $key', '$item1 = $item1->friend_id;');
	
		array_walk($friends, $ids_array);
		
		
		//Buscando tambien por los grupos en los cuales se encuentre el usuario
		$group_criteria = new CDbCriteria(array('select' => 'id',
											 'condition' => 'friends.friend_id=:friend_id',
											 'params' => array(':friend_id'=>Yii::app()->user->id),
											'with'=>array('friends'),
										));
	
		$belongs_group = Groups::model()->findAll($group_criteria);

		$ids_array = create_function('&$item1, $key', '$item1 = $item1->id;');
	
		array_walk($belongs_group, $ids_array);
		
		
		$criteria=new CDbCriteria(array('order'=>'update_time DESC',
										'with'=>array('commentCount', 'author', 'groups'),
		));
		$criteria->addInCondition('author.id', $friends);
		$criteria->addCondition('t.is_public = ' . true);
		
		$criteria->addInCondition('groups.id', $belongs_group, 'OR');
		
		return $criteria;
	}
	
	private function criteria_user_favorites_feed()
	{
		$user = Users::model()->findByPk(Yii::app()->user->id);
		$favorites_ideas = $user->favorites_ideas;
		$ids_array = create_function('&$item1, $key', '$item1 = $item1->id;');
	
		array_walk($favorites_ideas, $ids_array);
		
		$criteria=new CDbCriteria(array('order'=>'update_time DESC',
										'with'=>array('commentCount', 'author'),
		));
		
		
		$criteria->addInCondition('t.id', $favorites_ideas);
		
		return $criteria;
	}
}
