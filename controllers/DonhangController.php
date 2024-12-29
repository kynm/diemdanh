<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Donhang;
use app\models\DonhangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\AuthAssignment;
use yii\helpers\ArrayHelper;
use app\models\Donvi;

/**
 * DonviController implements the CRUD actions for Donvi model.
 */
class DonhangController extends Controller
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
     * Lists all Donvi models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('Administrator')) {
            $searchModel = new DonhangSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }  
    }

    public function actionTheodoidungthu()
    {
        if (Yii::$app->user->can('Administrator')) {
            $sqldsdonvi = 'SELECT a.TEN_DONVI, a.SO_DT FROM donvi a WHERE date(a.created_at) = CURDATE() ORDER BY a.TEN_DONVI';
            $dsdonvi = Yii::$app->db->createCommand($sqldsdonvi)->queryAll();
            $sqllophoc = 'SELECT a.TEN_DONVI, a.SO_DT, b.TEN_LOP FROM donvi a, lophoc b WHERE a.ID_DONVI = b. ID_DONVI and a.STATUS = 1 AND DATE(b.created_at) = CURDATE() ORDER BY a.TEN_DONVI';
            $dslophoc = Yii::$app->db->createCommand($sqllophoc)->queryAll();
            $sqlhocsinh = 'SELECT a.TEN_DONVI, a.SO_DT, b.TEN_LOP, c.HO_TEN FROM donvi a, lophoc b, hocsinh c WHERE a.ID_DONVI = b. ID_DONVI and b.ID_LOP = c.ID_LOP and a.STATUS = 1 AND DATE(c.created_at) = CURDATE() ORDER BY a.TEN_DONVI,b.TEN_LOP,c.HO_TEN';
            $dshocsinh = Yii::$app->db->createCommand($sqlhocsinh)->queryAll();
            $sqldiemdanh = 'SELECT a.TEN_DONVI, a.SO_DT, b.TEN_LOP, c.NGAY_DIEMDANH FROM donvi a, lophoc b, quanlydiemdanh c WHERE a.ID_DONVI = b. ID_DONVI and b.ID_LOP = c.ID_LOP and a.STATUS = 1 AND DATE(c.created_at) = CURDATE() ORDER BY a.TEN_DONVI,b.TEN_LOP,c.NGAY_DIEMDANH';
            $dsdiemdanh = Yii::$app->db->createCommand($sqldiemdanh)->queryAll();
            return $this->render('theodoidungthu', [
                'dsdonvi' => $dsdonvi,
                'dslophoc' => $dslophoc,
                'dshocsinh' => $dshocsinh,
                'dsdiemdanh' => $dsdiemdanh,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }  
    }

    /**
     * Displays a single Donvi model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('Administrator')) {
            $model = $this->findModel($id);
            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        } 
    }

    /**
     * Creates a new Donvi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('create-donvi')) {
            $model = new Donhang();
            $model->NGAY_BD = date('Y-m-d');
            $model->NGAY_KT = date('Y-m-d', strtotime('+1 year'));
            $model->SOTIEN = 350000;
            $model->SO_LOP = 100;
            $model->SO_HS = 150;
            $model->STATUS = 2;
            $model->TYPE = 1;
            if ($model->load(Yii::$app->request->post())) {
                $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $model->NHANVIEN_XL = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $model->save();
                if ($model->STATUS && $model->TYPE == 1) {
                    $model->donvi->NGAY_KT = $model->NGAY_KT;
                    $model->donvi->SO_LOP = $model->SO_LOP;
                    $model->donvi->SO_HS = $model->SO_HS;
                    $model->donvi->STATUS = $model->STATUS;
                    $model->donvi->save(false);
                } elseif ($model->STATUS && $model->TYPE == 2) {
                    $model->donvi->SO_LOP += $model->SO_LOP;
                    $model->donvi->SO_HS += $model->SO_HS;
                    $model->donvi->STATUS = $model->STATUS;
                    $model->donvi->save(false);
                }
                
                Yii::$app->session->setFlash('success', "TẠO MỚI THÀNH CÔNG!");
                return $this->redirect(['index']);
            } else {
            $dsdonvi = ArrayHelper::map(Donvi::find()->orderBy(['ID_DONVI' => SORT_DESC])->LIMIT(10)->all(), 'ID_DONVI', 'TEN_DONVI');
                return $this->render('create', [
                    'model' => $model,
                    'dsdonvi' => $dsdonvi,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }        
    }

    /**
     * Updates an existing Donvi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('Administrator')) {
            $model = $this->findModel($id);
            $model->NHANVIEN_XL = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            if ($model->load(Yii::$app->request->post())) {
                $model->save();
                if ($model->STATUS && $model->TYPE == 1) {
                    $model->donvi->NGAY_KT = $model->NGAY_KT;
                    $model->donvi->SO_LOP = $model->SO_LOP;
                    $model->donvi->SO_HS = $model->SO_HS;
                    $model->donvi->STATUS = $model->STATUS;
                    $model->donvi->save(false);
                } elseif ($model->STATUS && $model->TYPE == 2) {
                    $model->donvi->SO_LOP += $model->SO_LOP;
                    $model->donvi->SO_HS += $model->SO_HS;
                    $model->donvi->STATUS = $model->STATUS;
                    $model->donvi->save(false);
                }
                Yii::$app->session->setFlash('success', "CẬP NHẬT THÀNH CÔNG!");
                return $this->redirect(['index']);
            } else {
                $dsdonvi = ArrayHelper::map(Donvi::find()->all(), 'ID_DONVI', 'TEN_DONVI');
                $model->SO_LOP = $model->SO_LOP ? $model->SO_LOP : 100;
                $model->SO_HS = $model->SO_HS ? $model->SO_HS : 150;
                return $this->render('update', [
                    'model' => $model,
                    'dsdonvi' => $dsdonvi,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Deletes an existing Donvi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-donvi')) {
            # code...
            $this->findModel($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        } 
    }

    /**
     * Finds the Donvi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Donvi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Donhang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDonvimuagoi()
    {
        $donvi = Yii::$app->user->identity->nhanvien->iDDONVI;
        if ($donvi->getDsdonhang()->andWhere(['STATUS' => 1])->count()) {
            Yii::$app->session->setFlash('error', "ĐƠN VỊ ĐÃ CÓ ĐƠN HÀNG ĐANG CHỜ DUYỆT, CHÚNG TÔI SẼ KIỂM TRA TRONG THỜI GIAN SỚM NHẤT. TRÂN TRỌNG CÁM ƠN!");
            return $this->redirect(['/']);
        }
        $model = new Donhang();
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $model->NGAY_BD = date('Y-m-d');
            $model->NGAY_KT = date('Y-m-d', strtotime('+1 year'));
            $model->SOTIEN = 350000;
            $model->GHICHU = 'SỐ TÀI KHOẢN: ' . PHP_EOL .'NỘI DUNG:';
            if ($model->load(Yii::$app->request->post())) {
                $date1=date_create($donvi->NGAY_KT);
                $date2= date_create(date('Y-m-d'));
                if ($donvi->STATUS == 1 || $donvi->STATUS == 0 || $date2 > $date1) {
                    $model->TYPE = 1;
                } else {
                    $model->TYPE = 2;
                }
                if ($model->TYPE == 1) {
                    $model->SOTIEN = 350000;
                    if ($model->SO_HS > 150) {
                        $a = ($model->SO_HS - 150) / 50;
                        $model->SOTIEN += CEIL($a) * 50000;
                    }
                } else {
                    $a = $model->SO_HS / 50;
                    $model->SOTIEN += CEIL($a) * 50000;
                }
                $model->STATUS = 1;
                $model->save();
                Yii::$app->session->setFlash('success', "TẠO MỚI THÀNH CÔNG!");
                return $this->redirect(['/']);
            } else {
                return $this->render('donvimuahang', [
                    'model' => $model,
                ]);
            }
    }

    public function actionDoanhthu()
    {
        $tongdoanhthu = Donhang::find()->sum('SOTIEN');
        return $this->render('doanhthu', [
            'tongdoanhthu' => $tongdoanhthu,
        ]);
    }
}
