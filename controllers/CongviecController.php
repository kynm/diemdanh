<?php

namespace app\controllers;

use Yii;
use app\models\Nhanvien;
use app\models\Thuchienbd;
use app\models\Kehoachbdtb;
use app\models\KehoachbdtbSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;



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
                    // 'delete-multiple' => ['post'],
                ],
            ],
        ];
    }


    public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }

    /**
     * Creates a new Cong viec ca nhan.
     * @return mixed
     */
    public function actionKehoach()
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $query = Kehoachbdtb::find()->where(['ID_NHANVIEN' => $nhanvien->ID_NHANVIEN]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('kehoach', ['dataProvider' => $dataProvider]);
    }

    /**
     * Creates a new Cong viec ca nhan.
     * @return mixed
     */
    public function actionThuchien()
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $query = Thuchienbd::find()->where(['ID_NHANVIEN' => $nhanvien->ID_NHANVIEN]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('thuchien', ['dataProvider' => $dataProvider]);
    }

    /**
     * Creates a new Cong viec ca nhan.
     * @return mixed
     */
    public function actionKetthuc()
    {
        $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();
        $query = Kehoachbdtb::find()->where(['ID_NHANVIEN' => $nhanvien->ID_NHANVIEN]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('kehoach', ['dataProvider' => $dataProvider]);
    }
}