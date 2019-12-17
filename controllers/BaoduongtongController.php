<?php

namespace app\controllers;

use Yii;
use app\models\Baoduongtong;
use app\models\BaoduongtongSearch;
use app\models\Noidungcongviec;
use app\models\Thietbitram;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BaoduongtongController implements the CRUD actions for Baoduongtong model.
 */
class BaoduongtongController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Baoduongtong models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BaoduongtongSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTest()
    {
    	$tram = range(1, 10);
    	$str = implode(',', $tram);
    	$sql = "SELECT DISTINCT ID_TRAM FROM `thietbitram` LEFT JOIN `thietbi` ON `thietbitram`.`ID_LOAITB` = `thietbi`.`ID_THIETBI` WHERE (`thietbi`.`ID_NHOM`=14) AND (`ID_TRAM` IN ($str))";
    	$a = Yii::$app->db->createCommand($sql)->queryAll();
    	var_dump($a); exit;
    }

    /**
     * Displays a single Baoduongtong model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Baoduongtong model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Baoduongtong();

        if ($model->load(Yii::$app->request->post())) {
            $model->TRANGTHAI = 'dangthuchien';
            $model->TYPE = 0;
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Baoduongtong model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->TRANGTHAI = 'dangthuchien';
            $model->TYPE = 0;
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->save();
            return $this->redirect(['view', 'id' => $model->ID_BDT]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionExport($id)
    {
        $sql = "
            SELECT * FROM  
                (SELECT dotbaoduong.* FROM tramvt LEFT JOIN dotbaoduong ON tramvt.ID_TRAM = dotbaoduong.ID_TRAM WHERE dotbaoduong.ID_BDT = 14 LIMIT 2 ) as tmp 
                lEFT JOIN thietbitram  ON thietbitram.ID_TRAM = tmp.ID_TRAM 
                WHERE thietbitram.ID_LOAITB IN (SELECT thietbi.ID_THIETBI FROM thietbi WHERE ID_NHOM = 14)
                LEFT JOIN noidungcongviec ON tmp.ID_DOTBD = noidungcongviec.ID_DOTBD
            ;
        ";


        //$sql = "SELECT * FROM tramvt LEFT JOIN dotbaoduong ON tramvt.ID_TRAM = dotbaoduong.ID_TRAM WHERE dotbaoduong.ID_BDT = $id LIMIT 1 "; 
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        var_dump($result);
        exit;
    }

    public function actionExport2($id)
    {
        $start = time();
        $list_thietbitram = Thietbitram::find()
            // ->select('thietbitram.*, dotbaoduong.*')
            ->joinWith('iDDOTBDs')
            ->where(['dotbaoduong.ID_BDT' => $id])
            ->all();
        // var_dump($list_thietbitram[0]->iDDOTBDs[0]->noidungcongviecs); die;
        $array[0][] = 'STT';
        $array[0][] = 'Mã trạm';
        $array[0][] = 'Tên trạm';
        $array[0][] = 'Tên trạm (HT)';
        $array[0][] = 'Băng tần';
        
        $list_noidung = Noidungcongviec::find()->where(['ID_DOTBD' => $list_thietbitram[0]->iDDOTBDs[0]->ID_DOTBD])->groupBy('MA_NOIDUNG')->all();
        foreach ($list_noidung as $noidung) {
            $array[0][] = $noidung->mANOIDUNG->NOIDUNG;
        }
        $array[0][] = 'Tồn tại';
        $array[0][] = 'Kiến nghị';
        $array[0][] = 'Người bảo dưỡng';
        $array[0][] = 'Đơn vị bảo dưỡng';
        $array[0][] = 'Ngày bảo dưỡng';
        $array[0][] = 'Người cập nhật';
        $array[0][] = 'Thời gian cập nhật';
        $array[0][] = 'Mã CSHT';
        $array[0][] = 'Tên CSHT';
        $array[0][] = 'Phường/Xã';
        $array[0][] = 'Quận/Huyện';
        $array[0][] = 'Longtitude';
        $array[0][] = 'Latitude';
        $array[0][] = 'Ngày hoạt động';
        $array[0][] = 'Loại trạm';
        $array[0][] = 'Người ĐK';
        $array[0][] = 'Thời gian gửi ĐK';
        $array[0][] = 'Tháng dự kiến DB';
        $array[0][] = 'Trạng thái';
        echo '<table class="table table-bordered table-hover">
        <tbody>';
        foreach ($array as $row) {
            echo '<tr>';
            foreach ($row as $column) {
                echo "<td>$column</td>";
            }
            echo '</tr>';
        }
        echo '</tbody>
        </table>';
        exit;
        // echo sizeof($list_thietbitram[0]->iDDOTBDs[0]->noidungcongviecs) . " records with " . (int) (time() - $start);
    }

    /**
     * Deletes an existing Baoduongtong model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Baoduongtong model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Baoduongtong the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Baoduongtong::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
