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
            return $this->redirect(['update', 'id' => $user->id]);
        }

        return $this->render('create', [
            'user' => $user
        ]);
    }

    /**
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
}
