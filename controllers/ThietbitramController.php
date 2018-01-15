<?php

namespace app\controllers;

use Yii;
use app\models\Tramvt;
use app\models\Thietbitram;
use app\models\ThietbitramSearch;
use app\models\Dotbaoduong;
use app\models\Thietbi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * ThietbitramController implements the CRUD actions for Thietbitram model.
 */
class ThietbitramController extends Controller
{
    /**
     * @inheritdoc
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
        ];
    }

    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }

    /**
     * Lists all Thietbitram models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThietbitramSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Thietbitram model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Thietbitram model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-tbitram')) {
            $model = new Thietbitram();

            if ($model->load(Yii::$app->request->post())) {
                // print_r($model);
                // die;
                $model->save();
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException;            
        }
    }

    public function actionCreatePost()
    {
        $model = new Thietbitram();
        $model->load(Yii::$app->request->queryParams);
        $model->save();
        print_r($model->ID_LOAITB);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing Thietbitram model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('edit-tbitram')) {
            # code...
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->ID_THIETBI]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            # code...
            throw new ForbiddenHttpException;            
        }
    }

    /**
     * Deletes an existing Thietbitram model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-tbitram')) {
            # code...
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            # code...
            throw new ForbiddenHttpException;            
        }
    }

    public function actionLists($id)
    {
        $dotbaoduong = Dotbaoduong::find()
        ->where(['ID_DOTBD'=>$id])
        ->one();

        $thietbi = Thietbitram::find()
        ->where(['ID_TRAM' => $dotbaoduong->ID_TRAMVT])
        ->all();

        if(isset($thietbi) && count($thietbi)>0) {
            echo "<option>Chọn thiết bị</option>";
            foreach($thietbi as $each) {
                $loaitb = Thietbi::find()
                ->where(['ID_THIETBI' => $each->ID_LOAITB])
                ->one();
                echo "<option value='".$each->ID_THIETBI."'>".$each->iDLOAITB->TEN_THIETBI."</option>";
            }
        }else {
            echo "-";
        }
    }


    /**
     * Finds the Thietbitram model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Thietbitram the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Thietbitram::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
