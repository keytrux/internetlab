<?php

namespace app\controllers;
use Yii;
use app\models\User;
use app\models\UserSearch;
use app\models\RegForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller
{
    public function beforeAction($action)
    {
        if(Yii::$app->user->isGuest || Yii::$app->user->identity->role != "admin")
        {
            $this->redirect(['/site/login']);
            return false;
        }
        if(!parent::beforeAction($action))
        {
            return false;
        }
        return true;
    }
    
    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
