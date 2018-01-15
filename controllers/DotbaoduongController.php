<?php

namespace app\controllers;

use Yii;
use app\models\Nhanvien;
use app\models\Dotbaoduong;
use app\models\DotbaoduongSearch;
use app\models\Kehoachbdtb;
use app\models\KehoachbdtbSearch;
use app\models\Thuchienbd;
use app\models\ThuchienbdSearch;
use app\models\Ketqua;
use app\models\KetquaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

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


    public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
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

    public function actionDanhsachkehoach()
    {
        $searchModel = new KehoachbdtbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('danhsachkehoach', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDanhsachthuchien()
    {
        $searchModel = new ThuchienbdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('danhsachthuchien', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDanhsachketqua()
    {
        $searchModel = new KetquaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('danhsachketqua', [
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
        $model = $this->findModel($id);
        if ($model->TRANGTHAI == "Kế hoạch") {
            return $this->redirect(['kehoach', 'id' => $id]);
        } else {
            return $this->redirect(['thuchien', 'id' => $id]);
        }
    }

    /**
     * Creates a new Dotbaoduong model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-dbd')) {
            # code...
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
        } else {
            throw new ForbiddenHttpException;
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
        if (Yii::$app->user->can('edit-dbd')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->ID_DOTBD]);
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
     * Deletes an existing Dotbaoduong model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-dbd')) {
            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException;
        }
    }


    public function actionKehoach($id)
    {
        // $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $dotbd = Dotbaoduong::findOne($id);
        // if ($nhanvien->ID_NHANVIEN == $dotbd->TRUONG_NHOM) {
        //     $auth_assign = new AuthAssignment;
        //     $auth_assign->user_id = Yii::$app->user->identity->id;
        //     $auth_assign->item_name = 'manage-dbd';
        // }
        $kehoachs = [new Kehoachbdtb()];

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
        // } else {
        //     throw new ForbiddenHttpException;
        // }
        
    }

    public function actionThuchien($id)
    {
        // $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $dotbd = Dotbaoduong::findOne($id);
        // if ($nhanvien->ID_NHANVIEN == $dotbd->TRUONG_NHOM) {
            if ($dotbd->TRANGTHAI == 'Kế hoạch') {
                $dotbd->TRANGTHAI = 'Đang thực hiện';
                $dotbd->save();

                $noidungkehoachs = Kehoachbdtb::find()->where(['ID_DOTBD' => $id])->all();
                foreach ($noidungkehoachs as $noidungkehoach) {
                    $noidungthuchien = new Thuchienbd();
                    $noidungthuchien->ID_DOTBD = $noidungkehoach->ID_DOTBD;
                    $noidungthuchien->ID_THIETBI = $noidungkehoach->ID_THIETBI;
                    $noidungthuchien->MA_NOIDUNG = $noidungkehoach->MA_NOIDUNG;
                    $noidungthuchien->ID_NHANVIEN = $noidungkehoach->ID_NHANVIEN;
                    $noidungthuchien->KETQUA = 'Chưa hoàn thành';
                    $noidungthuchien->save(false);
                    $noidungkehoach->delete();
                }
            } elseif ($dotbd->TRANGTHAI == 'Kết thúc') {
                return $this->redirect(['ketthuc', 'id' => $dotbd->ID_DOTBD]);
            }

            if(isset($_REQUEST['selection'])) {
                $keyArr = $_REQUEST['selection'];
                
                foreach ($keyArr as $keyObj) {
                    $key = get_object_vars(json_decode($keyObj));

                    $noidungthuchiens = Thuchienbd::find()->where($key)->all();
                    foreach ($noidungthuchiens as $noidungthuchien) {
                        $noidungthuchien->KETQUA = 'Đạt';
                        $noidungthuchien->save(false);
                    }
                }
                return $this->redirect(['dotbaoduong/danhgia', 'id' => $dotbd->ID_DOTBD]);
            }

            if (Yii::$app->request->post('hasEditable')) {
                $idKey = Yii::$app->request->post('editableKey');
                $idKey = json_decode($idKey);
                $arr = get_object_vars($idKey);

                $noidungthuchien = Thuchienbd::findOne($arr);
                $out = Json::encode(['output' => '', 'message' => '']);
                $post = [];
                $posted = current($_POST['Thuchienbd']);
                $post['Thuchienbd'] = $posted;

                if ($noidungthuchien->load($post)) {
                    $noidungthuchien->save();
                }

                echo $out;
                return;
            }

            $searchModel = new ThuchienbdSearch();
            $dataProvider = $searchModel->searchND(Yii::$app->request->queryParams);
            return $this->render('thuchien', [
                'model' => $this->findModel($id),
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        // } else {
        //     throw new ForbiddenHttpException;           
        // }
    }

    public function actionDanhgia($id)
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $dotbd = Dotbaoduong::findOne($id);

        if ($nhanvien->ID_NHANVIEN == $dotbd->TRUONG_NHOM) {
            $model = new Ketqua();

            if ($model->load(Yii::$app->request->post())) {
                $dotbd->TRANGTHAI = 'Kết thúc';
                $dotbd->save(false);

                $model->ID_DOTBD = $id;

                //get instances, upload files to host
                $model->files = UploadedFile::getInstances($model, 'files');
                $i=1;
                foreach ($model->files as $file) {
                    $filePath = 'uploads/' . $dotbd->MA_DOTBD. '_'. $i . '.' . $file->extension;
                    // print_r($file);
                    // echo "<br>". $file->extension;
                    // echo "<br> ".$filePath;
                    // die;
                    $file->saveAs($filePath);
                    //save file path to database
                    switch ($i) {
                        case '1':
                            $model->ANH1 = $filePath;
                            break;
                        case '2':
                            $model->ANH2 = $filePath;
                            break;
                        case '3':
                            $model->ANH3 = $filePath;
                            break;
                        
                        default:
                            break;
                    }
                    $i++;
                }

                $model->save(false);
                return $this->redirect(['ketqua', 'id' => $model->ID_DOTBD]);
            } else {
                return $this->render('danhgia', [
                    'model' => $model,
                    'dotbd' => $dotbd,
                ]);
            }
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionKetqua($id)
    {

        return $this->render('ketqua', [
            'model' => $model = Ketqua::findOne($id),
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
