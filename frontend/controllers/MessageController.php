<?php

namespace frontend\controllers;
use common\models\Topic;
use common\models\Comments;
use yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use common\filters\AccessRules;

/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 05-05-2015
* Time :2:00 AM
* TopicController.
*/

class MessageController extends \yii\web\Controller
{
    
    public function behaviors()
    {        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRules::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index','list','inbox','inboxlist','sent','sentlist'],
                        'allow' => true,
                        'roles' => ['@','admin'],
                    ],
                ],
            ],           
        ];                
    }

    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 05-05-2015
    * Time :2:00 AM
    * Displays the Messages of a perticular Topic
    */ 
    
    public function actionIndex()
    {
        $commentForm = new Comments;
        
        if ($commentForm->load(Yii::$app->request->post())) 
        {           
            
            $file = \yii\web\UploadedFile::getInstanceByName('Comments[attach_file]');
           
            $commentForm->content = Html::encode($commentForm->content);
            $commentForm->userId = Yii::$app->user->id;
            $commentForm->createdAt = date( 'Y-m-d H:i:s');
            
            if(isset($file->name))
            {
                    $time = time();
                    $commentForm->attach_file = $time.".pdf";
            }
            
            if($commentForm->save()) 
            {         
                if(isset($file->name))
                {
                    $path = Yii::$app->params['uploadPath'] ."messages".DIRECTORY_SEPARATOR.$time.".pdf";
                    if(file_exists($path)) { unlink ($path); }
                    $file->saveAs($path);
                }
                Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your Message sent successfuly'));
                return $this->refresh();
            }  
            $commentForm = new Comments;
        }
        
        $topicId = Yii::$app->request->get('id');
        $model = Topic::find()
            ->where(['id'=>$topicId])
            ->one();        
        return $this->render('index',['model'=>$model,'commentForm'=>$commentForm]);
    }
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 05-05-2015
    * Time :2:00 AM
    * Ajax update of Messages
    */
    
    public function actionList()
    {        
        $topicId = Yii::$app->request->get('id');
        $model = Topic::find()
            ->where(['id'=>$topicId])
            ->one();
        
        return $this->renderAjax('_message',['model'=>$model]);
    }
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 05-05-2015
    * Time :2:00 AM
    * Displays the Inbox page
    */
    
    public function actionInbox()
    {
        $model = Topic::find()
            ->joinWith('comments')
            ->where(['user_id'=>yii::$app->user->id])
            ->orderBy('created_at DESC')                
            ->all();
         return $this->render('inbox',['model'=>$model]);
    }  

    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 05-05-2015
    * Time :2:00 AM
    * Ajax update of Inbox Page
    */
    
    public function actionInboxlist()
    {
        $topic = new Topic;
        $model = $topic->find()
                    ->where(['user_id'=>yii::$app->user->id])
                    ->orderBy('created_at DESC')
                    ->all();
        return $this->renderAjax('_inbox_messages',['model'=>$model]);
    }
    

    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 15-05-2015
    * Time :8:16 PM
    * Displays the Sent Page
    */
    
    public function actionSent()
    {
        $model = Topic::find()
            ->joinWith('comments')
            ->where(['comments.userId'=>yii::$app->user->id])
            ->orderBy('created_at DESC')                
            ->all();
         return $this->render('sent',['model'=>$model]);
    }  

    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 15-05-2015
    * Time :8:16 PM
    * Ajax update of Sent Page
    */
    
    public function actionSentlist()
    {
        $topic = new Topic;
        $model = $topic->find()
                    ->where(['comments.userId'=>yii::$app->user->id])
                    ->orderBy('created_at DESC')
                    ->all();
        return $this->renderAjax('_sent_messages',['model'=>$model]);
    }      
}
