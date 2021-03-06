<?php

namespace frontend\controllers;
use common\models\Profile;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use Yii;
use yii\filters\AccessControl;
use common\filters\AccessRules;
use yii\helpers\Url;

use dektrium\user\controllers\SettingsController as BaseSettingsController;

/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 24-04-2015
* Time :3:00 PM
* UserController.
*/

class UserController extends BaseSettingsController
{
    
        
    /**
     * @inheritdoc
     */
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
                        'actions' => ['city','states','profile','account','remove'],
                        'allow' => true,
                        'roles' => ['@','admin'],
                    ],
                ],
            ],           
        ];                
    }
    
    
    /**
     * Created By Roopan v v <yiioverflow@gmail.com>
     * Date : 24-04-2015
     * Time :3:00 PM
     * Displays the user profile page.
     */
    
    public function actionProfile()
    {
        $model = Profile::find()
                    ->where(['id'=>Yii::$app->user->id])
                    ->one();

        $this->performAjaxValidation($model);
        
        if ($model->load(Yii::$app->request->post()))
        {           
            $file = \yii\web\UploadedFile::getInstanceByName('Profile[avatar]');
            
            if(isset($file->name))
            {
                    $time = time();
                    $model->avatar = yii::$app->user->id.$time.".jpg";
            }
                  
            if($model->save()) 
            {         
                if(isset($file->name))
                {
                    $path = Yii::$app->params['uploadPath'] . yii::$app->user->id.$time.".jpg";
                    if(file_exists($path)) { unlink ($path); }
                    $file->saveAs($path);
                }
                Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Your profile has been updated'));
                return $this->refresh();
            }
        }
        
        return $this->render('profile', [
            'model' => $model,
        ]);
    }
    
     /**
     * Created By Roopan v v <yiioverflow@gmail.com>
     * Date : 24-04-2015
     * Time :3:00 PM
     * Returns the states dropdown data for profile page.
     */
    
    public function actionStates()
    {
        $out = [];
        
        if (isset($_POST['depdrop_parents'])) 
        {            
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $country_id = $parents[0];
                $out=\common\models\States::find()
                        ->where(['country_id'=>$country_id])
                        ->all();
                
                $result = [];
                
                if(!empty($out))
                {
                    foreach($out as $states):
                    $result[] = ['id'=>$states->id,'name'=>$states->state_name_en]; 
                    endforeach;
                    
                }
                
                echo Json::encode(['output'=>$result, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    
    
     /**
     * Created By Roopan v v <yiioverflow@gmail.com>
     * Date : 24-04-2015
     * Time :3:00 PM
     * Returns the cities dropdown data for profile page.
     */
    
    public function actionCity()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $country_id = empty($ids[0]) ? null : $ids[0];
            $state_id = empty($ids[1]) ? null : $ids[1];
            if ($country_id != null) {
                $data=\common\models\Zipareas::find()
                        ->where(['state'=>$state_id])
                        ->all();
                
                if(!empty($data))
                {
                    foreach($data as $city):
                    $result[] = ['id'=>$city->id,'name'=>$city->city]; 
                    endforeach;
                }
                
               echo Json::encode(['output'=>$result, 'selected'=>'']);
               return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }    
    
    /**
     * Displays page where user can update account settings (username, email or password).
     * @return string|\yii\web\Response
     */
    public function actionAccount()
    {
        /** @var SettingsForm $model */
        $model = \Yii::createObject(\dektrium\user\models\SettingsForm::className());

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('user', 'Your account details have been updated'));
            return $this->refresh();
        }

        return $this->render('account', [
            'model' => $model,
        ]);
    }    
    
    
     /**
     * Created By Roopan v v <yiioverflow@gmail.com>
     * Date : 24-04-2015
     * Time :3:00 PM
     * Removes the profile picture
     */
    
    public function actionRemove($id) 
    {       
        $model = Profile::find()
                    ->where(['id'=>Yii::$app->user->id])
                    ->one();
        
        $model->skills = $model->getUserSkills(Yii::$app->user->id);
        $image = Yii::$app->params['uploadPath'].$model->avatar;
        
        if (unlink($image)) {
            $model->avatar = null;
            $model->save(false);
        }
        
        return $this->redirect(Url::to(['/user/settings/profile']));
    }      
}

