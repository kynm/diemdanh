<?php

namespace app\controllers;

use Yii;
use app\models\Ketqua;
use app\models\KetquaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KetquaController implements the CRUD actions for Ketqua model.
 */
class KetquaController extends Controller
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
     * Lists all Ketqua models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KetquaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ketqua model.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @return mixed
     */
    public function actionView($ID_DOTBD, $ID_THIETBI)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID_DOTBD, $ID_THIETBI),
        ]);
    }

    /**
     * Creates a new Ketqua model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ketqua();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ketqua model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @return mixed
     */
    public function actionUpdate($ID_DOTBD, $ID_THIETBI)
    {
        $model = $this->findModel($ID_DOTBD, $ID_THIETBI);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ketqua model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @return mixed
     */
    public function actionDelete($ID_DOTBD, $ID_THIETBI)
    {
        $this->findModel($ID_DOTBD, $ID_THIETBI)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ketqua model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @return Ketqua the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_DOTBD, $ID_THIETBI)
    {
        if (($model = Ketqua::findOne(['ID_DOTBD' => $ID_DOTBD, 'ID_THIETBI' => $ID_THIETBI])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
