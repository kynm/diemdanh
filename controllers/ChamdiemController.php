<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Lophoc;
use app\models\LophocSearch;
use app\models\Hocsinh;
use app\models\HocsinhSearch;
use app\models\Chamdiem;
use app\models\ChamdiemSearch;
use app\models\Chamdiemhocsinh;
use app\models\ChamdiemhocsinhSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * LophocController implements the CRUD actions for Lophoc model.
 */
class ChamdiemController extends Controller
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

    public function actionChamdiemlophoc($idlophoc)
    {
        if ((Yii::$app->user->can('diemdanhlophoc') || Yii::$app->user->can('chamdiemlophoc')) && $idlophoc) {
            $chamdiem = new Chamdiem();
            $model = Lophoc::findOne($idlophoc);
            $chamdiem->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $chamdiem->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $chamdiem->ID_LOP  = $idlophoc;
            $chamdiem->NGAY_CHAMDIEM = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d');
            $params = Yii::$app->request->queryParams;
            $searchModel = new ChamdiemSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idlophoc);
            return $this->render('chamdiemlophoc', [
                'model' => $model,
                'chamdiem' => $chamdiem,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionThemchamdiem($idlophoc)
    {
        $model = Lophoc::findOne($idlophoc);
        if (Yii::$app->user->can('diemdanhlophoc') && $model && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI && $model->STATUS == 1) {
            $chamdiem = new Chamdiem();
            $chamdiem->ID_DONVI = Yii::$app->user->identity->nhanvien->ID_DONVI;
            $chamdiem->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $chamdiem->ID_LOP  = $idlophoc;
            if ($chamdiem->load(Yii::$app->request->post())) {
                $chamdiem->save();
                foreach ($model->getDshocsinh()->andWhere(['STATUS' => 1])->all() as $key => $hocsinh) {
                    $chamdiemhocsinh = Chamdiemhocsinh::find()->where(['ID_HOCSINH' => $hocsinh->ID])->andWhere(['ID_chamdiem' => $chamdiem->ID])->one();
                    if (!$chamdiemhocsinh) {
                        $chamdiemhocsinh = new chamdiemhocsinh();
                        $chamdiemhocsinh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                        $chamdiemhocsinh->ID_LOP = $idlophoc;
                        $chamdiemhocsinh->ID_HOCSINH = $hocsinh->ID;
                        $chamdiemhocsinh->ID_CHAMDIEM = $chamdiem->ID;
                        $chamdiemhocsinh->save(false);
                    }
                }
                Yii::$app->session->setFlash('success', "Thêm điểm danh thành công!");
                return $this->redirect(['capnhatchamdiem', 'id' => $chamdiem->ID]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionCapnhatchamdiem($id)
    {
        $chamdiem = Chamdiem::findOne($id);
        if (Yii::$app->user->can('diemdanhlophoc') && $chamdiem && $chamdiem->lop->STATUS == 1) {
            return $this->render('capnhatchamdiem', [
                'chamdiem' => $chamdiem,
            ]);
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
    public function actionXoachamdiem()
    {
        $params = Yii::$app->request->post();
        $model = $this->findModel($params['id']);
        if ($model && $model->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI &&Yii::$app->user->can('diemdanhlophoc')) {
            Chamdiemhocsinh::deleteAll(['ID_CHAMDIEM' => $model->ID, 'ID_CHAMDIEM' => $model->ID]);
            $model->delete();
            Yii::$app->session->setFlash('success', "Xóa thành công!");
            return $this->redirect(['chamdiemlophoc', 'idlophoc' => $model->ID_LOP]);
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
        if (($model = Chamdiem::findOne($id)) !== null) {
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
            echo "<option value=''>Chọn học sinh</option>";
            foreach($result as $each) {
                echo "<option value='" . $each->ID . "'>" . $each->HO_TEN . "</option>";
            }
            return;
        }
    }

    public function actionBoxungchamdiemlophoc()
    {
        if (Yii::$app->user->can('diemdanhlophoc') && Yii::$app->request->post()) {
        $params = Yii::$app->request->post();
        $chamdiem = Chamdiem::find()->where(['ID' => $params['chamdiemid']])->one();
        if ($chamdiem && $chamdiem->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $result = [
                'error' => 1,
                'message' => 'LỖI CẬP NHẬT',
            ];
            $dshsdadt = ArrayHelper::map(Chamdiemhocsinh::find()->where(['ID_CHAMDIEM' => $params['chamdiemid']])->all(), 'ID_HOCSINH', 'ID_HOCSINH');
            $dshocsinhthieu = Hocsinh::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['ID_LOP' => $chamdiem->ID_LOP])->andWhere(['not in', 'ID', $dshsdadt])->all();
            if (!$dshocsinhthieu) {
                $result = [
                    'error' => 1,
                    'message' => 'KHÔNG CÓ HỌC SINH MỚI',
                ];
            } else {
                foreach ($dshocsinhthieu as $key => $hocsinh) {
                    $chamdiemhocsinh = new Chamdiemhocsinh();
                    $chamdiemhocsinh->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
                    $chamdiemhocsinh->ID_LOP = $chamdiem->ID_LOP;
                    $chamdiemhocsinh->ID_HOCSINH = $hocsinh->ID;
                    $chamdiemhocsinh->ID_CHAMDIEM = $chamdiem->ID;
                    $chamdiemhocsinh->save();
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

    public function actionCapnhatghichuchamdiem($id)
    {
        $chamdiem = Chamdiem::findOne($id);
        if ($chamdiem->load(Yii::$app->request->post()) && Yii::$app->user->identity->nhanvien->ID_DONVI == $chamdiem->ID_DONVI) {
            $chamdiem->save();
            Yii::$app->session->setFlash('success', "Cập nhật thành công!");
            return $this->redirect(['/chamdiem/capnhatchamdiem', 'id' => $chamdiem->ID]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCapnhatghichu()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $chamdiemhocsinh = Chamdiemhocsinh::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => 'LỖI CẬP NHẬT',
            ];
            if ($chamdiemhocsinh && $chamdiemhocsinh->chamdiem->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $chamdiemhocsinh->NHAN_XET = $params['capnhatghichu'];
                $chamdiemhocsinh->save();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCapnhatdiem()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $chamdiemhocsinh = Chamdiemhocsinh::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => 'LỖI CẬP NHẬT',
            ];
            if ($chamdiemhocsinh && $chamdiemhocsinh->chamdiem->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $chamdiemhocsinh->DIEM = $params['diem'];
                $chamdiemhocsinh->save();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChitietchamdiem($idlophoc)
    {
        $lophoc = Lophoc::findOne($idlophoc);
        if ((Yii::$app->user->can('diemdanhlophoc') || Yii::$app->user->can('chamdiemlophoc')) && $lophoc && $lophoc->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $searchModel = new ChamdiemhocsinhSearch();
            $dataProvider = $searchModel->searchdiemtheolop(Yii::$app->request->queryParams, $idlophoc);
            $dshocsinh = ArrayHelper::map(Hocsinh::find()->where(['ID_LOP' => $idlophoc])->all(), 'ID', 'HO_TEN');
            return $this->render('chitietchamdiem', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'lophoc' => $lophoc,
                'dshocsinh' => $dshocsinh,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }

    public function actionBaocao($idlophoc)
    {
        $lophoc = Lophoc::findOne($idlophoc);
        if ((Yii::$app->user->can('diemdanhlophoc') || Yii::$app->user->can('chamdiemlophoc')) && $lophoc && $lophoc->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $params = Yii::$app->request->queryParams;
            $params['TU_NGAY'] = isset($params['TU_NGAY']) ? $params['TU_NGAY'] : date("Y-m-1");
            $params['DEN_NGAY'] = isset($params['DEN_NGAY']) ? $params['DEN_NGAY'] : date('Y-m-d');
            $sql = 'SELECT a.ID ID_CHAMDIEM,a.TIEUDE, a.NGAY_CHAMDIEM,c.ID ID_HOCSINH,c.HO_TEN,b.DIEM FROM chamdiem a, chamdiemhocsinh b, hocsinh c
                WHERE a.ID = b.ID_CHAMDIEM AND b.ID_HOCSINH = c.ID AND c.ID_DONVI = :ID_DONVI AND c.ID_LOP = ' . $idlophoc . '
                ORDER BY a.NGAY_CHAMDIEM, c.HO_TEN desc';
            $result = Yii::$app->db->createCommand($sql)->bindValues(
                [
                    // ':TU_NGAY' => $params['TU_NGAY'],
                    // ':DEN_NGAY' => $params['DEN_NGAY'],
                    ':ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI,
                    // 'idlophoc' => (int)$idlophoc,
                ])->queryAll();
            $header = [];
            $rows= [];
            foreach ($result as $key => $value) {
                $header[$value['ID_CHAMDIEM']] = $value['TIEUDE'];
                $rows[$value['ID_HOCSINH']]['HO_TEN'] = $value['HO_TEN'];
                $rows[$value['ID_HOCSINH']]['DIEM'][$value['ID_CHAMDIEM']]['DIEM'] = $value['DIEM'];
            }
            return $this->render('baocao', [
                'header' => $header,
                'rows' => $rows,
                'lophoc' => $lophoc,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }
}
