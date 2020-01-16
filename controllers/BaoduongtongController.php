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
use yii\helpers\ArrayHelper;

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
        
        $list_thietbitram = Yii::$app->db->createCommand('SELECT noidungcongviec.*, dotbaoduong.*, nhanvien.TEN_NHANVIEN, tramvt.*, donvi.TEN_DONVI, thietbitram.* FROM `noidungcongviec` JOIN dotbaoduong ON dotbaoduong.ID_DOTBD = noidungcongviec.ID_DOTBD JOIN tramvt ON dotbaoduong.ID_TRAM = tramvt.ID_TRAM JOIN nhanvien ON dotbaoduong.ID_NHANVIEN = nhanvien.ID_NHANVIEN JOIN donvi ON nhanvien.ID_DONVI = donvi.ID_DONVI JOIN thietbitram ON noidungcongviec.ID_THIETBI = thietbitram.ID_THIETBI WHERE dotbaoduong.ID_BDT = '.$id.' GROUP BY thietbitram.ID_THIETBI')->queryAll();

        $list_noidung = Yii::$app->db->createCommand('SELECT noidungbaotrinhomtbi.MA_NOIDUNG, noidungbaotrinhomtbi.NOIDUNG FROM (SELECT MA_NOIDUNG FROM `noidungcongviec` JOIN dotbaoduong ON dotbaoduong.ID_DOTBD = noidungcongviec.ID_DOTBD WHERE dotbaoduong.ID_BDT = ' . $id . ' GROUP BY MA_NOIDUNG) AS t JOIN noidungbaotrinhomtbi ON t.MA_NOIDUNG = noidungbaotrinhomtbi.MA_NOIDUNG')->queryAll();
        
        $list_congviec = Yii::$app->db->createCommand('SELECT noidungcongviec.*, dotbaoduong.*, nhanvien.TEN_NHANVIEN, tramvt.*, donvi.TEN_DONVI FROM `noidungcongviec` JOIN dotbaoduong ON dotbaoduong.ID_DOTBD = noidungcongviec.ID_DOTBD JOIN tramvt ON dotbaoduong.ID_TRAM = tramvt.ID_TRAM JOIN nhanvien ON dotbaoduong.ID_NHANVIEN = nhanvien.ID_NHANVIEN JOIN donvi ON nhanvien.ID_DONVI = donvi.ID_DONVI WHERE dotbaoduong.ID_BDT = ' . $id)->queryAll();
        
        // var_dump($list_congviec); die;
        $array[0][] = 'STT';
        $array[0][] = 'Mã trạm';
        $array[0][] = 'Tên trạm';
        $array[0][] = 'Tên trạm (HT)';
        $array[0][] = 'Băng tần';
        
        foreach ($list_noidung as $noidung) {
            $array[0][] = $noidung["NOIDUNG"];
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
        $array[0][] = 'Tháng dự kiến BD';
        $array[0][] = 'Trạng thái';

        $row = 1;
        foreach ($list_thietbitram as $thietbitram) { 
            // foreach ($thietbitram as $key => $value) {
            //     echo "<br>$key :";
            //     var_dump($value);
            // }
            // exit;
            $array[$row][] = $row;
            $array[$row][] = $thietbitram["TEN_MA"];
            $array[$row][] = $thietbitram["TEN_TRAM2"];
            $array[$row][] = $thietbitram["TEN_MA"];
            $array[$row][] = 'GMS900/U900...';
            
            $tontai = ''; $kiennghi = '';
            foreach ($list_noidung as $noidung) {
                // var_dump($thietbitram);
                $result = Yii::$app->arrayhelper->search($list_congviec, ['ID_THIETBI' => $thietbitram["ID_THIETBI"], 'MA_NOIDUNG' => $noidung["MA_NOIDUNG"]]);
                // die(var_dump($result[0]));
                $result = $result[0];
                is_null($result["SOLIEUTHUCTE"]) ? $array[$row][] = $result["KETQUA"] : $array[$row][] = $result["SOLIEUTHUCTE"];
                
                if(!is_null($result["GHICHU"]))  {
                    $tontai .= $result["GHICHU"] . ". ";
                }


                if(is_null($result["KIENNGHI"]) || $result["KIENNGHI"] == "" )  {
                    continue;
                } else {
                    $kiennghi .= $result["KIENNGHI"] . ". ";
                }
            }
            
            $array[$row][] = $tontai;
            $array[$row][] = $kiennghi;
            
            $array[$row][] = $thietbitram["TEN_NHANVIEN"];
            $array[$row][] = $thietbitram["TEN_DONVI"];
            $array[$row][] = $thietbitram["NGAY_KT"];
            $array[$row][] = $thietbitram["TEN_NHANVIEN"];
            $array[$row][] = $thietbitram["NGAY_KT"];
            $array[$row][] = $thietbitram["MA_TRAM"];
            $array[$row][] = $thietbitram["TEN_TRAM"];
            $array[$row][] = $thietbitram["XAPHUONG"]; //xa
            $array[$row][] = $thietbitram["QUANHUYEN"]; //huyen
            $array[$row][] = $thietbitram["KINH_DO"]; //longtitude
            $array[$row][] = $thietbitram["VI_DO"]; //latitude
            $array[$row][] = $thietbitram["NGAYHD"]; //NGAYHD
            $array[$row][] = $thietbitram["KIEUTRAM"]; 
            $array[$row][] = $thietbitram["CREATED_BY"]; 
            $array[$row][] = date('d/m/Y H:i', $thietbitram["CREATED_AT"]); 
            $array[$row][] = $thietbitram["NGAY_KT_DUKIEN"]; 
            $array[$row][] = $thietbitram["TRANGTHAI"]; 



            //////////
            $row++;
        }
        
        // write to excel

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray(
            $array,
            '',
            'A1'         
        );

        // foreach ($array as $row_num => $row) {
        //     foreach ($row as $col_num => $cell_value) {
        //         $sheet->getCellByColumnAndRow($col_num, $row_num)->setValue($cell_value);
        //     }
        // }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $file_name = "Export_".date('Ymd_His');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save("php://output");
        
        ////Echo to test
        // echo '<table class="table table-bordered table-hover">
        // <tbody>';
        // foreach ($array as $row) {
        //     echo '<tr>';
        //     foreach ($row as $column) {
        //         echo "<td>$column</td>";
        //     }
        //     echo '</tr>';
        // }
        // echo '</tbody>
        // </table>';
        
        // echo sizeof($list_thietbitram[0]->iDDOTBDs[0]->noidungcongviecs) . " records with " . (int) (time() - $start);
        exit;
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
