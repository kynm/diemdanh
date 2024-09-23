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
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * QuanlylichhocController implements the CRUD actions for Lophoc model.
 */
class QuanlylichhocController extends Controller
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

    public function actionThaydoilichhoccodinh()
    {
        if (Yii::$app->user->can('quanlytruonghoc')) {
            $result = [
                'error' => 1,
                'message' => 'LỖI CẬP NHẬT',
            ];
            $inputs = Yii::$app->request->post();
            $lop = Lophoc::findOne($inputs['idlop']);
            if ($lop && $lop->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $ds_lichcodinh = isset($inputs['ds_lichcodinh']) ? implode(',', $inputs['ds_lichcodinh']) : null;
                $lop->ds_lichcodinh = $ds_lichcodinh;
                $lop->save();
                $result = [
                    'error' => null,
                    'message' => 'CẬP NHẬT THÀNH CÔNG',
                ];
            }

            return json_encode($result);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChitietbanglichhoccodinh()
    {
        if (Yii::$app->user->can('quanlytruonghoc')) {
            $dslop = Lophoc::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['STATUS' => 1])->select(['TEN_LOP', 'ds_lichcodinh'])->all();
            return $this->render('chitietbanglichhoccodinh', [
                'dslop' => $dslop,
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');           
        }
    }
}
