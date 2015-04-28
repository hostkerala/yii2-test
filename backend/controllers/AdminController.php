<?php

namespace backend\controllers;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use Yii;
use yii\filters\AccessControl;
use common\filters\AccessRules;
use yii\helpers\Url;

use dektrium\user\controllers\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{    
    
     /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var User $user */
        $user = Yii::createObject([
            'class'    => \common\models\User::className(),
            'scenario' => 'create',
        ]);

        $this->performAjaxValidation($user);
        

        if ($user->load(Yii::$app->request->post()) && $user->create()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been created'));
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'user' => $user
        ]);
    }

     /**
     * Created By Roopan v v <yiioverflow@gmail.com>
     * Date : 24-04-2015
     * Time :3:00 PM
     * Updates an existing User model.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);
        $user->scenario = 'update';

        $this->performAjaxValidation($user);

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Account details have been updated'));
            return $this->refresh();
        }

        return $this->render('_account', [
            'user'    => $user,
        ]);
    }
    
     /**
     * Created By Roopan v v <yiioverflow@gmail.com>
     * Date : 24-04-2015
     * Time :3:00 PM
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($id == Yii::$app->user->getId()) {
            Yii::$app->getSession()->setFlash('danger', Yii::t('user', 'You can not remove your own account'));
        } else {
            
            $model = $this->findModel($id);
            
            if($model->comments)
            {
                foreach($model->comments as $comment)
                {
                    $comment->delete();
                }
                
            }
            
            if($model->relUserSkills)
            {
                foreach($model->relUserSkills as $relSkills)
                {
                    $relSkills->delete();
                }
            }            
           
            $userTopics = \common\models\Topic::find()->where(['user_id'=>$id])->all();
            if($userTopics)
            {
                foreach($userTopics as $topic)
                {
                    Yii::$app->db->createCommand("DELETE from rel_topic_skills where topic_id = :topic_id")->bindValues([':topic_id'=>$topic->id])->execute();
                    Yii::$app->db->createCommand("DELETE from comments where topicId = :topic_id")->bindValues([':topic_id'=>$topic->id])->execute();
                }                
                Yii::$app->db->createCommand("DELETE from topic where user_id = :user_id")->bindValues([':user_id'=>$id])->execute();
            }
            
            $model->delete();
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'User has been deleted'));
        }
        
        return $this->redirect(['index']);
    }
}
