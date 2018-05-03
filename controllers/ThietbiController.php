<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Noidungbaotri;
use app\models\NoidungbaotriSearch;
use app\models\Dexuatnoidung;
use app\models\DexuatnoidungSearch;
use app\models\Thietbi;
use app\models\ThietbiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ThietbiController implements the CRUD actions for Thietbi model.
 */
class ThietbiController extends Controller
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
     * Lists all Thietbi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThietbiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Thietbi model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $query = Noidungbaotri::find()->where(['ID_THIETBI' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Thietbi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-loaitb')) {
            # code...
            $model = new Thietbi();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $log = new ActivitiesLog;
                $log->activity_type = 'device-add';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm loại thiết bị ". $model->TEN_THIETBI;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['thietbi/view', 'id' => $model->ID_THIETBI]);
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
     * Updates an existing Thietbi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('edit-loaitb')) {
            # code...
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
     * Deletes an existing Thietbi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-loaitb')) {
            # code...
            $this->findModel($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            # code...
            throw new ForbiddenHttpException;
        }
    }


    public function actionDexuatnoidung($id)
    {
        $model = $this->findModel($id);

        //Thêm nội dung vào nội dung đề xuất
        if (Yii::$app->request->post('addkeylist') && Yii::$app->request->post('chuky')) {
            $chukybaoduong = Yii::$app->request->post('chuky');
            $selection = Yii::$app->request->post('addkeylist');
            
            foreach($selection as $manoidung){            
                    
                if(Dexuatnoidung::find()->where(['ID_LOAITB' => $id, 'CHUKYBAODUONG' => $chukybaoduong, 'MA_NOIDUNG' => $manoidung])->exists()) continue;
                
                $dexuat = new Dexuatnoidung;
                $dexuat->CHUKYBAODUONG = $chukybaoduong;
                $dexuat->MA_NOIDUNG = $manoidung;
                $dexuat->ID_LOAITB = $id;
                
                $dexuat->save(false);
            }
        }


        //Tự động sắp xếp lại chu kỳ và đặt lần bảo dưỡng
            
        $dexuattbi = Dexuatnoidung::find()->where(['ID_LOAITB' => $id])->groupBy(['CHUKYBAODUONG'])->orderBy(['CHUKYBAODUONG' => SORT_ASC])->all();
        if ($dexuattbi) {
            foreach ($dexuattbi as $each) {
                $chukyArr[] = $each->CHUKYBAODUONG;
            }
            $i = 1;
            foreach ($chukyArr as $chuky) {
                $dexuatchuky = Dexuatnoidung::find()->where(['ID_LOAITB' => $id, 'CHUKYBAODUONG' => $chuky])->all();
                foreach ($dexuatchuky as $noidung) {
                    $noidung->LANBD = $i;
                    $noidung->save();
                    
                }
                $i++;
            }
        }
        
        // tat ca noi dung bao tri cho thiet bi
        $noidungSearchModel = new NoidungbaotriSearch();
        $noidungProvider = $noidungSearchModel->searchThietbi(Yii::$app->request->queryParams);

        if (Yii::$app->request->post('rmvkeylist')) {
            $selection = Yii::$app->request->post('rmvkeylist');
            
            foreach($selection as $object){            
                    
                $delModel = Dexuatnoidung::find()->where(['ID_LOAITB' => $object['ID_LOAITB'], 'CHUKYBAODUONG' => $object['CHUKYBAODUONG'], 'MA_NOIDUNG' => $object['MA_NOIDUNG']])->one();
                $delModel->delete();

            }
        }


        //ajax filter theo chu kỳ bảo dưỡng
        if (Yii::$app->request->get('chuky') != null) {
            $query = Dexuatnoidung::find()
            ->where(['ID_LOAITB'=>$id, 'CHUKYBAODUONG' => $_GET['chuky']]);        
            $khuyennghiProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [ 
                    'pageSize' => 10,
                ],
            ]);
        } else {
            $khuyennghiSearchModel = new DexuatnoidungSearch;
            $khuyennghiProvider = $khuyennghiSearchModel->search(Yii::$app->request->queryParams);
        }
            
        return $this->render('dexuatnoidung', [
            'model' => $model,
            // 'noidungSearchModel' => $noidungSearchModel,
            'noidungProvider' => $noidungProvider,
            // 'khuyennghiSearchModel' => $khuyennghiSearchModel,
            'khuyennghiProvider' => $khuyennghiProvider,
        ]);
    }

    public function actionMultiDelete()
    {
        $id = Yii::$app->request->post('id');
        $model = Thietbi::findOne($id);
        $selection = Yii::$app->request->post('rmvkeylist');
        
        foreach($selection as $object){            
                
            $delModel = Dexuatnoidung::find()->where(['ID_LOAITB' => $object['ID_LOAITB'], 'CHUKYBAODUONG' => $object['CHUKYBAODUONG'], 'MA_NOIDUNG' => $object['MA_NOIDUNG']])->one();
            $delModel->delete();

        }

        return $this->redirect(Yii::$app->request->referrer);
        
        $query1 = Dexuatnoidung::find()
        ->where(['ID_LOAITB'=>$id]);        
        $khuyennghiProvider = new ActiveDataProvider([
            'query' => $query1,
            'pagination' => [ 
                'pageSize' => 10, 
            ],
        ]);

        $query2 = Noidungbaotri::find()
        ->where(['ID_THIETBI'=>$id]);        
        $noidungProvider = new ActiveDataProvider([
            'query' => $query2,
            'pagination' => [ 
                'pageSize' => 10, 
            ],
        ]);
                
        return $this->render('dexuatnoidung', [
            'model' => $model,
            'noidungProvider' => $noidungProvider,
            'khuyennghiProvider' => $khuyennghiProvider,
        ]);
    }

    public function actionMultiAdd()
    {
        $selection=(array)Yii::$app->request->post('AddSelection');

        // print_r($selection);
        // die;
        foreach($selection as $idObj){
            $id = get_object_vars(json_decode($idObj));
            $delModel = Dexuatnoidung::find()->where($id)->one();
            $delModel->delete();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Thietbi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Thietbi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Thietbi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
