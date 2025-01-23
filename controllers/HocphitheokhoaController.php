<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Hocphitheokhoa;
use app\models\HocphitheokhoaSearch;
use app\models\QuanlyhocphithutruocSearch;
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
class HocphitheokhoaController extends Controller
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
            $searchModel = new HocphitheokhoaSearch();
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
            $model = new Hocphitheokhoa();
            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            if ($model->load(Yii::$app->request->post())) {
                $model->save();
                Yii::$app->session->setFlash('success', "Tạo thành công!");
                return $this->redirect(['view', 'id' => $model->ID]);
            } else {
                $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['STATUS' => 1])->all(), 'ID_LOP', 'TEN_LOP');
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
        $dshocsinh = $quanlyhocphi->lop->getDshocsinh()->andWhere(['STATUS' => 1])->all();
        foreach ($dshocsinh as $key => $hocsinh) {
            $hocphi = Quanlyhocphithutruoc::find()->where(['ID_KHOAHOCPHI' => $quanlyhocphi->ID])->andWhere(['ID_HOCSINH' => $hocsinh->ID])->one();
            if (!$hocphi) {
                $hocphi = new Quanlyhocphithutruoc();
                $hocphi->ID_HOCSINH = $hocsinh->ID;
                $hocphi->ID_KHOAHOCPHI = $quanlyhocphi->ID;
                if ($hocphi->hocsinh->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                    $hocphi->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
                    $hocphi->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                    $hocphi->STATUS = 1;
                    $hocphi->TIEUDE = $quanlyhocphi->TIEUDE;
                    $hocphi->ID_LOP = $quanlyhocphi->ID_LOP;
                    $hocphi->SOTIEN = $quanlyhocphi->TIENHOC;
                    $hocphi->SO_BH = $quanlyhocphi->SO_BH;
                    $hocphi->NGAY_BD = $quanlyhocphi->TU_NGAY;
                    $hocphi->NGAY_KT = $quanlyhocphi->DEN_NGAY;
                    $hocphi->TIENKHAC = null;
                    $hocphi->TONGTIEN = $quanlyhocphi->TIENHOC - $hocphi->TIENGIAM;
                    $hocphi->save();
                }
            }

            if (Yii::$app->user->can('trutienbuoihocnghi') && $hocphi->STATUS == 1) {
                $sobuoinghi = $hocphi->sobuoinghi($quanlyhocphi->TU_NGAY, $quanlyhocphi->DEN_NGAY);
                $hocphi->SO_BH = $quanlyhocphi->SO_BH - $sobuoinghi;
                $hocphi->TIENGIAM = $sobuoinghi * $hocphi->hocsinh->TIENHOC;
                $hocphi->TONGTIEN = $hocphi->SO_BH * $hocphi->hocsinh->TIENHOC + $hocphi->TIENKHAC - $hocphi->TIENGIAM;
                $hocphi->save();
            }
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
        $model = Quanlyhocphithutruoc::findOne($id);
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
        $model = Hocphitheokhoa::findOne($id);
        if (Yii::$app->user->can('quanlytruonghoc') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $dshocphithutruoc = Quanlyhocphithutruoc::find()->where(['ID_DONVI' => $model->ID_DONVI])
                ->andWhere(['ID_LOP' => $model->ID_LOP])
                ->andWhere(['in', 'ID_HOCSINH', ArrayHelper::map(Hocsinh::find()->where(['ID_DONVI' => $model->ID_DONVI])->andWhere(['ID_LOP' => $model->ID_LOP])->andWhere(['in', 'HT_HP', [0,2,3]])->all(), 'ID', 'ID')])
                // ->andWhere(['between', 'date(NGAY_BD)', Yii::$app->formatter->asDatetime($model->TU_NGAY, 'php:Y-m-d'), Yii::$app->formatter->asDatetime($model->DEN_NGAY, 'php:Y-m-d')])
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
            if ($model->getChitiethocphi()->where(['STATUS' => 2])->count() && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                Yii::$app->session->setFlash('error', "Không thể xóa do đã tồn tại lượt thanh toán học phí");
                return $this->redirect(['view', 'id' => $id]);
            }   else {
                Quanlyhocphithutruoc::deleteAll(['ID_KHOAHOCPHI' => $id]);
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
        if (($model = Hocphitheokhoa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCapnhatsotienmoibuoi()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($params['id']);
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

    public function actionCapnhattienkhac()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($params['id']);
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
            $hocphi = Quanlyhocphithutruoc::findOne($params['id']);
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
            $hocphi = Quanlyhocphithutruoc::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => '',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->GHICHU = $params['capnhatghichu'];
                $hocphi->save();
                $result['error'] = 0;
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
            $hocphi = Quanlyhocphithutruoc::findOne($params['id']);
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
            $hocphi = Quanlyhocphithutruoc::findOne($params['id']);
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
            $hocphi = Quanlyhocphithutruoc::findOne($params['id']);
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
            $searchModel = new QuanlyhocphithutruocSearch();
            $params = Yii::$app->request->queryParams;
            $params['STATUS'] = isset($params['STATUS']) ? $params['STATUS'] : 1;
            $dataProvider = $searchModel->searchhocphithutruoctheodonvi($params);

            $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
            return $this->render('chitietthuhocphidonvi', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dslop' => $dslop,
                'params' => $params,
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
            $quanlyhocphi = Hocphitheokhoa::findOne($params['id']);
            self::taochitiethocphi($quanlyhocphi);
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
        $model = Hocphitheokhoa::findOne($id);
        if (Yii::$app->user->can('quanlytruonghoc') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $html = '';
            $view = Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithutruoc ? '/quanlyhocphithutruoc/' . Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithutruoc : '/quanlyhocphithutruoc/inchitiet';
            foreach ($model->chitiethocphi as $key => $chitiet) {
                $html .= $this->renderPartial($view, ['model' => $chitiet]);
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
        $model = Quanlyhocphithutruoc::findOne($id);
        if (Yii::$app->user->can('quanlytruonghoc') && $model && $model->hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $view = Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithutruoc ? '/quanlyhocphithutruoc/' . Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithutruoc : '/quanlyhocphithutruoc/inchitiet';
            if (Yii::$app->user->can('inngayhoc')) {
                $view = 'chitiethocphicongayhoc';//thutrang yeu cau
            }
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            $filename = $model->hocphi->TIEUDE . ' - ' . $model->hocsinh->HO_TEN . '.pdf';
            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8,
                'content' => $this->renderPartial($view, ['model' => $model]),
                'options' => [
                    // any mpdf options you wish to set
                ],
                'filename' => $filename,
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

    public function actionDeletechitiet($id)
    {
        $model = Quanlyhocphithutruoc::findOne($id);
        if (Yii::$app->user->can('quanlyhocphi') && $model->STATUS == 1 && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
           $model->delete();
            Yii::$app->session->setFlash('success', "Hoàn thành xóa dữ liệu!");
            return $this->redirect(['view', 'id' => $model->ID_KHOAHOCPHI]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionThaydoingaykt()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $hocphi = Hocphitheokhoa::findOne($inputs['id']);
            $ngaykt = $inputs['ngaykt'];
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->DEN_NGAY = $ngaykt;
                $hocphi->save();
                $condition = ['and',
                    ['=', 'ID_KHOAHOCPHI', $inputs['id']],
                    ['=', 'ID_DONVI', Yii::$app->user->identity->nhanvien->ID_DONVI],
                ];
                Quanlyhocphithutruoc::updateAll([
                    'NGAY_KT' => $hocphi->DEN_NGAY,
                ], $condition);

                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionThaydoingaybd()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $hocphi = Hocphitheokhoa::findOne($inputs['id']);
            $ngaybd = $inputs['ngaybd'];
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $hocphi->TU_NGAY = $ngaybd;
                $hocphi->save();
                $condition = ['and',
                    ['=', 'ID_KHOAHOCPHI', $inputs['id']],
                    ['=', 'ID_DONVI', Yii::$app->user->identity->nhanvien->ID_DONVI],
                ];
                Quanlyhocphithutruoc::updateAll([
                    'NGAY_BD' => $hocphi->TU_NGAY,
                ], $condition);

                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
