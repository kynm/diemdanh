<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Noidungbaotri;
use app\models\NoidungbaotriSearch;
use app\models\Noidungbaotrinhomtbi;
use app\models\Chuyennoidung;
use app\models\Tramvt;
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
        $model = $this->findModel($id);
        $list = $model->thietbitrams;

        $query = Noidungbaotrinhomtbi::find()->where(['ID_NHOM' => $model->ID_NHOM]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query_tram = Tramvt::find()->joinWith('thietbitrams')->where(['thietbitram.ID_LOAITB' => $id]);
        $tramDataProvider = new ActiveDataProvider([
            'query' => $query_tram,
        ]);
        
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'tramDataProvider' => $tramDataProvider,
            'model' => $model,
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
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
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
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
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
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }


    public function actionDexuatnoidung($id)
    {
        $thietbi = $this->findModel($id);
        if (Chuyennoidung::find()->where(['ID_NHOM' => $thietbi->ID_NHOM])->exists() === false) {
            $list = Noidungbaotrinhomtbi::findAll(['ID_NHOM' => $thietbi->ID_NHOM]);
            foreach ($list as $noiDung) {
                Yii::$app->db->createCommand("
                    INSERT INTO `chuyennoidung` (ID_NHOM, MA_NOIDUNG, NOIDUNG, CHUKY, QLTRAM, YEUCAUNHAP, IS_SELECTED)
                        VALUES ($thietbi->ID_NHOM, '$noiDung->MA_NOIDUNG', '$noiDung->NOIDUNG', $noiDung->CHUKY, $noiDung->QLTRAM, '$noiDung->YEUCAUNHAP', 0)
                ")->execute();
            }
            $listNDTB = Noidungbaotrinhomtbi::findAll(['ID_THIETBI'=> $id]);
            foreach ($listNDTB as $ND) {
                $MA_NOIDUNG = $ND->MA_NOIDUNG;
                Yii::$app->db->createCommand("
                    UPDATE `chuyennoidung`
                        SET IS_SELECTED = 1 
                        WHERE MA_NOIDUNG = '".$MA_NOIDUNG."'
                ")->execute();
            }
        }


        if (Yii::$app->request->post('addkeylist')) {
            $selection = Yii::$app->request->post('addkeylist');
            
            foreach($selection as $key){            
                
                $noiDungChuyen = Chuyennoidung::find()->where(['MA_NOIDUNG' => $key])->one();

                $noiDungChuyen->IS_SELECTED = 1;
                $noiDungChuyen->save(false);
                
                $noidung = new Noidungbaotrinhomtbi();

                $noidung->MA_NOIDUNG = $key;
                $noidung->ID_THIETBI = $thietbi->ID_THIETBI;
                $noidung->NOIDUNG = $noiDungChuyen->NOIDUNG;
                $noidung->CHUKY = $noiDungChuyen->CHUKY;
                $noidung->QLTRAM = $noiDungChuyen->QLTRAM;
                $noidung->YEUCAUNHAP = $noiDungChuyen->YEUCAUNHAP;

                $noidung->save(false);
                
            }
        }

        if (Yii::$app->request->post('rmvkeylist')) {
            $selection = Yii::$app->request->post('rmvkeylist');
            // var_dump($selection); die;
            
            foreach($selection as $key){
            // var_dump($key); die;                
                $noiDungChuyen = Chuyennoidung::find()->where(['MA_NOIDUNG' => $key])->one();
                $noiDungChuyen->IS_SELECTED = 0;
                
                $noiDungChuyen->save(false);

                $noidung = Noidungbaotrinhomtbi::findOne(['MA_NOIDUNG' => $key, 'ID_THIETBI' => $id]);
                $noidung->delete();
            }
        }

        $query1 = Chuyennoidung::find()->where(['ID_NHOM' => $thietbi->ID_NHOM, 'IS_SELECTED' => 0]);
        $unselectedProvider = new ActiveDataProvider([
            'query' => $query1,
        ]);

        $query2 = Chuyennoidung::find()->where(['ID_NHOM' => $thietbi->ID_NHOM, 'IS_SELECTED' => 1]);
        $selectedDataProvider = new ActiveDataProvider([
            'query' => $query2,
        ]);

        return $this->render('dexuatnoidung', [
            'thietbi' => $thietbi,
            'unselectedProvider' => $unselectedProvider,
            'selectedDataProvider' => $selectedDataProvider,
        ]);
    }

    public function actionList($id)
    {
        $idsNhom = explode(',', $id);
        $listThietbi = Thietbi::find()
        ->where(['ID_NHOM' => $idsNhom])
        ->all();

        if(isset($listThietbi) && count($listThietbi)>0) {
            foreach($listThietbi as $each) {
                echo "<option value='".$each->ID_THIETBI."'>".$each->TEN_THIETBI."</option>";
            }
            return;
        }else {
            echo "<option value=''>Chọn đài viễn thông</option>";
        }
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
