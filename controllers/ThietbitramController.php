<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Tramvt;
use app\models\Dexuatnoidung;
use app\models\Noidungcongviec;
use app\models\Dieuchuyenthietbi;
use app\models\Thietbitram;
use app\models\ThietbitramSearch;
use app\models\Dotbaoduong;
use app\models\Thietbi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

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
        $model = $this->findModel($id);

        // $transDevice = new Dieuchuyenthietbi;

        // if ($transDevice->load(Yii::$app->request->post())) {
        //     $transDevice->ID_THIETBI = $model->ID_THIETBI;
        //     $transDevice->ID_TRAM_NGUON = $model->ID_TRAM;
        //     $transDevice->save(false);

        //     $model->ID_TRAM = $transDevice->ID_TRAM_DICH;
        //     $model->save(false);
        // }

        $query1 = Noidungcongviec::find()->where(['ID_THIETBI' => $id]);

        $lsbaoduongProvider = new ActiveDataProvider([
            'query' => $query1,
        ]);

        $query2 = Dieuchuyenthietbi::find()->where(['ID_THIETBI' => $id]);

        $dieuchuyenProvider = new ActiveDataProvider([
            'query' => $query2,
        ]);

        return $this->render('view', [
            'model' => $model,
            // 'transDevice' => $transDevice,
            'lsbaoduongProvider' => $lsbaoduongProvider,
            'dieuchuyenProvider' => $dieuchuyenProvider,
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
                $chukyArray = Dexuatnoidung::find()
                ->where(['ID_LOAITB' => $model->ID_LOAITB])
                ->groupBy('CHUKYBAODUONG')
                ->orderBy(['CHUKYBAODUONG' => SORT_ASC])
                ->all();
                foreach ($chukyArray as $chuky) {
                    // echo $chuky->cHUKYBAODUONG->value."<br>";
                    $ngaysosanh = strtotime(date('d-m-Y',strtotime("- ".$chuky->cHUKYBAODUONG->value)));
                    if ($ngaysosanh <= strtotime($model->NGAYSD)) {
                        $model->LANBD = $chuky->LANBD;
                        
                        //////////Them ngay bao duong tiep theo de xuat
                        if ($model->LANBAODUONGTIEP == NULL) {
                            $ngaybaoduong = date_create($model->NGAYSD);
                            date_add($ngaybaoduong, date_interval_create_from_date_string($chuky->cHUKYBAODUONG->value));
                            $model->LANBAODUONGTIEP = date_format($ngaybaoduong, 'Y-m-d');
                        }
                        
                        //////////Them ngay bao duong gan nhat theo de xuat
                        if ($model->LANBAODUONGTRUOC) {
                            $lanbdtruoc = $model->LANBD - 1;
                            $chukygannhat = Dexuatnoidung::find()->where(['ID_LOAITB' => $model->ID_LOAITB, 'LANBD' => $lanbdtruoc])->one();
                            $ngaybaoduongtruoc = date_create($model->NGAYSD);
                            date_add($ngaybaoduongtruoc, date_interval_create_from_date_string($chukygannhat->cHUKYBAODUONG->value));
                            $model->LANBAODUONGTRUOC = date_format($ngaybaoduongtruoc, 'Y-m-d');
                        }
                        break;
                    }
                }


                $model->save();
                $log = new ActivitiesLog;
                $log->activity_type = 'device-add';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm thiết bị ". $model->iDLOAITB->TEN_THIETBI ." vào trạm ". $model->iDTRAM->MA_TRAM;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();

                return $this->redirect(['tramvt/view', 'id' => $model->ID_TRAM]);
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
        $model = $this->findModel($id);
        if (Yii::$app->user->can('edit-tbitram')) {
            
            if ($model->load(Yii::$app->request->post())) {
                $model->save();
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
            
            return $this->redirect(Yii::$app->request->referrer);
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
            return;
        }else {
            echo "-";
        }
    }


    public function actionCheckDate()
    {
        $thietbiArrayModel = Thietbitram::find()->all();
        foreach ($thietbiArrayModel as $model) {
            $chukyArray = Dexuatnoidung::find()
            ->where(['ID_LOAITB' => $model->ID_LOAITB])
            ->groupBy('CHUKYBAODUONG')
            ->orderBy(['CHUKYBAODUONG' => SORT_ASC])
            ->all();
            foreach ($chukyArray as $chuky) {
                $ngaysosanh = strtotime(date('d-m-Y',strtotime("- ".$chuky->cHUKYBAODUONG->value)));
                if ($ngaysosanh <= strtotime($model->NGAYSD)) {
                    
                    $model->LANBD = $chuky->LANBD;
                    $ngaybaoduong = date_create($model->NGAYSD);

                    date_add($ngaybaoduong, date_interval_create_from_date_string($chuky->cHUKYBAODUONG->value));
                    $model->LANBAODUONGTIEP = date_format($ngaybaoduong, 'Y-m-d');
                    break;
                }
            }
            $model->save();
        }
        return $this->redirect(['index']);
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
