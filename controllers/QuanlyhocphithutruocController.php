<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Quanlyhocphithutruoc;
use app\models\Lophoc;
use app\models\Hocsinh;
use app\models\HocsinhSearch;
use app\models\QuanlyhocphithutruocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * HocsinhController implements the CRUD actions for hocsinh model.
 */
class QuanlyhocphithutruocController extends Controller
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
     * Lists all hocsinh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuanlyhocphithutruocSearch();
        $params = Yii::$app->request->queryParams;
        $params['QuanlyhocphithutruocSearch']['STATUS'] = isset($params['QuanlyhocphithutruocSearch']['STATUS']) ? $params['QuanlyhocphithutruocSearch']['STATUS'] : 1;
        $dataProvider = $searchModel->searchhocphithutruoctheodonvi($params);
        $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
        $view = 'index';
        if (Yii::$app->user->can('hocphithutruoctheobuoi')) {
            $view = 'index_hocphithutruoctheobuoi';
        }
        return $this->render($view, [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dslop' => $dslop,
        ]);
    }

    /**
     * Displays a single hocsinh model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('quanlyhocphi') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionInchitiet($id)
    {
        $this->layout = 'printLayout';
        $model = Quanlyhocphithutruoc::findOne($id);
        if (Yii::$app->user->can('quanlyhocphi') && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $view = Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithutruoc ? Yii::$app->user->identity->nhanvien->iDDONVI->invoice_hocphithutruoc : 'inchitiet';
            return $this->render($view, [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    /**
     * Creates a new hocsinh model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('quanlyhocphi')) {
            $model = new Quanlyhocphithutruoc();
            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->STATUS = 1;
            if (Yii::$app->request->post()) {
                $inputs = Yii::$app->request->post();
                if ($inputs['Quanlyhocphithutruoc']['ID_HOCSINH']) {
                    $dshocsinh = $inputs['Quanlyhocphithutruoc']['ID_HOCSINH'];
                    foreach ($dshocsinh as $key => $value) {
                        $model = new Quanlyhocphithutruoc();
                        $model->ID_HOCSINH = $value;
                        if ($model->hocsinh->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
                            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                            $model->STATUS = 1;
                            $model->TIEUDE = $inputs['Quanlyhocphithutruoc']['TIEUDE'];
                            $model->ID_LOP = $inputs['Quanlyhocphithutruoc']['ID_LOP'];
                            $model->SOTIEN = $inputs['Quanlyhocphithutruoc']['SOTIEN'];
                            $model->SO_BH = $inputs['Quanlyhocphithutruoc']['SO_BH'];
                            if (!$model->SOTIEN && $model->hocsinh->TIENHOC) {
                                $model->SOTIEN = $inputs['Quanlyhocphithutruoc']['SO_BH'] * $model->hocsinh->TIENHOC;
                            }
                            $model->NGAY_BD = isset($inputs['Quanlyhocphithutruoc']['NGAY_BD']) ? $inputs['Quanlyhocphithutruoc']['NGAY_BD'] : null;
                            $model->NGAY_KT = isset($inputs['Quanlyhocphithutruoc']['NGAY_KT']) ? $inputs['Quanlyhocphithutruoc']['NGAY_KT'] : null;
                            $model->GHICHU = $inputs['Quanlyhocphithutruoc']['GHICHU'];
                            $model->TIENKHAC = $inputs['Quanlyhocphithutruoc']['TIENKHAC'];
                            $model->TIENKHAC = $model->TIENKHAC ? $model->TIENKHAC : null;
                            $model->TONGTIEN = $model->SOTIEN + $model->TIENKHAC - $model->TIENGIAM;
                            $model->save();
                        }
                    }
                }
                Yii::$app->session->setFlash('success', "Thêm mới thành công!");
                return $this->redirect(['index']);
            } else {
            $dslop = ArrayHelper::map(Lophoc::find()->where(['STATUS' => 1])->andWhere(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
                return $this->render('create', [
                    'model' => $model,
                    'dslop' => $dslop,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    /**
     * Updates an existing hocsinh model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('edit-hocsinh')) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $model->TONGTIEN = (int)$model->SOTIEN + (int)$model->TIENKHAC - (int)$model->TIENGIAM;
                $model->save();
                Yii::$app->session->setFlash('success', "Cập nhật thành công!");
                return $this->redirect(['index']);
            } else {
                $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
                return $this->render('update', [
                    'model' => $model,
                    'dslop' => $dslop,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Deletes an existing hocsinh model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('quanlyhocphi') && $model->STATUS == 1 && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
           $model->delete();
            Yii::$app->session->setFlash('success', "Hoàn thành xóa dữ liệu!");
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Finds the hocsinh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return hocsinh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quanlyhocphithutruoc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDuyetthuphitruoc()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $hocphi->STATUS == 1) {
                $hocphi->STATUS = 2;
                $hocphi->save();
                $hocphi->hocsinh->SOBH_DAMUA += $hocphi->SO_BH;
                $hocphi->hocsinh->NGAY_BD = $hocphi->hocsinh->NGAY_BD ? $hocphi->hocsinh->NGAY_BD : $hocphi->NGAY_BD;
                $hocphi->hocsinh->NGAY_KT = $hocphi->NGAY_KT;
                if ($hocphi->hocsinh->NGAY_KT) {
                    $hocphi->hocsinh->HT_HP = 3;
                } else {
                    $hocphi->hocsinh->HT_HP = 2;
                }
                $hocphi->hocsinh->save();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionModieuchinh()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $hocphi->STATUS == 2) {
                $hocphi->STATUS = 1;
                $hocphi->save();
                $hocphi->hocsinh->SOBH_DAMUA -= $hocphi->SO_BH;
                $hocphi->hocsinh->SOBH_DAMUA = $hocphi->hocsinh->SOBH_DAMUA > 0 ? $hocphi->SO_BH : 0;
                $hocphi->hocsinh->NGAY_KT = $hocphi->hocsinh->NGAY_BD;
                $hocphi->hocsinh->save();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionThaydoisotien()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($inputs['id']);
            $sotien = $inputs['sotien'];
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $hocphi->STATUS == 1) {
                $hocphi->SOTIEN = $sotien;
                $hocphi->SO_BH = $hocphi->hocsinh->TIENHOC ? round($hocphi->SOTIEN / $hocphi->hocsinh->TIENHOC, 0) : $hocphi->SO_BH;
                $hocphi->TONGTIEN = $hocphi->SOTIEN + $hocphi->TIENKHAC - $hocphi->TIENGIAM;
                $hocphi->save();
                $result['error'] = 0;
                $result['data'] = [
                    'ID' => $hocphi->ID,
                    'SOTIEN' => $hocphi->SOTIEN,
                    'SO_BH' => $hocphi->SO_BH,
                    'TIENKHAC' => $hocphi->TIENKHAC,
                    'TONGTIEN' => $hocphi->TONGTIEN,
                ];
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionThaydoisobuoihoc()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($inputs['id']);
            $sobh = $inputs['so_bh'];
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $hocphi->STATUS == 1) {
                $hocphi->SO_BH = $sobh;
                $hocphi->SOTIEN = $hocphi->hocsinh->TIENHOC ? $hocphi->hocsinh->TIENHOC * $hocphi->SO_BH : $hocphi->SOTIEN;
                $hocphi->TONGTIEN = $hocphi->SOTIEN + $hocphi->TIENKHAC - $hocphi->TIENGIAM;
                $hocphi->save();
                $result['error'] = 0;
                $result['data'] = [
                    'ID' => $hocphi->ID,
                    'SOTIEN' => $hocphi->SOTIEN,
                    'SO_BH' => $hocphi->SO_BH,
                    'TIENKHAC' => $hocphi->TIENKHAC,
                    'TONGTIEN' => $hocphi->TONGTIEN,
                ];
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionThaydoitienkhac()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($inputs['id']);
            $tienkhac = $inputs['tienkhac'];
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $hocphi->STATUS == 1) {
                $hocphi->TIENKHAC = $tienkhac;
                $hocphi->TONGTIEN = $hocphi->SOTIEN + $hocphi->TIENKHAC - $hocphi->TIENGIAM;
                $hocphi->save();
                $result['error'] = 0;
                $result['data'] = [
                    'ID' => $hocphi->ID,
                    'SOTIEN' => $hocphi->SOTIEN,
                    'SO_BH' => $hocphi->SO_BH,
                    'TIENKHAC' => $hocphi->TIENKHAC,
                    'TONGTIEN' => $hocphi->TONGTIEN,
                ];
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionThaydoimiengiam()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($inputs['id']);
            $miengiam = $inputs['miengiam'];
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $hocphi->STATUS == 1) {
                $hocphi->TIENGIAM = $miengiam;
                $hocphi->TONGTIEN = $hocphi->SOTIEN + $hocphi->TIENKHAC - $hocphi->TIENGIAM;
                $hocphi->save();
                $result['error'] = 0;
                $result['data'] = [
                    'ID' => $hocphi->ID,
                    'SOTIEN' => $hocphi->SOTIEN,
                    'SO_BH' => $hocphi->SO_BH,
                    'TIENKHAC' => $hocphi->TIENKHAC,
                    'TONGTIEN' => $hocphi->TONGTIEN,
                    'TIENGIAM' => $hocphi->TIENGIAM,
                ];
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCanhbaotheongay()
    {
        if (Yii::$app->user->can('quanlyhocphi')) {
            $searchModel = new HocsinhSearch();
            $params = Yii::$app->request->queryParams;
            $dataProvider = $searchModel->searchhocsinhhethantheongay($params);
            $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['STATUS' => 1])->all(), 'ID_LOP', 'TEN_LOP');
            $params['HocsinhSearch']['ID_LOP'] = isset($params['HocsinhSearch']['ID_LOP']) ? $params['HocsinhSearch']['ID_LOP'] : null;
            return $this->render('canhbaotheongay', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'dslop' => $dslop,
                'params' => $params,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCanhbaotheongayprint()
    {
        $this->layout = 'printLayout';
        if (Yii::$app->user->can('quanlyhocphi')) {
            $searchModel = new HocsinhSearch();
            $params = Yii::$app->request->queryParams;
            $params['HocsinhSearch']['ID_LOP'] = isset($params['HocsinhSearch']['ID_LOP']) ? $params['HocsinhSearch']['ID_LOP'] : null;
            $dataProvider = $searchModel->searchhocsinhhethantheongay($params);
            $result = $dataProvider->query->all();
            return $this->render('canhbaotheongay_print', [
                'result' => $result,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCanhbaotheosobuoihoc()
    {
        if (Yii::$app->user->can('quanlyhocphi')) {
            $params = Yii::$app->request->queryParams;
            $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['STATUS' => 1])->all(), 'ID_LOP', 'TEN_LOP');
            $dsidlop = (isset($params['ID_LOP'])  && $params['ID_LOP']) ? [$params['ID_LOP'] => $params['ID_LOP']] : array_keys($dslop);
            $sql = "SELECT bh.TEN_LOP, bh.HO_TEN,bh.SOLUONG_DAHOC, bdt.SOLUONG_DADONGTIEN,(bdt.SOLUONG_DADONGTIEN - bh.SOLUONG_DAHOC) SOBUOI_CONLAI FROM
            (SELECT b.ID,a.TEN_LOP, b.HO_TEN, sum(case when c.`STATUS` = 1 then 1 ELSE 0 END) SOLUONG_DAHOC FROM lophoc a, hocsinh b, diemdanhhocsinh c WHERE a.ID_LOP = b.ID_LOP AND b.ID = c.ID_HOCSINH AND a.ID_DONVI = :ID_DONVI and a.ID_LOP IN (" . implode(',', $dsidlop) . ") AND b.HT_HP IN (0,2) and b.NGAY_KT IS NULL GROUP BY b.ID,a.TEN_LOP, b.HO_TEN) bh,
            (SELECT b.ID, sum(case when c.`STATUS` = 2 then c.SO_BH ELSE 0 END) SOLUONG_DADONGTIEN FROM lophoc a INNER JOIN  hocsinh b ON a.ID_LOP = b.ID_LOP LEFT join quanlyhocphithutruoc c ON b.ID = c.ID_HOCSINH WHERE a.ID_DONVI = :ID_DONVI and a.ID_LOP IN (" . implode(',', $dsidlop) . ") AND b.HT_HP IN (0,2) AND b.STATUS = 1 GROUP BY b.ID) bdt
            WHERE bh.ID = bdt.ID ORDER BY bh.TEN_LOP asc, (bdt.SOLUONG_DADONGTIEN - bh.SOLUONG_DAHOC) ASC";
            $result = Yii::$app->db->createCommand($sql)->bindValues(
                [
                    ':ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
                ])->queryAll();
            if (isset($params['is_excel']) && $params['is_excel']) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $spreadsheet->createSheet();
                $spreadsheet->setActiveSheetIndex(0);
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->fromArray(
                    ['STT', 'LỚP', 'HỌC SINH', 'SỐ BUỔI ĐÃ THU TIỀN', 'SỐ BUỔI ĐÃ HỌC', 'SỐ BUỔI CÒN LẠI'],
                    '',
                    'A1'
                );
                $sheet->fromArray(
                    $result,
                    '',
                    'A2'
                );
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                $file_name = "DS CHƯA 5S";
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'. 'DỮ LIỆU TỔNG HỢP HỌC PHÍ - ' . Yii::$app->user->identity->nhanvien->iDDONVI->TEN_DONVI .'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save("php://output");
                exit;
            }

            if (isset($params['is_print']) && $params['is_print']) {
                $this->layout = 'printLayout';
                return $this->render('canhbaotheosobuoihoc_print', [
                'result' => $result,
            ]);
            }
            return $this->render('canhbaotheosobuoihoc', [
                'result' => $result,
                'dslop' => $dslop,
                'params' => $params,
            ]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBaocaohocphithutruoc()
    {
        $params = Yii::$app->request->queryParams;
        $params['TU_NGAY'] = isset($params['TU_NGAY']) ? $params['TU_NGAY'] : date("Y-m-1");
        $params['DEN_NGAY'] = isset($params['DEN_NGAY']) ? $params['DEN_NGAY'] : date('Y-m-d');
        $searchModel = new QuanlyhocphithutruocSearch();
        $result = $searchModel->baocaohocphithutruoc($params);
        return $this->render('baocaohocphithutruoc', [
            'result' => $result,
            'params' => $params,
        ]);
    }

    public function actionThaydoingaybd()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($inputs['id']);
            $ngaybd = $inputs['ngaybd'];
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $hocphi->STATUS == 1) {
                $hocphi->NGAY_BD = $ngaybd;
                $hocphi->save();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionThaydoingaykt()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $hocphi = Quanlyhocphithutruoc::findOne($inputs['id']);
            $ngaykt = $inputs['ngaykt'];
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $hocphi->STATUS == 1) {
                $hocphi->NGAY_KT = $ngaykt;
                $hocphi->save();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTinhngayketthuc()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $lophoc = Lophoc::findOne($inputs['lopid']);
            $ngaybd = new \DateTime($inputs['ngay_bd']);
            $sobh = $inputs['sobh'];
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($lophoc && $lophoc->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $sobh && $ngaybd) {
                $i = 0;
                while ($i < $sobh) {
                    $dateonweek = date_format($ngaybd, 'w');
                    if (in_array($dateonweek, explode(',', $lophoc->ds_lichcodinh))) {
                        $i ++;
                    }
                    $ngaybd = $ngaybd->modify('+1 day');
                }
                $ngaykt = $ngaybd;
                $result['NGAY_KT'] = $ngaykt->format('Y-m-d');
                $result['error'] = 0;
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
            if ($hocphi && $hocphi->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $hocphi->STATUS == 1) {
                $hocphi->GHICHU = $params['ghichu'];
                $hocphi->save();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTinhsobuoihoc()
    {
        if (Yii::$app->user->can('quanlyhocphi') &&Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $inputs = Yii::$app->request->post();
            $lophoc = Lophoc::findOne($inputs['lopid']);
            $tungay = new \DateTime($inputs['tu_ngay']);
            $denngay = new \DateTime($inputs['den_ngay']);
            $result = [
                'error' => 1,
                'data' => [],
                'message' => 'Lỗi cập nhật!',
            ];
            if ($lophoc && $lophoc->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $tungay && $denngay) {
                $sobh = 0;
                $currentdate = $tungay;
                while ($currentdate < $denngay) {
                    $dateonweek = date_format($currentdate, 'w');
                    if (in_array($dateonweek, explode(',', $lophoc->ds_lichcodinh))) {
                        $sobh ++;
                    }
                    $currentdate = $currentdate->modify('+1 day');
                }
                $result['SO_BH'] = $sobh;
                $result['TIENHOC'] = $sobh * $lophoc->TIENHOC;
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
