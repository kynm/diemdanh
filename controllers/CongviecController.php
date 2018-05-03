<?php

namespace app\controllers;

use Yii;
use app\models\Nhanvien;
use app\models\Noidungcongviec;
use app\models\NoidungcongviecSearch;
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
     * Lists all Congviec models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->get('action') && Yii::$app->request->get('selection')) {
            switch (Yii::$app->request->get('action')) {
                case '1':
                    $selection = Yii::$app->request->get('selection');
                    foreach ($selection as $key) {
                        $id = get_object_vars(json_decode($key));
                        $congviec = Noidungcongviec::findOne($id);
                        $congviec->TRANGTHAI = 'Hoàn thành';
                        $congviec->save(false);
                    }
                    break;
                case '2':
                    $selection = Yii::$app->request->get('selection');
                    // print_r($selection);
                    // die;
                    foreach ($selection as $key) {
                        $id = get_object_vars(json_decode($key));
                        $congviec = Noidungcongviec::findOne($id);
                        $congviec->TRANGTHAI = 'Chưa hoàn thành';
                        $congviec->save(false);
                    }                    
                    break;
                
                default:
                    break;
            }
        }
        $searchModel = new NoidungcongviecSearch();
        $planProvider = $searchModel->searchPlan(Yii::$app->request->queryParams);
        $inprogressProvider = $searchModel->searchInProgress(Yii::$app->request->queryParams);
        $finishedProvider = $searchModel->searchFinished(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'planProvider' => $planProvider,
            'inprogressProvider' => $inprogressProvider,
            'finishedProvider' => $finishedProvider,
        ]);
    }

    /**
     * Displays a single Noidungcongviec model.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @param integer $ID_NHANVIEN
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN)
    {
        return $this->render('view', [
            'model' => Noidungcongviec::findOne(['ID_DOTBD' => $ID_DOTBD, 'ID_THIETBI' => $ID_THIETBI, 'MA_NOIDUNG' => $MA_NOIDUNG, 'ID_NHANVIEN' => $ID_NHANVIEN]),
        ]);
    }    

    /**
     * Displays a single Congviec model.
     * @param integer $ID_DOTBD
     * @param integer $ID_THIETBI
     * @param string $MA_NOIDUNG
     * @return mixed
     */

    public function actionUpdate($ID_DOTBD, $ID_THIETBI, $MA_NOIDUNG, $ID_NHANVIEN)
    {
        $model = Noidungcongviec::findOne(['ID_DOTBD' => $ID_DOTBD, 'ID_THIETBI' => $ID_THIETBI, 'MA_NOIDUNG' => $MA_NOIDUNG, 'ID_NHANVIEN' => $ID_NHANVIEN]);
        if ($model->dOTBD->TRANGTHAI == 'Đang thực hiện') {
            $nhanvien = Nhanvien::find()->where(['USER_NAME' => Yii::$app->user->identity->username])->one();

            if ($nhanvien->ID_NHANVIEN == $model->ID_NHANVIEN) {
                if ($model->load(Yii::$app->request->post())) {
                    $model->save(false);
                    return $this->redirect(['index']);
                }
                return $this->render('update', [
                    'model' => $model,
                ]);
            } else {
                throw new NotFoundHttpException;
            }
        } else {
            return $this->redirect(['view', 'ID_DOTBD' => $model->ID_DOTBD, 'ID_THIETBI' => $model->ID_THIETBI, 'MA_NOIDUNG' => $model->MA_NOIDUNG, 'ID_NHANVIEN' => $model->ID_NHANVIEN]);    
        }
    }

}