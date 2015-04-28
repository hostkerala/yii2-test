<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\data\ActiveDataProvider;
use common\filters\AccessRules;
use yii\db\Query;
use yii\helpers\Json;

/**
* Created By Roopan v v <yiioverflow@gmail.com>
* Date : 24-04-2015
* Time :3:00 PM
* SiteController
*/

class SiteController extends Controller
{
    public $defaultAction = 'users';
    
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
                        'actions' => ['users','skills'],
                        'allow' => true,
                        'roles' => ['@','admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],            
        ];                
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 24-04-2015
    * Time :3:00 PM
    * Lists all users
    */
    public function actionUsers()
    {  
        $query = \common\models\User::find();        
        $dataProvider = new ActiveDataProvider([
                            'query' =>$query,
                            'pagination' => false
                        ]);
        if (Yii::$app->request->get('skill')) {
                $skill = \common\models\Skill::find()
                            ->where(['id' => Yii::$app->request->get('skill')])
                            ->one();
                if ($skill) {
                        $query->joinWith('relUserSkills');  
                        $query->andFilterWhere(['skill_id' => $skill->id]);
                }
        }
        return $this->render('users/index', array('dataProvider' => $dataProvider));
    }
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 24-04-2015
    * Time :3:00 PM
    * Autocomplete suggest options
    */

    public function actionSkills()
    {         
        $result = [];
        $query = new Query;
        if (isset($_GET['term'])) 
        {
            $query->select('name')
                        ->from('skill')
                        ->andWhere(['like', 'name', $_GET['term']]);                  
            $result = $query->all();
        }        
        echo Json::encode($result);
        Yii::$app->end(); 
    }
    
}
