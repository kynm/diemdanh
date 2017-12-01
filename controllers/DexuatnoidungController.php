<?php

namespace app\controllers;

use Yii;
use app\models\Dexuatnoidung;
use app\models\DexuatnoidungSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DexuatnoidungController implements the CRUD actions for Dexuatnoidung model.
 */
class DexuatnoidungController extends Controller
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
     * Lists all Dexuatnoidung models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DexuatnoidungSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dexuatnoidung model.
     * @param integer $ID_LOAITB
     * @param string $LAN_BD
     * @param string $MA_NOIDUNG
     * @return mixed
     */
    public function actionView($ID_LOAITB, $LAN_BD, $MA_NOIDUNG)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID_LOAITB, $LAN_BD, $MA_NOIDUNG),
        ]);
    }

    /**
     * Creates a new Dexuatnoidung model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new \yii\base\DynamicModel(['ID_LOAITB','LAN_BD','CHUKYBAODUONG','MA_NOIDUNG']);
        // $model->attributeLabel(
        //     return ['ID_LOAITB'=>'Loại thiết bị','LAN_BD' => 'Lần bảo dưỡng','CHUKYBAODUONG'=>'Chu kỳ bảo dưỡng','MA_NOIDUNG'=>'Mã nội dung']);
        $model->addRule(['ID_LOAITB'], 'string')
            ->addRule(['LAN_BD', 'CHUKYBAODUONG', 'MA_NOIDUNG'], 'string', ['max'=>32])
            ->validate();
        
        if ($model->load(Yii::$app->request->post())) {
            $listNoidung = $model->MA_NOIDUNG;
            foreach ($listNoidung as $noidung) {
                $exists = Dexuatnoidung::find()->where( [ 'ID_LOAITB' => $model->ID_LOAITB, 'LAN_BD' => $model->LAN_BD, 'MA_NOIDUNG' => $noidung ] )->exists();
                if(!$exists) {
                    $noidungModel = new Dexuatnoidung();
                    $noidungModel->ID_LOAITB = $model->ID_LOAITB;
                    $noidungModel->LAN_BD = $model->LAN_BD;
                    $noidungModel->CHUKYBAODUONG = $model->CHUKYBAODUONG;
                    $noidungModel->MA_NOIDUNG = $noidung;
                    $noidungModel->save();                
                } else {
                    continue;
                }
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dexuatnoidung model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_LOAITB
     * @param string $LAN_BD
     * @param string $MA_NOIDUNG
     * @return mixed
     */
    public function actionUpdate($ID_LOAITB, $LAN_BD, $MA_NOIDUNG)
    {
        $model = $this->findModel($ID_LOAITB, $LAN_BD, $MA_NOIDUNG);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID_LOAITB' => $model->ID_LOAITB, 'LAN_BD' => $model->LAN_BD, 'MA_NOIDUNG' => $model->MA_NOIDUNG]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dexuatnoidung model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_LOAITB
     * @param string $LAN_BD
     * @param string $MA_NOIDUNG
     * @return mixed
     */
    public function actionDelete($ID_LOAITB, $LAN_BD, $MA_NOIDUNG)
    {
        $this->findModel($ID_LOAITB, $LAN_BD, $MA_NOIDUNG)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dexuatnoidung model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_LOAITB
     * @param string $LAN_BD
     * @param string $MA_NOIDUNG
     * @return Dexuatnoidung the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_LOAITB, $LAN_BD, $MA_NOIDUNG)
    {
        if (($model = Dexuatnoidung::findOne(['ID_LOAITB' => $ID_LOAITB, 'LAN_BD' => $LAN_BD, 'MA_NOIDUNG' => $MA_NOIDUNG])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
