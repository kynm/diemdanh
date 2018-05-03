<?php

namespace app\controllers;

use Yii;
use app\models\Noidungcongviec;
use app\models\NoidungcongviecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoidungcongviecController implements the CRUD actions for Noidungcongviec model.
 */
class NoidungcongviecController extends Controller
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
     * Lists all Noidungcongviec models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoidungcongviecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Noidungcongviec model.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @param integer $ID_NHANVIEN
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN),
        ]);
    }

    /**
     * Creates a new Noidungcongviec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Noidungcongviec();

        if ($model->load(Yii::$app->request->post())) {
            $model->TRANGTHAI = 'Kế hoạch';
            $model->save();
            // return $this->redirect(['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG, 'ID_NHANVIEN' => $model->ID_NHANVIEN]);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Noidungcongviec model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @param integer $ID_NHANVIEN
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN)
    {
        $model = $this->findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG, 'ID_NHANVIEN' => $model->ID_NHANVIEN]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Noidungcongviec model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @param integer $ID_NHANVIEN
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN)
    {
        $this->findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN)->delete();

        return $this->redirect(['index']);
    }


    /**
     * API to create new Noidungcongviec model with url.
     * @return mixed
     */
    public function actionCreatePost($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN)
    {
        $model = new Noidungcongviec();
        $model->ID_DOTBD = $ID_DOTBD;
        $model->ID_THIETBI = $ID_THIETBI;
        $model->MA_NOIDUNG = $MA_NOIDUNG;
        $model->ID_NHANVIEN = $ID_NHANVIEN;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Noidungcongviec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @param integer $ID_NHANVIEN
     * @return Noidungcongviec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN)
    {
        if (($model = Noidungcongviec::findOne(['ID_DOTBD' => $ID_DOTBD, 'ID_THIETBI' => $ID_THIETBI, 'MA_NOIDUNG' => $MA_NOIDUNG, 'ID_NHANVIEN' => $ID_NHANVIEN])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
