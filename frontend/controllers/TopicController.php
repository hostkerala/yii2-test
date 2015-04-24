<?php

namespace frontend\controllers;

use Yii;
use common\models\Topic;
use common\models\TopicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Html;

use yii\db\Query;
use yii\data\ActiveDataProvider;
use \yii\filters\AccessControl;
use common\filters\AccessRules;
use yii\data\SqlDataProvider;


/**
 * TopicController implements the CRUD actions for Topic model.
 */
class TopicController extends Controller
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
                        'actions' => ['index','view','create','update','delete','list'],
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
     * Lists all Topic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TopicSearch();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Topic model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $comment = new \common\models\Comments;
        $model = \common\models\Topic::find()->where(['id'=>$id])->one();
        $postComment = $comment->isAbletoComment(Yii::$app->user->id,$id);
        if ($comment->load(Yii::$app->request->post())) {
                if((Yii::$app->user->id != $model->user_id) || (Yii::$app->user->identity->isAdmin)){
                        $comment->content = Html::encode($comment->content);
                        $comment->userId = Yii::$app->user->id;
                        $comment->createdAt = date( 'Y-m-d H:i:s');
                        if ($comment->save())
                        {
                                $this->redirect(Url::to(['topic/view','id'=>$id]));
                        }
                }  
        }
        
        
        $sql = "SELECT * FROM topic WHERE user_id = :user_id AND id <> :id AND topic_end >= UNIX_TIMESTAMP(CURDATE())";
        
        $count = Yii::$app->db->createCommand($sql,[':user_id'=>$model->user_id,':id'=>$model->id])->queryScalar();
        
        $authorTopics = new SqlDataProvider([
            'sql' => $sql,
            'params' => [':user_id'=>$model->user_id,':id'=>$model->id],
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                    'name' => [
                        'desc' => ['id' => SORT_DESC],
                    ],
                ],
            ],
            'pagination' => false,
        ]);

        return $this->render('view', ['model' => $model, 'comment' => $comment, 'postComment'=>$postComment, 'authorTopics'=>$authorTopics]);
    }

    /**
     * Creates a new Topic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Topic();
        if ($model->load(Yii::$app->request->post())) {
            
            $model->user_id = Yii::$app->user->id;
            if($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Topic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            $model->topic_end=Yii::$app->formatter->asDate($model->topic_end, "yyyy-MM-dd");
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Topic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $topic = $this->findModel($id);
        
        foreach($topic->comments as $comments)
        {
            $comments->delete();
        }
        
        $topic->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Topic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Topic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Topic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
    * Created By Roopan v v <yiioverflow@gmail.com>
    * Date : 03-04-2015
    * Time :10:00 PM
    * Ajaxt Function which updates the comments list in a specific time interval
    */
    public function actionList($id)
    {
            $model = \common\models\Topic::find()->where(['id'=>$id])->one();
            echo $this->renderAjax('comments/_list',['model'=>$model]);
            yii::$app->end();

    }    
}
