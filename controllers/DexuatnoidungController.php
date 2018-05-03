<?php

namespace app\controllers;

use Yii;
use app\models\Thietbi;
use app\models\Noidungbaotri;
use app\models\Dexuatnoidung;
use app\models\DexuatnoidungSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

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
     * @param string $LANBD
     * @param string $MA_NOIDUNG
     * @return mixed
     */
    public function actionView($ID_LOAITB, $LANBD, $MA_NOIDUNG)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID_LOAITB, $LANBD, $MA_NOIDUNG),
        ]);
    }

    /**
     * Creates a new Dexuatnoidung model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-dexuatnoidung')) {
            $model = new \yii\base\DynamicModel(['ID_LOAITB','LANBD','CHUKYBAODUONG','MA_NOIDUNG']);
            $model->addRule(['ID_LOAITB'], 'string')
                ->addRule(['LANBD', 'CHUKYBAODUONG', 'MA_NOIDUNG'], 'string', ['max'=>32])
                ->validate();
            
            if ($model->load(Yii::$app->request->post())) {
                $listNoidung = $model->MA_NOIDUNG;
                foreach ($listNoidung as $noidung) {
                    $exists = Dexuatnoidung::find()->where( [ 'ID_LOAITB' => $model->ID_LOAITB, 'LANBD' => $model->LANBD, 'MA_NOIDUNG' => $noidung ] )->exists();
                    if(!$exists) {
                        $noidungModel = new Dexuatnoidung();
                        $noidungModel->ID_LOAITB = $model->ID_LOAITB;
                        $noidungModel->LANBD = $model->LANBD;
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
        } else {
            throw new ForbiddenHttpException;           
        }
        
    }

    /**
     * Updates an existing Dexuatnoidung model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $ID_LOAITB
     * @param string $LANBD
     * @param string $MA_NOIDUNG
     * @return mixed
     */
    public function actionUpdate($ID_LOAITB, $LANBD, $MA_NOIDUNG)
    {
        if (Yii::$app->user->can('edit-dexuatnoidung')) {
            $model = $this->findModel($ID_LOAITB, $LANBD, $MA_NOIDUNG);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'ID_LOAITB' => $model->ID_LOAITB, 'LANBD' => $model->LANBD, 'MA_NOIDUNG' => $model->MA_NOIDUNG]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException;
            
        }
    }

    /**
     * Deletes an existing Dexuatnoidung model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $ID_LOAITB
     * @param string $LANBD
     * @param string $MA_NOIDUNG
     * @return mixed
     */
    public function actionDelete($ID_LOAITB, $LANBD, $MA_NOIDUNG)
    {
        if (Yii::$app->user->can('delete-dexuatnoidung')) {
            $this->findModel($ID_LOAITB, $LANBD, $MA_NOIDUNG)->delete();

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException;
            
        }
    }

    

    

    /**
     * Finds the Dexuatnoidung model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_LOAITB
     * @param string $LANBD
     * @param string $MA_NOIDUNG
     * @return Dexuatnoidung the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_LOAITB, $LANBD, $MA_NOIDUNG)
    {
        if (($model = Dexuatnoidung::findOne(['ID_LOAITB' => $ID_LOAITB, 'LANBD' => $LANBD, 'MA_NOIDUNG' => $MA_NOIDUNG])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
