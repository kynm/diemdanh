<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Lophoc;
use app\models\LophocSearch;
use app\models\Hocsinh;
use app\models\HocsinhSearch;
use app\models\Quanlydiemdanh;
use app\models\QuanlydiemdanhSearch;
use app\models\Diemdanhhocsinh;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * LophocController implements the CRUD actions for Lophoc model.
 */
class LophocController extends Controller
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
     * Lists all Lophoc models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('quanlytruonghoc')) {
            $searchModel = new LophocSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    /**
     * Displays a single Lophoc model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $params = Yii::$app->request->queryParams;
            $params['TU_NGAY'] = isset($params['TU_NGAY']) ? $params['TU_NGAY'] : date('Y-m-1');
            $params['DEN_NGAY'] = isset($params['DEN_NGAY']) ? $params['DEN_NGAY'] : date('Y-m-d');
            $sql = "SELECT c.HO_TEN, COUNT(1) SO_LUONG, SUM(CASE WHEN b.`STATUS` > 0 then 1 ELSE 0 END) SOLUONGDIHOC
            , GROUP_CONCAT(CASE WHEN b.`STATUS` = 0 then day(a.NGAY_DIEMDANH) ELSE null END) NGAYNGHI
            FROM quanlydiemdanh a, diemdanhhocsinh b, hocsinh c
                WHERE a.ID = b.ID_DIEMDANH AND b.ID_HOCSINH = c.ID and a.ID_LOP = :ID_LOP AND a.NGAY_DIEMDANH BETWEEN :TU_NGAY and :DEN_NGAY GROUP BY c.HO_TEN,c.ID order by c.ID";
            $data = Yii::$app->db->createCommand($sql)->bindValues(
                [
                    ':TU_NGAY' => $params['TU_NGAY'],
                    ':DEN_NGAY' => $params['DEN_NGAY'],
                    ':ID_LOP' => $id,
                ])->queryAll();
            return $this->render('view', [
                'model' => $model,
                'params' => $params,
                'data' => $data,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionQuanlyhocsinh($id)
    {
        $model = $this->findModel($id);
        if ((Yii::$app->user->can('quanlyhocsinh') || Yii::$app->user->can('diemdanhlophoc')) && $id && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $hocsinh = new Hocsinh();
            $hocsinh->ID_DONVI = $model->ID_DONVI;
            $hocsinh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $hocsinh->ID_LOP  = $id;
            $searchModel = new HocsinhSearch();
            $dataProvider = $searchModel->searchhocsinhtheolop(Yii::$app->request->queryParams, $id);
            $hocsinh->TIENHOC = $hocsinh->lop->TIENHOC;
            return $this->render('quanlyhocsinh', [
                'model' => $model,
                'hocsinh' => $hocsinh,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    public function actionThemhocsinh($id)
    {
        if (Yii::$app->user->identity->nhanvien->iDDONVI->SO_HS <= Yii::$app->user->identity->nhanvien->iDDONVI->getHocsinh()->andWhere(['STATUS' => 1])->count()) {
            Yii::$app->session->setFlash('error', "SỐ HỌC SINH VƯỢT QUÁ GIỚI HẠN CỦA GÓI, VUI LÒNG LIÊN HỆ QUẢN ĐỂ ĐƯỢC HỖ TRỢ!");
                return $this->redirect(['quanlyhocsinh', 'id' => $id]);
        }
        if (Yii::$app->user->can('quanlyhocsinh') && $id) {
            $hocsinh = new Hocsinh();
            $model = $this->findModel($id);
            $hocsinh->ID_DONVI = $model->ID_DONVI;
            $hocsinh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $hocsinh->ID_LOP  = $id;
            $hocsinh->MA_HOCSINH  = $model->MA_LOP . '-' . rand_string(4);
            if ($hocsinh->load(Yii::$app->request->post())) {
                $hocsinh->save();
                Yii::$app->session->setFlash('success', "Thêm học sinh thành công!");
                return $this->redirect(['quanlyhocsinh', 'id' => $id]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionQuanlydiemdanh($id)
    {
        if ((Yii::$app->user->can('quanlydiemdanh') || Yii::$app->user->can('diemdanhlophoc')) && $id) {
            $diemdanh = new Quanlydiemdanh();
            $model = $this->findModel($id);
            $diemdanh->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $diemdanh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $diemdanh->ID_LOP  = $id;
            $diemdanh->NGAY_DIEMDANH = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
            $params = Yii::$app->request->queryParams;
            $params['TU_NGAY'] = isset($params['TU_NGAY']) ? $params['TU_NGAY'] : date("Y-m-d", strtotime("-1 month"));
            $params['DEN_NGAY'] = isset($params['DEN_NGAY']) ? $params['DEN_NGAY'] : date('Y-m-d');
            $searchModel = new QuanlydiemdanhSearch();
            $result = $searchModel->searchDiemdanhtheolop($params, $id);
            return $this->render('quanlydiemdanh', [
                'model' => $model,
                'diemdanh' => $diemdanh,
                'result' => $result,
                'params' => $params,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionThemdiemdanh($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('diemdanhlophoc') && $id && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $model->STATUS == 1) {
            $diemdanh = new Quanlydiemdanh();
            $diemdanh->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $diemdanh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $diemdanh->ID_LOP  = $id;
            $diemdanh->NOIDUNG = $model->TEMP_NHANXET;
            if ($diemdanh->load(Yii::$app->request->post())) {
                $diemdanhnow = $model->getDsdiemdanh()->andWhere(['NGAY_DIEMDANH' => $diemdanh->NGAY_DIEMDANH])->one();
                if ($diemdanhnow) {
                    Yii::$app->session->setFlash('error', "Điểm danh đã tồn tại!");
                    return $this->redirect(['capnhatdiemdanh', 'diemdanhid' => $diemdanhnow->ID]);
                }
                $diemdanh->save();
                foreach ($model->getDshocsinh()->andWhere(['STATUS' => 1])->all() as $key => $hocsinh) {
                    $diemdanhhocsinh = Diemdanhhocsinh::find()->where(['ID_HOCSINH' => $hocsinh->ID])->andWhere(['ID_DIEMDANH' => $diemdanh->ID])->one();
                    if (!$diemdanhhocsinh) {
                        $diemdanhhocsinh = new Diemdanhhocsinh();
                        $diemdanhhocsinh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                        $diemdanhhocsinh->ID_LOP = $id;
                        $diemdanhhocsinh->ID_HOCSINH = $hocsinh->ID;
                        $diemdanhhocsinh->ID_DIEMDANH = $diemdanh->ID;
                        $diemdanhhocsinh->save(false);
                    }
                }
                Yii::$app->session->setFlash('success', "Thêm điểm danh thành công!");
                return $this->redirect(['capnhatdiemdanh', 'diemdanhid' => $diemdanh->ID]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionCapnhatdiemdanh($diemdanhid)
    {
        $diemdanh = Quanlydiemdanh::find()->where(['ID' => $diemdanhid])->one();
        if (Yii::$app->user->can('diemdanhlophoc') && $diemdanh && $diemdanh->lop->STATUS == 1) {
            return $this->render('capnhatdiemdanh', [
                'diemdanh' => $diemdanh,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionCapnhattrangthaidiemdanh($diemdanhhsid)
    {
        if (Yii::$app->request->post() && Yii::$app->user->can('diemdanhlophoc') && $diemdanhhsid) {
            $result = [];
            $diemdanhhs = Diemdanhhocsinh::find()->where(['ID' => $diemdanhhsid])->one();
            $params = Yii::$app->request->post();
            $diemdanhhs->STATUS = $params['STATUS'];
            $diemdanhhs->save();
            $result['error'] = 0;
            $result['message'] = 'Cập nhật thành công';

            return json_encode($result);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Creates a new Lophoc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->identity->nhanvien->iDDONVI->SO_LOP <= Yii::$app->user->identity->nhanvien->iDDONVI->getLophoc()->andWhere(['STATUS' => 1])->count()) {
            Yii::$app->session->setFlash('error', "SỐ LỚP HỌC VƯỢT QUÁ GIỚI HẠN CỦA GÓI, VUI LÒNG LIÊN HỆ QUẢN ĐỂ ĐƯỢC HỖ TRỢ!");
                return $this->redirect(['index']);
        }
        if (Yii::$app->user->can('create-lophoc')) {
            $model = new Lophoc();
            $model->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $model->MA_LOP = $model->ID_DONVI . '-' . Yii::$app->user->identity->nhanvien->iDDONVI->MA_DONVI . '-' . rand_string(4);

            if ($model->load(Yii::$app->request->post())) {
                $model->save();
                $model->MA_LOP = Yii::$app->user->identity->nhanvien->iDDONVI->MA_DONVI . Yii::$app->user->identity->nhanvien->iDDONVI->getLophoc()->count();
                $log = new ActivitiesLog;
                $log->activity_type = 'unit-add';
                $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã thêm đơn vị ". $model->MA_LOP;
                $log->user_id = Yii::$app->user->identity->id;
                $log->create_at = time();
                $log->save();
                return $this->redirect(['view', 'id' => $model->ID_LOP]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    /**
     * Updates an existing Lophoc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('edit-lophoc')) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->ID_LOP]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Deletes an existing Lophoc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('quanlytruonghoc')) {
            $this->findModel($id)->delete();
            
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }

    /**
     * Finds the Lophoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lophoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lophoc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionListdshocsinhtheolop() {
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            $result = Hocsinh::find()
            ->where(['ID_DONVI'=> Yii::$app->user->identity->nhanvien->ID_DONVI])
            ->where(['ID_LOP'=> $params['lopid']])
            ->all();
            echo "<option value=''>Chọn công việc</option>";
            foreach($result as $each) {
                echo "<option value='" . $each->ID . "'>" . $each->HO_TEN . "</option>";
            }
            return;
        }
    }

    public function actionDoitrangthailop() {
        $result = [
            'error' => 1,
            'message' => 'LỖI CẬP NHẬT',
        ];
        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
            $lop = Lophoc::findOne($params['idlop']);
            if ($lop->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && Yii::$app->user->can('quanlytruonghoc')) {
                $lop->STATUS = $params['STATUS'] ? 1 : 0;
                $condition = ['and',
                    ['=', 'ID_LOP', $lop->ID_LOP],
                    ['=', 'ID_DONVI', $lop->ID_DONVI],
                ];
                if ($lop->STATUS) {
                    Hocsinh::updateAll([
                        'STATUS' => 1,
                    ], $condition);
                } else {
                    Hocsinh::updateAll([
                        'STATUS' => 0,
                    ], $condition);
                }
                $lop->save();
                $result = [
                    'error' => 0,
                    'message' => 'CẬP NHẬT THÀNH CÔNG',
                ];
            }
        }

        return json_encode($result);
    }


    public function actionThemdiemdanhthucong($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->can('diemdanhlophoc') && $id && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $model->STATUS == 1) {
            $diemdanh = new Quanlydiemdanh();
            $diemdanh->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $diemdanh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $diemdanh->NGAY_DIEMDANH  = date('Y-m-d');
            $diemdanh->ID_LOP  = $id;
            if ($diemdanh->load(Yii::$app->request->post())) {
                $diemdanhnow = $model->getDsdiemdanh()->andWhere(['NGAY_DIEMDANH' => $diemdanh->NGAY_DIEMDANH])->one();
                if ($diemdanhnow) {
                    Yii::$app->session->setFlash('error', "Điểm danh đã tồn tại!");
                    return $this->redirect(['capnhatdiemdanh', 'diemdanhid' => $diemdanhnow->ID]);
                }
                if (!$diemdanh->NGAY_DIEMDANH) {
                    Yii::$app->session->setFlash('error', "Bạn phải nhập ngày điểm danh!");
                    return $this->redirect(['/lophoc/quanlydiemdanh', 'id' => $id]);
                }
                $diemdanh->save();
                if (!$diemdanh->errors) {
                    $inputs = Yii::$app->request->post();
                    foreach ($inputs['HOCSINH'] as $key => $chitiet) {
                        if (isset($chitiet['STATUS'])) {
                            $diemdanhhocsinh = new Diemdanhhocsinh();
                            $diemdanhhocsinh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                            $diemdanhhocsinh->ID_LOP = $id;
                            $diemdanhhocsinh->ID_HOCSINH = $chitiet['ID_HOCSINH'];
                            $diemdanhhocsinh->ID_DIEMDANH = $diemdanh->ID;
                            $diemdanhhocsinh->STATUS = $chitiet['STATUS'];
                            $diemdanhhocsinh->NHAN_XET = isset($chitiet['NHAN_XET']) ? $chitiet['NHAN_XET'] : null;
                            $diemdanhhocsinh->save();
                        }
                    }
                }
                Yii::$app->session->setFlash('success', "Thêm điểm danh thành công!");
                return $this->redirect(['capnhatdiemdanh', 'diemdanhid' => $diemdanh->ID]);
            }

            return $this->render('themdiemdanhthucong', [
                'diemdanh' => $diemdanh,
                'dshocsinh' => $model->getDshocsinh()->andWhere(['STATUS' => 1])->all(),
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionBoxungdiemdanhlophoc()
    {
        if (Yii::$app->user->can('diemdanhlophoc') && Yii::$app->request->post()) {
        $params = Yii::$app->request->post();
        $diemdanh = Quanlydiemdanh::find()->where(['ID' => $params['diemdanhid']])->one();
        if ($diemdanh) {
            $result = [
                'error' => 1,
                'message' => 'LỖI CẬP NHẬT',
            ];
            $dshsdadt = ArrayHelper::map(Diemdanhhocsinh::find()->where(['ID_DIEMDANH' => $params['diemdanhid']])->all(), 'ID_HOCSINH', 'ID_HOCSINH');
            $dshocsinhthieu = Hocsinh::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['ID_LOP' => $diemdanh->ID_LOP])->andWhere(['STATUS' => 1])->andWhere(['not in', 'ID', $dshsdadt])->all();
            if (!$dshocsinhthieu) {
                $result = [
                    'error' => 1,
                    'message' => 'KHÔNG CÓ HỌC SINH MỚI',
                ];
            } else {
                foreach ($dshocsinhthieu as $key => $hocsinh) {
                    $diemdanhhocsinh = new Diemdanhhocsinh();
                    $diemdanhhocsinh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                    $diemdanhhocsinh->ID_LOP = $diemdanh->ID_LOP;
                    $diemdanhhocsinh->ID_HOCSINH = $hocsinh->ID;
                    $diemdanhhocsinh->ID_DIEMDANH = $diemdanh->ID;
                    $diemdanhhocsinh->STATUS = 1;
                    $diemdanhhocsinh->save();
                }
                $result = [
                    'error' => 0,
                    'message' => 'CẬP NHẬT THÀNH CÔNG: ' . ($key + 1) . ' HỌC SINH',
                ];
            }

            return json_encode($result);

        }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }
}
