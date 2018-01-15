<?php

namespace app\controllers;

use Yii;
use app\models\Thietbitram;
use app\models\Noidungbaotri;
use app\models\NoidungbaotriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * NoidungbaotriController implements the CRUD actions for Noidungbaotri model.
 */
class NoidungbaotriController extends Controller
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
     * Lists all Noidungbaotri models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoidungbaotriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Noidungbaotri model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Noidungbaotri model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-noidungbaotri')) {
            # code...
            $model = new Noidungbaotri();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->MA_NOIDUNG]);
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

    /**
     * Updates an existing Noidungbaotri model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('edit-noidungbaotri')) {
            # code...
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->MA_NOIDUNG]);
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
     * Deletes an existing Noidungbaotri model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-noidungbaotri')) {
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
        $noidung = Noidungbaotri::find()
        ->where(['ID_THIETBI'=>$id])
        ->all();

        if(isset($noidung) && count($noidung)>0) {
            foreach($noidung as $each) {
                echo "<label><input type=\"checkbox\" name=\"DynamicModel[MA_NOIDUNG][]\" value=".$each->MA_NOIDUNG."> ".$each->NOIDUNG."</label> <br>" ;
            }
        }else {
            echo "-";
        }
    }

    public function actionListstbt($id)
    {
        $tbi = Thietbitram::find()->where(['ID_THIETBI' => $id])->one();
        $noidung = Noidungbaotri::find()
        ->where(['ID_THIETBI'=>$tbi->ID_LOAITB])
        ->all();

        if(isset($noidung) && count($noidung)>0) {
            foreach($noidung as $each) {
                echo "<option value='".$each->MA_NOIDUNG."'>".$each->NOIDUNG."</option>";
            }
        }else {
            echo "-";
        }
    }

    /**
     * Finds the Noidungbaotri model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Noidungbaotri the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Noidungbaotri::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
