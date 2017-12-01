<?php

namespace app\controllers;

use Yii;
use app\models\Kehoachbdtb;
use app\models\KehoachbdtbSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KehoachbdtbController implements the CRUD actions for Kehoachbdtb model.
 */
class KehoachbdtbController extends Controller
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
     * Lists all Kehoachbdtb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KehoachbdtbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kehoachbdtb model.
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
     * Creates a new Kehoachbdtb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kehoachbdtb();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Kehoachbdtb model.
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
     * Deletes an existing Kehoachbdtb model.
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
     * Finds the Kehoachbdtb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @return Kehoachbdtb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG)
    {
        if (($model = Kehoachbdtb::findOne(['ID_DOTBD' => $ID_DOTBD, 'ID_THIETBI' => $ID_THIETBI, 'MA_NOIDUNG' => $MA_NOIDUNG])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
