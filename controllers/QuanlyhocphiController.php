<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Quanlyhocphi;
use app\models\QuanlyhocphiSearch;
use app\models\ChitiethocphiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Lophoc;
use app\models\Chitiethocphi;
use app\models\Quanlyhocphithutruoc;
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

            $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dslop' => $dslop,
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
        $sql = "SELECT c.ID ID_HOCSINH,c.HO_TEN,c.TIENHOC, COUNT(1) SO_LUONG, SUM(CASE WHEN b.`STATUS` > 0 then 1 ELSE 0 END) SOLUONGDIHOC
            , GROUP_CONCAT(CASE WHEN b.`STATUS` = 0 then DATE_FORMAT(a.NGAY_DIEMDANH,'%d/%m') ELSE null END ORDER BY a.NGAY_DIEMDANH asc SEPARATOR ', ') NGAYNGHI
            , GROUP_CONCAT(CASE WHEN b.`STATUS` = 1 then DATE_FORMAT(a.NGAY_DIEMDANH,'%d/%m') ELSE null END ORDER BY a.NGAY_DIEMDANH asc SEPARATOR ', ') NGAYDIHOC
            FROM quanlydiemdanh a, diemdanhhocsinh b, hocsinh c
                WHERE a.ID = b.ID_DIEMDANH AND b.ID_HOCSINH = c.ID and a.ID_LOP = :ID_LOP AND a.NGAY_DIEMDANH BETWEEN :TU_NGAY and :DEN_NGAY GROUP BY c.HO_TEN,c.ID,c.TIENHOC order by c.ID";
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
            $hocphi->TIENHOC = $chitiet['TIENHOC'];
            $hocphi->TONG_TIENHOC = $hocphi->SO_BTT * $hocphi->TIENHOC;
            $hocphi->TONG_TIEN = $hocphi->TONG_TIENHOC + $hocphi->TIENKHAC;
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
        if (Yii::$app->user->can('quanlytruonghoc') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            if (Yii::$app->request->post()) {
                $inputs = Yii::$app->request->post();
                $sobuoi = $inputs['SOBUOITINHTIEN'] ? $inputs['SOBUOITINHTIEN'] : 0;
                $tiensach = $inputs['NHAPTIENSACH'] ? $inputs['NHAPTIENSACH'] : 0;
                $tongtien = $inputs['NHAPTONGTIEN'] ? $inputs['NHAPTONGTIEN'] : 0;
                if (!is_numeric($sobuoi) || !is_numeric($sobuoi) || !is_numeric($tongtien)) {
                    Yii::$app->session->setFlash('error', "Lỗi dữ liệu!");
                    return $this->redirect(['view', 'id' => $model->ID]);
                }

                foreach ($model->chitiethocphi as $key => $chitiet) {
                    if ($sobuoi) {
                        $chitiet->SO_BTT = $sobuoi;
                    }

                    if ($tongtien) {
                        $chitiet->TONG_TIENHOC = $tongtien;
                    }

                    if ($tiensach) {
                        $chitiet->TIENKHAC = $tiensach;
                    }

                    $chitiet->TONG_TIEN = $chitiet->TONG_TIENHOC + $chitiet->TIENKHAC;
                    $chitiet->save();
                }
                Yii::$app->session->setFlash('success', "Cập nhật thành công!");
                return $this->redirect(['view', 'id' => $model->ID, 'inputs' => $inputs]);
            }
            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionChitiethocphi($id)
    {
        $this->layout = 'printLayout';
        $model = Chitiethocphi::findOne($id);
        if (Yii::$app->user->can('quanlytruonghoc') && $model && $model->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $view = 'chitiethocphi';
            if (Yii::$app->user->can('inngayhoc')) {
                $view = 'chitiethocphicongayhoc';//thutrang yeu cau
            }
            return $this->render($view, [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionInhocphitheolop($id)
    {
        $this->layout = 'printLayout';
        $model = Quanlyhocphi::findOne($id);
        if (Yii::$app->user->can('quanlytruonghoc') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $dshocphithutruoc = Quanlyhocphithutruoc::find()->where(['ID_DONVI' => $model->ID_DONVI])
                ->andWhere(['ID_LOP' => $model->ID_LOP])
                ->andWhere(['between', 'date(NGAY_BD)', Yii::$app->formatter->asDatetime($model->TU_NGAY, 'php:Y-m-d'), Yii::$app->formatter->asDatetime($model->DEN_NGAY, 'php:Y-m-d')])
                ->all();
            return $this->render('inhocphitheolop', [
                'model' => $model,
                'dshocphithutruoc' => $dshocphithutruoc,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Deletes an existing diemdanh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('quanlytruonghoc')) {
            $model = $this->findModel($id);
            if ($model->getChitiethocphi()->where(['STATUS' => 1])->count()) {
                Yii::$app->session->setFlash('error', "Không thể xóa do đã tồn tại lượt thanh toán học phí");
                return $this->redirect(['view', 'id' => $id]);
            }   else {
                Chitiethocphi::deleteAll(['ID_QUANLYHOCPHI' => $id]);
                $model->delete();
            }
            Yii::$app->session->setFlash('success', "Xóa thành công!");
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
                $hocphi->TONG_TIENHOC = $hocphi->SO_BTT * $hocphi->TIENHOC;
                $hocphi->TONG_TIEN = $hocphi->TONG_TIENHOC + $hocphi->TIENKHAC;
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
                $hocphi->TONG_TIENHOC = $hocphi->SO_BTT * $hocphi->TIENHOC;
                $hocphi->TONG_TIEN = $hocphi->TONG_TIENHOC + $hocphi->TIENKHAC;
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

    public function actionCapnhattienkhac()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Chitiethocphi::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => '',
            ];
            if ($hocphi && $hocphi->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->TIENKHAC = $params['tiencongthem'];
                $hocphi->TONG_TIEN = $hocphi->TONG_TIENHOC + $hocphi->TIENKHAC;
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

    public function actionXacnhanthuhocphi()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Chitiethocphi::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => '',
            ];
            if ($hocphi && $hocphi->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->STATUS = 1;
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

    public function actionModieuchinh()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Chitiethocphi::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => '',
            ];
            if ($hocphi && $hocphi->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->STATUS = 0;
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

    public function actionXoaluotthuhocphi()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Chitiethocphi::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => '',
            ];
            if ($hocphi && $hocphi->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && Yii::$app->user->can('quanlyhocphi')) {
                $hocphi->delete();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChitietthuhocphidonvi()
    {

        if (Yii::$app->user->can('quanlyhocphi')) {
            $searchModel = new ChitiethocphiSearch();
            $params = Yii::$app->request->queryParams;
            $params['STATUS'] = isset( $params['STATUS']) ? $params['STATUS'] : 1;
            $dataProvider = $searchModel->searchchitiethocphitheodonvi($params);

            $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
            return $this->render('chitietthuhocphidonvi', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dslop' => $dslop,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }

    }

    public function actionBosunghocsinh()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN && Yii::$app->user->can('quanlyhocphi')) {
            $result = [
                'error' => 1,
                'message' => 'Lỗi cập nhật!',
            ];
            $params = Yii::$app->request->post();
            $quanlyhocphi = Quanlyhocphi::findOne($params['id']);
            self::taochitiethocphi($quanlyhocphi);
            $dshocsinhlop = ArrayHelper::map($quanlyhocphi->lop->getDshocsinh()->andWhere(['STATUS' => 1])->all(), 'ID', 'ID');
            $dshocsinhdatinhhp = ArrayHelper::map($quanlyhocphi->chitiethocphi, 'ID_HOCSINH', 'ID_HOCSINH');
            $dshschuatinhhocphi = array_diff_key($dshocsinhdatinhhp, $dshocsinhlop);
            foreach ($dshocsinhlop as $key => $value) {
                if (!in_array($value, $dshocsinhdatinhhp)) {
                    $hocphi = Chitiethocphi::find()->where(['ID_QUANLYHOCPHI' => $quanlyhocphi->ID])->andWhere(['ID_HOCSINH' => $value])->one();
                    if (!$hocphi) {
                        $hocphi = new Chitiethocphi();
                        $hocphi->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                        $hocphi->ID_QUANLYHOCPHI = $quanlyhocphi->ID;
                        $hocphi->ID_HOCSINH = $value;
                        $hocphi->save();
                    }
                }
            }
            $result = [
                'error' => 0,
                'message' => 'Cập nhật thành công!',
            ];

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
