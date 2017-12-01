<?php

namespace app\controllers;

use Yii;
use app\models\Thuchienbd;
use app\models\ThuchienbdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ThuchienbdController implements the CRUD actions for Thuchienbd model.
 */
class ThuchienbdController extends Controller
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
     * Lists all Thuchienbd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThuchienbdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Thuchienbd model.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @return mixed
     */
    public function actionView($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG),
        ]);
    }

    /**
     * Creates a new Thuchienbd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Thuchienbd();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Thuchienbd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @return mixed
     */
    public function actionUpdate($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG)
    {
        $model = $this->findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Thuchienbd model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @return mixed
     */
    public function actionDelete($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG)
    {
        $this->findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Thuchienbd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @return Thuchienbd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG)
    {
        if (($model = Thuchienbd::findOne(['ID_DOTBD' => $ID_DOTBD, 'ID_THIETBI' => $ID_THIETBI, 'MA_NOIDUNG' => $MA_NOIDUNG])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
