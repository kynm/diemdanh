<?php

namespace app\controllers;

use Yii;
use app\models\Thietbitram;
use app\models\ThietbitramSearch;
use app\models\Nhanvien;
use app\models\Daivt;
use app\models\Tramvt;
use app\models\TramvtSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;

/**
 * TramvtController implements the CRUD actions for Tramvt model.
 */
class TramvtController extends Controller
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

    /**
     * Lists all Tramvt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TramvtSearch();
        $listTram = array();
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        switch (Yii::$app->user->identity->role) {
            //role 1,2 danh cho IT va CB VTT xem toan bo cac tram
            case '1':            
            case '2':
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                break;
            
            //role 3 danh cho quan ly trung tam quan ly cac tram cua trung tam minh
            case '3':
                $listDai = Daivt::find()->where(['ID_DONVI' => $nhanvien->ID_DONVI])->all();
                foreach ($listDai as $dai) {
                    foreach ($dai->tramvts as $tram) {
                        $listTram[] = $tram;
                    }
                }
                $dataProvider = new ArrayDataProvider([
                    'allModels' => $listTram,
                    'sort' => [
                        'attributes' => ['MA_TRAM', 'DIADIEM', 'ID_DAIVT', 'ID_NHANVIEN'],
                    ],
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
                break;
            
            //role 4 danh cho truong dai quan ly cac tram thuoc dai minh
            case '4':
                $listTram = Tramvt::find()->where(['ID_DAIVT' => $nhanvien->ID_DAIVT])->all();
                
                $dataProvider = new ArrayDataProvider([
                    'allModels' => $listTram,
                    'sort' => [
                        'attributes' => ['MA_TRAM', 'DIADIEM', 'ID_DAIVT', 'ID_NHANVIEN'],
                    ],
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
                break;
            
            //role 5 danh cho quan ly tram quan ly cac tram do minh quan ly
            case '5':
                $listTram = Tramvt::find()->where(['ID_NHANVIEN' => $nhanvien->ID_NHANVIEN])->all();
                
                $dataProvider = new ArrayDataProvider([
                    'allModels' => $listTram,
                    'sort' => [
                        'attributes' => ['MA_TRAM', 'DIADIEM', 'ID_DAIVT', 'ID_NHANVIEN'],
                    ],
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
                break;
            
            default:
                return $this->redirect('site/index');
                break;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tramvt model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new ThietbitramSearch();
        $query = Thietbitram::find()->where(['ID_TRAM' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Tramvt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tramvt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID_TRAM]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tramvt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID_TRAM]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tramvt model.
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
     * Finds the Tramvt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tramvt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tramvt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
