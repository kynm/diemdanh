<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Quanlyhocphi;
use app\models\QuanlyhocphiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Lophoc;
use app\models\Chitiethocphi;
/**
 * diemdanhController implements the CRUD actions for diemdanh model.
 */
class QuanlyhocphiController extends Controller
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
     * Lists all diemdanh models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('quanlyhocphi')) {
            $searchModel = new QuanlyhocphiSearch();
            $dataProvider = $searchModel->searchhocphitheodonvi(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionCreate()
    {
        if (Yii::$app->user->can('quanlyhocphi')) {
            $model = new Quanlyhocphi();
            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                self::taochitiethocphi($model);
                Yii::$app->session->setFlash('success', "Tạo thành công!");
                return $this->redirect(['view', 'id' => $model->ID]);
            } else {
                $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
                return $this->render('create', [
                    'model' => $model,
                    'dslop' => $dslop,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function taochitiethocphi($quanlyhocphi)
     {
        $sql = "SELECT c.ID ID_HOCSINH,c.HO_TEN, COUNT(1) SO_LUONG, SUM(CASE WHEN b.`STATUS` > 0 then 1 ELSE 0 END) SOLUONGDIHOC
            , GROUP_CONCAT(CASE WHEN b.`STATUS` = 0 then day(a.NGAY_DIEMDANH) ELSE null END) NGAYNGHI
            , GROUP_CONCAT(CASE WHEN b.`STATUS` = 1 then day(a.NGAY_DIEMDANH) ELSE null END) NGAYDIHOC
            FROM quanlydiemdanh a, diemdanhhocsinh b, hocsinh c
                WHERE a.ID = b.ID_DIEMDANH AND b.ID_HOCSINH = c.ID and a.ID_LOP = :ID_LOP AND a.NGAY_DIEMDANH BETWEEN :TU_NGAY and :DEN_NGAY GROUP BY c.HO_TEN,c.ID order by c.ID";
        $data = Yii::$app->db->createCommand($sql)->bindValues(
            [
                ':TU_NGAY' => $quanlyhocphi->TU_NGAY,
                ':DEN_NGAY' => $quanlyhocphi->DEN_NGAY,
                ':ID_LOP' => $quanlyhocphi->ID_LOP,
            ])->queryAll();
        foreach ($data as $key => $chitiet) {
            $hocphi = Chitiethocphi::find()->where(['ID_QUANLYHOCPHI' => $quanlyhocphi->ID])->andWhere(['ID_HOCSINH' => $chitiet['ID_HOCSINH']])->one();
            if (!$hocphi) {
                $hocphi = new Chitiethocphi();
                $hocphi->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $hocphi->ID_QUANLYHOCPHI = $quanlyhocphi->ID;
                $hocphi->ID_HOCSINH = $chitiet['ID_HOCSINH'];
                $hocphi->save(false);
            }

            $hocphi->SO_BH = $chitiet['SO_LUONG'];
            $hocphi->SO_BN = $chitiet['SO_LUONG'] - $chitiet['SOLUONGDIHOC'];
            $hocphi->NGAY_NGHI = $chitiet['NGAYNGHI'];
            $hocphi->NGAYDIHOC = $chitiet['NGAYDIHOC'];
            $hocphi->SO_BDH = $chitiet['SOLUONGDIHOC'];
            $hocphi->SO_BTT = $chitiet['SOLUONGDIHOC'];
            $hocphi->TIENHOC = $quanlyhocphi->TIENHOC;
            $hocphi->TONG_TIEN = $hocphi->SO_BTT * $hocphi->TIENHOC;
            $hocphi->save(false);
        }
     }

    /**
     * Displays a single diemdanh model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionChitiethocphi($id)
    {
        $model = Chitiethocphi::findOne($id);
        return $this->render('chitiethocphi', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing diemdanh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('delete-diemdanh')) {
            $this->findModel($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Finds the diemdanh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return diemdanh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quanlyhocphi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCapnhatsotienmoibuoi()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Chitiethocphi::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => '',
            ];
            if ($hocphi && $hocphi->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->TIENHOC = $params['sotienmoibuoi'];
                $hocphi->TONG_TIEN = $hocphi->SO_BTT * $hocphi->TIENHOC;
                $hocphi->save();
                $result['error'] = 0;
                $result['ID'] = $hocphi->ID;
                $result['SO_BTT'] = $hocphi->SO_BTT;
                $result['TONG_TIEN'] = $hocphi->TONG_TIEN;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCapnhatsobuoitinhtien()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Chitiethocphi::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => '',
            ];
            if ($hocphi && $hocphi->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->SO_BTT = $params['sobuoi'];
                $hocphi->TONG_TIEN = $hocphi->SO_BTT * $hocphi->TIENHOC;
                $hocphi->save();
                $result['error'] = 0;
                $result['ID'] = $hocphi->ID;
                $result['SO_BTT'] = $hocphi->SO_BTT;
                $result['TONG_TIEN'] = $hocphi->TONG_TIEN;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCapnhattongtien()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Chitiethocphi::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => '',
            ];
            if ($hocphi && $hocphi->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->TONG_TIEN = $params['tongtien'];
                $hocphi->save();
                $result['error'] = 0;
                $result['ID'] = $hocphi->ID;
                $result['SO_BTT'] = $hocphi->SO_BTT;
                $result['TONG_TIEN'] = $hocphi->TONG_TIEN;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCapnhatghichu()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Chitiethocphi::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => '',
            ];
            if ($hocphi && $hocphi->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->NHAN_XET = $params['capnhatghichu'];
                $hocphi->save();
                $result['error'] = 0;
                $result['ID'] = $hocphi->ID;
                $result['SO_BTT'] = $hocphi->SO_BTT;
                $result['TONG_TIEN'] = $hocphi->TONG_TIEN;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
