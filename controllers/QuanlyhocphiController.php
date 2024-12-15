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
use app\models\Hocsinh;
use app\models\Chitiethocphi;
use app\models\Quanlyhocphithutruoc;
use kartik\mpdf\Pdf;
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

    public function beforeAction($action)
    {
        $donvi = Yii::$app->user->identity->nhanvien->iDDONVI;
        $date1=date_create($donvi->NGAY_KT);
        $date2= date_create(date('Y-m-d'));
        if ($date2 > $date1) {
            Yii::$app->session->setFlash('error', "Vui lòng gia hạn trước khi tiếp tục sử dụng dịch vụ!");
            return $this->redirect(['/']);
        }

        return true;
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

    public function actionCreatemultiple()
    {
        if (Yii::$app->user->can('quanlyhocphi') && Yii::$app->user->can('taohocphitoantrungtam')) {
            $model = new Quanlyhocphi();
            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            if ($model->load(Yii::$app->request->post())) {
                $inputs = Yii::$app->request->post();
                if ($inputs['Quanlyhocphi']['ID_LOP']) {
                    foreach ($inputs['Quanlyhocphi']['ID_LOP'] as $key => $lop) {
                        $model1 = new Quanlyhocphi();
                        $model1->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
                        $model1->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                        $model1->ID_LOP = $lop;
                        $model1->TIEUDE = $inputs['Quanlyhocphi']['TIEUDE'];
                        $model1->TU_NGAY = $inputs['Quanlyhocphi']['TU_NGAY'];
                        $model1->DEN_NGAY = $inputs['Quanlyhocphi']['DEN_NGAY'];
                        $model1->save();
                    }
                }
                Yii::$app->session->setFlash('success', "Tạo thành công!");
                return $this->redirect(['index']);
            } else {
                $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
                return $this->render('createmultiple', [
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
        $dshocsinh = ArrayHelper::map($quanlyhocphi->lop->getDshocsinh()->andWhere(['in', 'HT_HP', [0,1]])->all(), 'ID', 'ID');
        $sql = "SELECT c.ID ID_HOCSINH,c.HO_TEN,c.TIENHOC, COUNT(1) SO_LUONG, SUM(CASE WHEN b.`STATUS` > 0 then 1 ELSE 0 END) SOLUONGDIHOC
            , GROUP_CONCAT(CASE WHEN b.`STATUS` = 0 then DATE_FORMAT(a.NGAY_DIEMDANH,'%d/%m') ELSE null END ORDER BY a.NGAY_DIEMDANH asc SEPARATOR ', ') NGAYNGHI
            , GROUP_CONCAT(CASE WHEN b.`STATUS` = 1 then DATE_FORMAT(a.NGAY_DIEMDANH,'%d/%m') ELSE null END ORDER BY a.NGAY_DIEMDANH asc SEPARATOR ', ') NGAYDIHOC
            FROM quanlydiemdanh a, diemdanhhocsinh b, hocsinh c
                WHERE a.ID = b.ID_DIEMDANH AND b.ID_HOCSINH = c.ID and b.ID_HOCSINH in (" . implode(',', $dshocsinh) . ") AND a.NGAY_DIEMDANH BETWEEN :TU_NGAY and :DEN_NGAY GROUP BY c.HO_TEN,c.ID,c.TIENHOC order by c.ID";
        $data = Yii::$app->db->createCommand($sql)->bindValues(
            [
                ':TU_NGAY' => $quanlyhocphi->TU_NGAY,
                ':DEN_NGAY' => $quanlyhocphi->DEN_NGAY,
            ])->queryAll();
        foreach ($data as $key => $chitiet) {
            $hocphi = Chitiethocphi::find()->where(['ID_QUANLYHOCPHI' => $quanlyhocphi->ID])->andWhere(['ID_HOCSINH' => $chitiet['ID_HOCSINH']])->one();
            if (!$hocphi) {
                $hocphi = new Chitiethocphi();
                $hocphi->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                $hocphi->ID_QUANLYHOCPHI = $quanlyhocphi->ID;
                $hocphi->ID_HOCSINH = $chitiet['ID_HOCSINH'];
                if (! in_array($hocphi->hocsinh->HT_HP, [0,1])) {
                    continue;
                }
                $hocphi->save(false);
            }

            $hocphi->SO_BH = $chitiet['SO_LUONG'];
            $hocphi->SO_BN = $chitiet['SO_LUONG'] - $chitiet['SOLUONGDIHOC'];
            $hocphi->NGAY_NGHI = $chitiet['NGAYNGHI'];
            $hocphi->NGAYDIHOC = $chitiet['NGAYDIHOC'];
            $hocphi->SO_BDH = $chitiet['SOLUONGDIHOC'];
            if (!$hocphi->STATUS && !$hocphi->TONG_TIENHOC) {
                $hocphi->SO_BTT = $chitiet['SOLUONGDIHOC'];
                $hocphi->TIENHOC = $chitiet['TIENHOC'];
                $hocphi->TONG_TIENHOC = $hocphi->SO_BTT * $hocphi->TIENHOC;
                $hocphi->TONG_TIEN = $hocphi->TONG_TIENHOC + $hocphi->TIENKHAC;
            }
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
        if (Yii::$app->user->can('quanlyhocphi') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
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
                        $chitiet->TONG_TIENHOC = $chitiet->SO_BTT * $chitiet->TIENHOC;
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
        if (Yii::$app->user->can('quanlyhocphi') && $model && $model->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $view = 'chitiethocphi';
            if (Yii::$app->user->can('inngayhoc')) {
                $view = 'chitiethocphicongayhoc';//thutrang yeu cau
            } elseif(Yii::$app->user->can('intoanbothongtin')){
                $view = 'chitiettoanbothongtin';//thutrang yeu cau
            }
            if (Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithang) {
                $view = Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithang;
            }
            $hocphichuathukhac = $model->hocsinh->getDshocphi()
            ->andWhere(['STATUS' => 0])
            ->andWhere(['!=', 'ID', $model->ID])
            ->all();
            return $this->render($view, [
                'model' => $model,
                'hocphichuathukhac' => $hocphichuathukhac,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionInhocphitheolop($id)
    {
        $this->layout = 'printLayout';
        $model = Quanlyhocphi::findOne($id);
        if (Yii::$app->user->can('quanlyhocphi') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $dshocphithutruoc = Quanlyhocphithutruoc::find()->where(['ID_DONVI' => $model->ID_DONVI])
                ->andWhere(['in', 'ID_HOCSINH', ArrayHelper::map(Hocsinh::find()->where(['ID_DONVI' => $model->ID_DONVI])->andWhere(['ID_LOP' => $model->ID_LOP])
                    ->andWhere(['STATUS' => 1])
                    ->andWhere(['in', 'HT_HP', [0,2,3]])->all(), 'ID', 'ID')])
                ->all();
            $view = 'inhocphitheolop';
            if (Yii::$app->user->can('inhocphithangcokynhan')) {
                $view = 'inhocphitheolopkynhan';
            }
            return $this->render($view, [
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
        if (Yii::$app->user->can('quanlyhocphi')) {
            $model = $this->findModel($id);
            if ($model->getChitiethocphi()->where(['STATUS' => 1])->count() && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
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
                $hocphi->hocsinh->HT_HP = 1;
                $hocphi->hocsinh->save();
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
            $dshocsinhlop = ArrayHelper::map($quanlyhocphi->lop->getDshocsinh()->andWhere(['STATUS' => 1])->andWhere(['in', 'HT_HP', [0,1]])->all()
                , 'ID', 'ID');
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
                        if (! in_array($hocphi->hocsinh->HT_HP, [0,1])) {
                            continue;
                        }
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


    public function actionExportpdf($id)
    {
        $this->layout = 'printLayout';
        $model = Quanlyhocphi::findOne($id);
        if (Yii::$app->user->can('quanlyhocphi') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $html = '';
            foreach ($model->chitiethocphi as $key => $chitiet) {
                $hocphichuathukhac = $chitiet->hocsinh->getDshocphi()
                ->andWhere(['STATUS' => 0])
                ->andWhere(['!=', 'ID', $chitiet->ID])
                ->all();
                $view = 'chitiethocphi';
                if (Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithang) {
                    $view = Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithang;
                }
                $html .= $this->renderPartial($view, ['model' => $chitiet, 'hocphichuathukhac' => $hocphichuathukhac]);
            }
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            $filename = $model->TIEUDE . ' - ' . $model->lop->TEN_LOP . ' - '  . Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI . '.pdf';
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'content' => $html,
                'options' => [
                    // any mpdf options you wish to set
                ],
                'filename' => $filename,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'destination' => Pdf::DEST_DOWNLOAD,
                'methods' => [
                    'SetTitle' => Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI,
                    'SetSubject' => Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI,
                    'SetHeader' => [Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI . ' - ' .  $model->TIEUDE],
                    'SetFooter' => ['|Page {PAGENO}|'],
                    'SetAuthor' => Yii::$app->user->identity->nhanvien->TEN_NHANVIEN,
                    'SetCreator' => Yii::$app->user->identity->nhanvien->TEN_NHANVIEN,
                    'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
                ]
            ]);
            Yii::$app->response->headers->add('Content-Type', 'application/pdf');
            return $pdf->render();
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionExportpdfchitiet($id)
    {
        $this->layout = 'printLayout';
        $model = Chitiethocphi::findOne($id);
        if (Yii::$app->user->can('quanlyhocphi') && $model && $model->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $hocphichuathukhac = $model->hocsinh->getDshocphi()
                ->andWhere(['STATUS' => 0])
                ->andWhere(['!=', 'ID', $model->ID])
                ->all();
            $view = 'chitiethocphi';
            if (Yii::$app->user->can('inngayhoc')) {
                $view = 'chitiethocphicongayhoc';//thutrang yeu cau
            } elseif(Yii::$app->user->can('intoanbothongtin')){
                $view = 'chitiettoanbothongtin';//thutrang yeu cau
            }
            if (Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithang) {
                $view = Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithang;
            }
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            $filename = $model->hocsinh->HO_TEN . ' - ' . $model->hocphi->TIEUDE . '.pdf';
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'content' => $this->renderPartial($view, ['model' => $model, 'hocphichuathukhac' => $hocphichuathukhac]),
                'options' => [
                    // any mpdf options you wish to set
                ],
                'filename' => $filename,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
                'destination' => Pdf::DEST_DOWNLOAD,
                'methods' => [
                    'SetTitle' => Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI,
                    'SetSubject' => Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI,
                    'SetHeader' => [$model->hocsinh->HO_TEN . ' - ' .  $model->hocphi->TIEUDE],
                    'SetFooter' => ['|Page {PAGENO}|'],
                    'SetAuthor' => Yii::$app->user->identity->nhanvien->TEN_NHANVIEN,
                    'SetCreator' => Yii::$app->user->identity->nhanvien->TEN_NHANVIEN,
                    'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
                ]
            ]);
            Yii::$app->response->headers->add('Content-Type', 'application/pdf');
            return $pdf->render();

        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionCapnhattienhocchungtoanlop()
    {
        if (Yii::$app->request->post() && Yii::$app->user->can('quanlyhocphi') && Yii::$app->user->can('hocphithangchung')) {
            $result = [
                'error' => 1,
                'message' => 'Lỗi cập nhật!',
            ];
            $params = Yii::$app->request->post();
            $model = $this->findModel($params['id']);
            if ($model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $model->TIENHOC = (int)$params['tongtien'];
                $model->save();
                $result = [
                    'error' => 0,
                    'message' => 'Cập nhật thành công!',
                ];
            }
            return json_encode($result);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }

    }
}
