<?php

namespace app\controllers;

use Yii;
use app\models\Nhanvien;
use app\models\Dotbaoduong;
use app\models\DotbaoduongSearch;
use app\models\Noidungcongviec;
use app\models\NoidungcongviecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;


class CongviecController extends Controller
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
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }

    public function actionXacnhan($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG)
    {
        $model = Noidungcongviec::findOne(['ID_DOTBD' => $ID_DOTBD, 'ID_THIETBI' => $ID_THIETBI, 'MA_NOIDUNG' => $MA_NOIDUNG]);
        $model->TRANGTHAI = "Hoàn thành";
        $model->KETQUA = "Đạt";
        $model->save(false);
        return $this->redirect(['dotbaoduong/view', 'id' => $ID_DOTBD]);
    }

    public function actionHuyxacnhan($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG)
    {
        $model = Noidungcongviec::findOne(['ID_DOTBD' => $ID_DOTBD, 'ID_THIETBI' => $ID_THIETBI, 'MA_NOIDUNG' => $MA_NOIDUNG]);
        $model->TRANGTHAI = "Chờ xác nhận";
        $model->KETQUA = NULL;
        $model->save(false);
        return $this->redirect(['dotbaoduong/view', 'id' => $ID_DOTBD]);
    }

    public function actionXacnhantatca($id)
    {
        $models = Noidungcongviec::findAll(['ID_DOTBD' => $id]);
        $count = 0;
        foreach ($models as $noidung) {
            if ($noidung->TRANGTHAI === NULL) {
                $count++;
            } elseif ($noidung->TRANGTHAI === 'Hoàn thành') {
                continue;
            } else {
                $noidung->TRANGTHAI = "Hoàn thành";
                $noidung->KETQUA = "Đạt";
                $noidung->save(false);
            }
        }
        Yii::$app->session->setFlash('warning', "Lưu ý: Còn $count nội dung chưa hoàn thành.");
        return $this->redirect(['dotbaoduong/view', 'id' => $id]);
    }

    public function actionGiaonhiemvu()
    {
        if (Yii::$app->user->can('phancong-dbd')) {
            $searchModel = new DotbaoduongSearch();
            $dataProvider = $searchModel->searchGiaonhiemvu(Yii::$app->request->queryParams);
            $query = Nhanvien::find()
                ->where(['>', 'ID_DONVI', 2])
                ->orderBy(['ID_DAI' => SORT_ASC]);
            if (Yii::$app->user->identity->nhanvien->ID_DONVI > 3) {
                $query->andWhere(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI]);
            }
            $listNhanvien = $query->all();
            if (Yii::$app->request->get('AddSelection') && Yii::$app->request->get('ID_NHANVIEN')) {
                $selected_array = Yii::$app->request->get('AddSelection');
                $i = 0;
                foreach ($selected_array as $each) {
                    $model = Dotbaoduong::findOne(['ID_DOTBD' => $each]);
                    $model->ID_NHANVIEN = Yii::$app->request->get('ID_NHANVIEN');
                    $model->save(false);
                    Yii::$app->db->createCommand('
                        UPDATE `noidungcongviec` 
                            SET `ID_NHANVIEN` = '.Yii::$app->request->get('ID_NHANVIEN').' 
                            WHERE `noidungcongviec`.`ID_DOTBD` = '.$each
                    )->execute();
                    $i++;
                }
                Yii::$app->session->setFlash('success', "Giao thành công $i đợt bảo dưỡng.");
                return $this->redirect(['congviec/giaonhiemvu']);
            }
            return $this->render('giaonhiemvu', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'listNhanvien' => $listNhanvien
            ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }
}