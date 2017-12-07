<?php

namespace app\controllers;

use Yii;
use app\models\Dotbaoduong;
use app\models\DotbaoduongSearch;
use app\models\Kehoachbdtb;
use app\models\KehoachbdtbSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DotbaoduongController implements the CRUD actions for Dotbaoduong model.
 */
class DotbaoduongController extends Controller
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
     * Lists all Dotbaoduong models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DotbaoduongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dotbaoduong model.
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
     * Creates a new Dotbaoduong model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dotbaoduong();

        if ($model->load(Yii::$app->request->post())) {
            // print_r($model);
            // die;
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->ID_DOTBD]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dotbaoduong model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID_DOTBD]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dotbaoduong model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionKehoach($id)
    {
        $kehoachs = [new Kehoachbdtb()];
            // print_r(Yii::$app->request->post('Kehoachbdtb'));
            // Kehoachbdtb::loadMultiple($kehoachs, Yii::$app->request->post());
            // print_r($kehoachs);
            // die;
        if ($kehoachs = Yii::$app->request->post('Kehoachbdtb')) {
            foreach ($kehoachs as $each) {
                if (Kehoachbdtb::find()->where($each)->exists()) continue;

                $kehoach = new Kehoachbdtb();
                $kehoach->ID_DOTBD = $id;
                $kehoach->ID_THIETBI = $each['ID_THIETBI'];
                $kehoach->MA_NOIDUNG = $each['MA_NOIDUNG'];
                $kehoach->ID_NHANVIEN = $each['ID_NHANVIEN'];
                $kehoach->save();
            }
        }
        $searchModel = new KehoachbdtbSearch();
        $dataProvider = $searchModel->searchND(Yii::$app->request->queryParams);
        $kehoachModel = new Kehoachbdtb();
        return $this->render('kehoach', [
            'kehoachModel' => $kehoachModel,
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionThuchien($id)
    {
        $dotbd = Dotbaoduong::find()->where(['ID_DOTBD' => $id])->one();
        if ($dotbd->TRANGTHAI == 'Kế hoạch') {
            $dotbd->TRANGTHAI = 'Đang thực hiện';
            $dotbd->save();

            $noidungkehoachs = Kehoachbdtb::find()->where(['ID_DOTBD' => $id]);
            foreach ($noidungkehoachs as $noidungkehoach) {
                # code...
            }
        }
        $kehoachs = [new Kehoachbdtb()];
            // print_r(Yii::$app->request->post('Kehoachbdtb'));
            // Kehoachbdtb::loadMultiple($kehoachs, Yii::$app->request->post());
            // print_r($kehoachs);
            // die;
        if ($kehoachs = Yii::$app->request->post('Kehoachbdtb')) {
            foreach ($kehoachs as $each) {
                if (Kehoachbdtb::find()->where($each)->exists()) continue;

                $kehoach = new Kehoachbdtb();
                $kehoach->ID_DOTBD = $id;
                $kehoach->ID_THIETBI = $each['ID_THIETBI'];
                $kehoach->MA_NOIDUNG = $each['MA_NOIDUNG'];
                $kehoach->ID_NHANVIEN = $each['ID_NHANVIEN'];
                $kehoach->save();
            }
        }
        $searchModel = new KehoachbdtbSearch();
        $dataProvider = $searchModel->searchND(Yii::$app->request->queryParams);
        $kehoachModel = new Kehoachbdtb();
        return $this->render('kehoach', [
            'kehoachModel' => $kehoachModel,
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Dotbaoduong model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dotbaoduong the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dotbaoduong::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
