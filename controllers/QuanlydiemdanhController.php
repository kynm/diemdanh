<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Quanlydiemdanh;
use app\models\Diemdanhhocsinh;
use app\models\Lophoc;
use app\models\QuanlydiemdanhSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * diemdanhController implements the CRUD actions for diemdanh model.
 */
class QuanlydiemdanhController extends Controller
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
        if (Yii::$app->user->can('quanlytruonghoc')) {
            $searchModel = new QuanlydiemdanhSearch();
            $dataProvider = $searchModel->searchdiemdanhtheodonvi(Yii::$app->request->queryParams);

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

    /**
     * Displays a single diemdanh model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionIndiemdanhngay($id)
    {
        $this->layout = 'printLayout';
        $model = Quanlydiemdanh::findOne($id);
        return $this->render('indeimdanhngay', [
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
        if (($model = Quanlydiemdanh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCapnhatghichu()
    {
        if (Yii::$app->request->post() && Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $params = Yii::$app->request->post();
            $diemdanh = Diemdanhhocsinh::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => 'LỖI CẬP NHẬT',
            ];
            if ($diemdanh && $diemdanh->diemdanh->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $diemdanh->NHAN_XET = $params['capnhatghichu'];
                $diemdanh->save();
                $result['error'] = 0;
                $result['message'] = 'Cập nhật thành công';
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionXoadiemdanh()
    {
            $params = Yii::$app->request->post();
            $diemdanh = Quanlydiemdanh::findOne($params['id']);
            $result = [
                'error' => 1,
                'message' => 'LỖI CẬP NHẬT',
            ];
        if (Yii::$app->user->can('quanlytruonghoc') && $diemdanh && $diemdanh->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
            $log = new ActivitiesLog;
            $log->activity_type = 'xoadiemdanh';
            $log->description = Yii::$app->user->identity->nhanvien->TEN_NHANVIEN." đã xóa điểm danh:  ". $diemdanh->ID . ', ' . $diemdanh->TIEUDE . ', ĐƠN VỊ: ' . $diemdanh->donvi->TEN_DONVI  . ', LỚP:' . $diemdanh->lop->TEN_LOP;
            $log->user_id = Yii::$app->user->identity->id;
            $log->create_at = time();
            $log->save();
            Diemdanhhocsinh::deleteAll(['ID_DIEMDANH' => $diemdanh->ID]);
            $diemdanh->delete();
            Yii::$app->session->setFlash('success', "Xóa thành công!");
            $result = [
                'error' => null,
                'message' => 'Xóa thành công',
            ];
        }

        return json_encode($result);
    }

    public function actionCapnhatghichubuoihoc($id)
    {
        $quanlydiemdanh = Quanlydiemdanh::findOne($id);
        if ($quanlydiemdanh->load(Yii::$app->request->post()) && Yii::$app->user->identity->nhanvien->ID_NHANVIEN == $quanlydiemdanh->ID_NHANVIEN) {
            $quanlydiemdanh->save();
            Yii::$app->session->setFlash('success', "Cập nhật thành công!");
            return $this->redirect(['/lophoc/capnhatdiemdanh', 'diemdanhid' => $quanlydiemdanh->ID]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}