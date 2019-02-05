<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);
        /*if(Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException();
        }
        */
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        //$model -> creator_id = 1;
        //$model -> created_at = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function testIndex()
    {
        $user1 = new User();
        $user1->username = '111';
        $user1->password_hash = 'qqq';
        $user1->auth_key = 'eeee';
        $user1->save();
    }
    /*
      public function actionTest() {
        $newUser = new User();
        $newUser->username = 'Vova';
        $newUser->password_hash = '12345';
        $newUser->created_at = time();
        $newUser->creator_id = User::findOne(['username' => 'Admin'])->getAttribute('id');
        $newUser->save();
        _log($newUser);
        //метод link().
        $description = 'Some description';
        $user = User::findOne(['username' => 'Vova']);
        $task_1 = new Task();
        $task_1->title = 'Vova task #1';
        $task_1->description = $description;
        $task_1->link(Task::RELATION_CREATOR, $user);
        _log($task_1);
        $task_2 = new Task();
        $task_2->title = 'Vova task #2';
        $task_2->description = $description;
        $task_2->link(Task::RELATION_CREATOR, $user);
        _log($task_2);
        $task_3 = new Task();
        $task_3->title = 'Vova task #3';
        $task_3->description = $description;
        $task_3->link(Task::RELATION_CREATOR, $user);
        _log($task_3);
        //жадная подгрузка без JOIN.
        $models = User::find()->with(User::RELATION_ACCESSED_TASKS)->all();
        _log($models);
        //c JOIN.
        $models = User::find()->joinWith(User::RELATION_ACCESSED_TASKS)->all();
        _log($models);
        //6)  связь между записями в User и Task.
        $admin = User::findOne(['username' => 'Admin']);
        $tasks = Task::findAll([6, 7, 8, 9]);
        foreach ($tasks as $task) {
            $admin->link(User::RELATION_ACCESSED_TASKS, $task);
        }

     */
}
