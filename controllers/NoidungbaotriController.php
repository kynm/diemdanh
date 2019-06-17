<?php

namespace app\controllers;

use Yii;
use app\models\Nhomtbi;
use app\models\Thietbi;
use app\models\Thietbitram;
use app\models\Noidungbaotrinhomtbi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
/**
 * NoidungbaotriController implements the CRUD actions for Noidungbaotri model.
 */
class NoidungbaotriController extends Controller
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
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }

    public function actionGroupView($id)
    {
        return $this->render('group-view', [
            'model' => Noidungbaotrinhomtbi::findOne($id),
        ]);
    }

    public function actionCreateForGroup()
    {
        $model = new Noidungbaotrinhomtbi();
        
        if ($model->load(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
            switch ($params['Noidungbaotrinhomtbi']['type']) {
                case '0':
                    $model->YEUCAUNHAP = '0';
                    break;
                case '1':
                    if ($model->YEUCAUNHAP == '')
                        $model->YEUCAUNHAP =  'Nhập kết quả';
                    break;
                
                default:
                    $model->YEUCAUNHAP = '0';
                    break;
            }
            $model->save();
            return $this->redirect(['nhomtbi/view', 'id' => $model->ID_NHOM]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing Noidungbaotrinhomtbi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionGroupUpdate($id)
    {
        if (Yii::$app->user->can('edit-noidungbaotri')) {
            # code...
            $model = Noidungbaotrinhomtbi::findOne($id);
            
            $params = Yii::$app->request->post();
            if ($model->load($params)) {
                
                switch ($params['Noidungbaotrinhomtbi']['type']) {
                    case '0':
                        $model->YEUCAUNHAP = '0';
                        break;
                    case '1':
                        if ($model->YEUCAUNHAP == '0')
                            $model->YEUCAUNHAP =  'Nhập kết quả';
                        break;
                    
                    default:
                        $model->YEUCAUNHAP = '0';
                        break;
                }
                $model->save();
                return $this->redirect(['group-view', 'id' => $model->MA_NOIDUNG]);
            } else {
                if ($model->YEUCAUNHAP == '0') {
                    $model->type = 0;
                } else {
                    $model->type = 1;
                }
                return $this->render('group-update', [
                    'model' => $model,
                ]);
            }
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');      
        }
        
    }

    /**
     * Deletes an existing Noidungbaotri model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionGroupDelete($id)
    {
        if (Yii::$app->user->can('delete-noidungbaotri')) {
            # code...
            Noidungbaotrinhomtbi::findOne($id)->delete();

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            # code...
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
            
        }
    }

    // public function actionListstbt($id)
    // {
    //     $tbi = Thietbitram::find()->where(['ID_THIETBI' => $id])->one();
    //     $noidung = Noidungbaotrinhomtbi::find()
    //     ->where(['ID_THIETBI'=>$tbi->iDLOAITB->ID_NHOM])
    //     ->all();

    //     if(isset($noidung) && count($noidung)>0) {
    //         foreach($noidung as $each) {
    //             echo "<option value='".$each->MA_NOIDUNG."'>".$each->NOIDUNG."</option>";
    //         }
    //     }else {
    //         echo "-";
    //     }
    // }

    /**
     * Finds the Noidungbaotri model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Noidungbaotri the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($MA_NOIDUNG, $ID_THIETBI)
    {
        if (($model = Noidungbaotri::findOne(['MA_NOIDUNG' =>$MA_NOIDUNG, 'ID_THIETBI' => $ID_THIETBI])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
