<?php

namespace app\controllers;

use Yii;
use app\models\Noidungcongviec;
use app\models\NoidungcongviecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoidungcongviecController implements the CRUD actions for Noidungcongviec model.
 */
class NoidungcongviecController extends Controller
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
     * Finds the Noidungcongviec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @param integer $ID_NHANVIEN
     * @return Noidungcongviec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN)
    {
        if (($model = Noidungcongviec::findOne(['ID_DOTBD' => $ID_DOTBD, 'ID_THIETBI' => $ID_THIETBI, 'MA_NOIDUNG' => $MA_NOIDUNG, 'ID_NHANVIEN' => $ID_NHANVIEN])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
