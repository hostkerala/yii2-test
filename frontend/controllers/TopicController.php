<?php

namespace frontend\controllers;

use Yii;
use common\models\Topic;
use frontend\models\TopicSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Html;

use yii\db\Query;
use yii\data\ActiveDataProvider;

/**
 * TopicController implements the CRUD actions for Topic model.
 */
class TopicController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
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
                if(true)//(Yii::$app->user->id != $model->user_id) || (Yii::$app->user->identity->isAdmin)){
                        $comment->content = Html::encode($comment->content);
                        $comment->userId = Yii::$app->user->id;
                        $comment->createdAt = date( 'Y-m-d H:i:s');
                        if ($comment->save())
                        {
                                $this->redirect(Url::to(['topic/view','id'=>$id]));
                        }
                }        
        $query = new Query;
        
        $authorTopics = new ActiveDataProvider([
            'query' => $query->from('Topic')->orderBy('id desc')->where("user_id=$model->user_id AND id <> $model->id AND topic_end >= UNIX_TIMESTAMP(CURDATE())"),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('view', array('model' => $model, 'comment' => $comment, 'postComment'=>$postComment, 'authorTopics'=>$authorTopics));

    }

    /**
     * Creates a new Topic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Topic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
            return $this->redirect(['view', 'id' => $model->id]);
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
        $this->findModel($id)->delete();

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
}
