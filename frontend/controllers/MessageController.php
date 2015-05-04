<?php

namespace frontend\controllers;
use common\models\Topic;
use common\models\Comments;
use yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use common\filters\AccessRules;


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
                        'actions' => ['index','list'],
                        'allow' => true,
                        'roles' => ['@','admin'],
                    ],
                ],
            ],           
        ];                
    }    
    

    public function actionIndex()
    {
        $commentForm = new Comments;
        
        if ($commentForm->load(Yii::$app->request->post())) 
        {           
            $commentForm->content = Html::encode($commentForm->content);
            $commentForm->userId = Yii::$app->user->id;
            $commentForm->createdAt = date( 'Y-m-d H:i:s');
            $commentForm->save();
            $commentForm = new Comments;
        }
        
        $topicId = Yii::$app->request->get('id');
        $model = Topic::find()
            ->where(['id'=>$topicId])
            ->one();
        
        return $this->render('index',['model'=>$model,'commentForm'=>$commentForm]);
    }

    public function actionList()
    {        
        $topicId = Yii::$app->request->get('id');
        $model = Topic::find()
            ->where(['id'=>$topicId])
            ->one();
        
        return $this->renderAjax('_message',['model'=>$model]);
    }
}
