<?php

namespace app\controllers;

use Yii;
use app\models\Nhomtbi;
use app\models\Thietbi;
use app\models\Thietbitram;
use app\models\Noidungbaotrinhomtbi;
use app\models\ProfileBaoduongNoidung;
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
            // var_dump($model->arraySampleResult);
            // die();
            
            $params = Yii::$app->request->post();
            if ($model->load($params)) {
                $model->YEUCAUNHAP = '0';
                foreach ($params['SOLIEUTHUCTE'] as $key => $value) {
                    if (!$value['label']) {
                        unset($params['SOLIEUTHUCTE'][$key]);
                    }
                }
                $congviec = [
                    'KETQUABAODUONG' => [
                        'type' => 'select',
                        'value' => explode(',', $params['Noidungbaotrinhomtbi']['type']),
                    ],
                    'GHICHU' => [
                        'type' => 'input',
                        'value' => '',
                    ],
                    'KIENNGHI' => [
                        'type' => 'input',
                        'value' => '',
                    ],
                    'SOLIEUTHUCTE' => [
                        'type' => 'multiple_field',
                        'fields' => $params['SOLIEUTHUCTE']
                    ],
                ];
                $model->SAMPLE_RESULT = json_encode($congviec);
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

    public function actionList($id)
    {
        $all = Noidungbaotrinhomtbi::find()->all();
        $congviec = [
            'KETQUABAODUONG' => [
                'type' => 'select',
                'value' => ['dat', 'khong_dat'],
            ],
            'GHICHU' => [
                'type' => 'input',
                'value' => '',
            ],
            'KIENNGHI' => [
                'type' => 'input',
                'value' => '',
            ],
            'SOLIEUTHUCTE' => [
                'type' => 'multiple_field',
                'fields' => []
            ],
        ];
        foreach ($all as $key => $value) {
            $value->SAMPLE_RESULT = json_encode($congviec);
            $value->save();
        }
        $json = '"{\"KETQUABAODUONG\":{\"type\":\"select\",\"value\":[\"dat\",\"khong_dat\"]},\"GHICHU\":{\"type\":\"input\",\"value\":\"\"},\"KIENNGHI\":{\"type\":\"input\",\"value\":\"\"},\"SOLIEUTHUCTE\":{\"type\":\"multiple_field\",\"fields\":[]}}"';
        $json = json_decode($json, true);
echo "<pre>";
        var_dump($json);
        die();
        $query = Yii::$app->db->createCommand("
            SELECT `noidungbaotrinhomtbi`.`ID_NHOM`, `nhomtbi`.`TEN_NHOM`, `noidungbaotrinhomtbi`.`MA_NOIDUNG`, `NOIDUNG`, `pn`.`ID_PROFILE`  
            FROM `noidungbaotrinhomtbi` 
            JOIN `nhomtbi` ON `noidungbaotrinhomtbi`.`ID_NHOM` = `nhomtbi`.`ID_NHOM`
            LEFT JOIN (
                SELECT * FROM `profile_baoduong_noidung` 
                WHERE `ID_PROFILE` = :id
            ) AS `pn` 
            ON `noidungbaotrinhomtbi`.MA_NOIDUNG = `pn`.MA_NOIDUNG",
            [':id' => $id]);
        $array = $query->queryAll();
        
        foreach ($array as $element) {
            $result[$element['ID_NHOM']]['TEN_NHOM'] = $element['TEN_NHOM'];
            $result[$element['ID_NHOM']]['DS_ND'][] = $element;
        }

        // foreach ($array as $element) {
        //     foreach ($result[$element['ID_NHOM']]['DS_ND']  as $item) {
        //         if ($item['ID_PROFILE'] != null) {
        //             $check = true;
        //         }
        //     }
        //     $result[$element['ID_NHOM']]['TEN_NHOM'] = $element['TEN_NHOM'];
        //     $result[$element['ID_NHOM']]['DS_ND'][] = $element;
        // }
        // foreach ($result as $key => $element) {
        //     echo in_array($id, $element['DS_ND']) ? "True<hr>" : "False<hr>";
        // }
        // die();
        return json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Import new Noidungbaotrinhomtbi models.
     * If importion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionImport()
    {
        $fileName = "uploads/noidunginout.xlsx";
        $data = \moonland\phpexcel\Excel::import($fileName);
        foreach ($data as $element) {
            $model = new Noidungbaotrinhomtbi;
            $model->ID_NHOM = 14;
            $model->MA_NOIDUNG = $element["Code"];
            $model->NOIDUNG = $element["Noidung"];
            $model->CHUKY = 12;
            $model->QLTRAM = 0;
            // $model->save(false);
        }
        return $this->redirect(['index']);
    }

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
