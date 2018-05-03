<?php

namespace app\controllers;

use Yii;
use app\models\Nhomtbi;
use app\models\Thietbi;
use app\models\Thietbitram;
use app\models\Dexuatnoidung;
use app\models\Noidungbaotri;
use app\models\NoidungbaotriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
/**
 * NoidungbaotriController implements the CRUD actions for Noidungbaotri model.
 */
class NoidungbaotriController extends Controller
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
     * Lists all Noidungbaotri models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoidungbaotriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Noidungbaotri model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Noidungbaotri model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-noidungbaotri')) {
            # code...
            $model = new Noidungbaotri();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
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

    public function actionCreatePost($MA_NOIDUNG, $ID_THIETBI, $NOIDUNG)
    {
        $model = new Noidungbaotri();
        
        $model->MA_NOIDUNG = $MA_NOIDUNG;
        $model->ID_THIETBI = $ID_THIETBI;
        $model->NOIDUNG = $NOIDUNG;
        $model->save();
        
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAutoCreate()
    {
        $noidungs = Noidungbaotri::find()->all();
        foreach ($noidungs as $noidung) {
            $noidung->delete();
        }
        $groupDevices = Nhomtbi::find()->all();
        foreach ($groupDevices as $groupDevice) {
            $devices = Thietbi::find()->where(['ID_NHOMTB' => $groupDevice->ID_NHOM])->all();
            $x = 1;
            foreach ($devices as $device) {
                for ($i=1; $i < 6 ; $i++) { 
                    $noidung = new Noidungbaotri;
                    $noidung->MA_NOIDUNG = $groupDevice->ID_NHOM . $x . $i;
                    $noidung->ID_THIETBI = $device->ID_THIETBI;
                    $noidung->NOIDUNG = 'Nội dung bảo dưỡng số '.$i.' dành cho '.$device->TEN_THIETBI;
                    $noidung->save(false);
                }
                $x++;
            }
        }
        $this->redirect(['index']);
    }

    /**
     * Updates an existing Noidungbaotri model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('edit-noidungbaotri')) {
            # code...
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->MA_NOIDUNG]);
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
     * Deletes an existing Noidungbaotri model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-noidungbaotri')) {
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
        $tbi = Thietbitram::find()->where(['ID_THIETBI' => $id])->one();
        // $noidung = Noidungbaotri::find()
        // ->where(['ID_THIETBI'=>$tbi->ID_LOAITB])
        // ->all();



        $query = Noidungbaotri::find()->where(['ID_THIETBI'=>$tbi->ID_LOAITB]);
        // ->all();
        // print_r($query);
        // die;
        $noidungthietbiDataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 
                'pageSize' => 10,
            ],
        ]);


        $infoDexuat = Dexuatnoidung::find()->where(['ID_LOAITB' => $tbi->ID_LOAITB, 'LANBD' => $tbi->LANBD])->one();
        if (isset($infoDexuat)) {
            $return_data['info'] = '<strong>Lần bảo dưỡng số '.$infoDexuat->LANBD.', chu kỳ '.$infoDexuat->cHUKYBAODUONG->alias.'</strong> <br>';
            $dexuatArray = Dexuatnoidung::find()->where(['ID_LOAITB' => $tbi->ID_LOAITB, 'LANBD' => $tbi->LANBD])->all();
            foreach ($dexuatArray as $dexuat) {
                $return_data['info'] = $return_data['info'].'<i class="fa fa-check-square-o"></i> '.$dexuat->mANOIDUNG->NOIDUNG.'<br>';
            }
        } else {
            $return_data['info'] = 'Chưa có nội dung đề xuất cho thiết bị này!!!';
        }
        
        
        // $return_data['noidung'] = '';
        // if(isset($noidung) && count($noidung)>0) {
        //     foreach($noidung as $each) {
        //         $return_data['noidung'] = $return_data['noidung'] . "<input type=\"checkbox\" name=\"dsnoidung[]\" value=".$each->MA_NOIDUNG."> ".$each->NOIDUNG." <br>" ;
        //     }
        // }else {
        //     $return_data['noidung'] = "Không có nội dung";
        // }
        // echo json_encode($return_data);
        echo json_encode($noidungthietbiDataProvider);
        exit;
    }

    public function actionListstbt($id)
    {
        $tbi = Thietbitram::find()->where(['ID_THIETBI' => $id])->one();
        $noidung = Noidungbaotri::find()
        ->where(['ID_THIETBI'=>$tbi->ID_LOAITB])
        ->all();

        if(isset($noidung) && count($noidung)>0) {
            foreach($noidung as $each) {
                echo "<option value='".$each->MA_NOIDUNG."'>".$each->NOIDUNG."</option>";
            }
        }else {
            echo "-";
        }
    }

    /**
     * Finds the Noidungbaotri model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Noidungbaotri the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Noidungbaotri::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
