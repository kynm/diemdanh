<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Quanlyhocphithutruoc;
use app\models\Lophoc;
use app\models\Hocsinh;
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

    /**
     * Lists all hocsinh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuanlyhocphithutruocSearch();
        $dataProvider = $searchModel->searchhocphithutruoctheodonvi(Yii::$app->request->queryParams);
        $dslop = ArrayHelper::map(Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->all(), 'ID_LOP', 'TEN_LOP');
        return $this->render('index', [
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
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
                            $model->ID_LOP = $inputs['Quanlyhocphithutruoc']['ID_LOP'];
                            $model->SOTIEN = $inputs['Quanlyhocphithutruoc']['SOTIEN'];
                            $model->SO_BH = $inputs['Quanlyhocphithutruoc']['SO_BH'];
                            $model->NGAY_BD = $inputs['Quanlyhocphithutruoc']['NGAY_BD'];
                            $model->NGAY_KT = $inputs['Quanlyhocphithutruoc']['NGAY_KT'];
                            $model->GHICHU = $inputs['Quanlyhocphithutruoc']['GHICHU'];
                            $model->TIENKHAC = $inputs['Quanlyhocphithutruoc']['TIENKHAC'];
                            $model->TIENKHAC = $model->TIENKHAC ? $model->TIENKHAC : null;
                            $model->TONGTIEN = $model->SOTIEN + $model->TIENKHAC;
                            $model->save();
                        }
                    }
                }
                Yii::$app->session->setFlash('success', "Thêm mới thành công!");
                return $this->redirect(['index']);
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

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
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
                $hocphi->hocsinh->NGAY_KT = $hocphi->NGAY_KT;
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
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
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
                $hocphi->hocsinh->NGAY_KT = $hocphi->NGAY_BD ? $hocphi->NGAY_BD : null;
                $hocphi->hocsinh->save();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}


    // $('#quanlyhocphithutruoc-sotien').on('change', function() {
    //   var sotien = $(this).val();
    //   var idhocsinh = $("#quanlyhocphithutruoc-id_hocsinh").val();
    //   var lopid = $("#quanlyhocphithutruoc-id_lop").val();
    //   if (!idhocsinh) {
    //         Swal.fire('Cần chọn học sinh nộp học phí');
    //         return 1;
    //   }
    //     $.ajax({
    //         url: '/quanlyhocphithutruoc/checksobuoi',
    //         method: 'POST',
    //         data: {
    //             'lopid' : lopid,
    //             'idhocsinh' : idhocsinh,
    //             'sotien' : sotien,
    //         },
    //         success:function(data) {
    //             data = jQuery.parseJSON(data);
    //             if (!data.error) {
    //                 $("#quanlyhocphithutruoc-so_bh").val(data.value);
    //             } else {
    //                 Swal.fire(data.message);
    //             }
    //         }
    //     });
    // });