<?php

namespace app\controllers;

use Yii;
use app\models\ActivitiesLog;
use app\models\Nhanvien;
use app\models\Daivt;
use app\models\Dongiamayno;
use app\models\NhatKySuDungMayNo;
use app\models\NhatKySuDungMayNoSearch;
use app\models\QuanlydienSearch;
use app\models\Tramvt;
use app\models\Donvi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use moonland\phpexcel\Excel;

/**
 * TramvtController implements the CRUD actions for Tramvt model.
 */
class BaocaotonghopController extends Controller
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

    public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }
    

    public function actionBaocaotonghoptheotram()
    {
        if (Yii::$app->user->can('bctonghop-mayno')) {
            $params = Yii::$app->request->queryParams;
            $iddv = ArrayHelper::map(Donvi::find()->where(['<>', 'MA_DONVIKT', 0])->all(), 'ID_DONVI', 'ID_DONVI');
            if (Yii::$app->user->can('dmdv-diennhienlieu')) {
                $iddv = [Yii::$app->user->identity->nhanvien->ID_DONVI];
            }

            $dsdonvi = ArrayHelper::map(Donvi::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DONVI', 'TEN_DONVI');
            if (!$params) {
                $params = array_merge(Yii::$app->request->queryParams, [
                    'ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI
                ]);
            } else {
                $iddv = $params['ID_DONVI'] ? $params['ID_DONVI'] : $iddv;
            }

            $params['is_excel'] = $params['is_excel'] ?? null;
            $dsdai = ArrayHelper::map(Daivt::find()->where(['in', 'ID_DONVI', $iddv])->all(), 'ID_DAI', 'ID_DAI');
            // $dstram = ArrayHelper::map(Tramvt::find()->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->where(['in', 'ID_TRAM', $iddv])->all(), 'ID_TRAM', 'TEN_TRAM');
            $dstram = Tramvt::find()->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->andWhere(['is', 'IS_DELETE', new \yii\db\Expression('null')])->andWhere(['in', 'ID_DAI', $dsdai])->all();
            $data = [];
            foreach ($dstram as $key => $value) {
                $data[$value->ID_TRAM] = [
                    1 => 0,
                    2 => 0,
                    3 => 0,
                    4 => 0,
                    5 => 0,
                    6 => 0,
                    7 => 0,
                    8 => 0,
                    9 => 0,
                    10 => 0,
                    11 => 0,
                    12 => 0,
                ];
                $data[$value->ID_TRAM]['TEN_TRAM'] = $value->TEN_TRAM;
                $data[$value->ID_TRAM]['DIADIEM'] = $value->iDDAI->TEN_DAIVT;
                $searchModel = new NhatKySuDungMayNoSearch();
                foreach ($searchModel->tonghoptheotram($value->ID_TRAM, date('Y'), 'TONGTIEN') as $v) {
                    $data[$value->ID_TRAM][$v['THANG']] = $v['TONG'];
                }
                $searchModel1 = new QuanlydienSearch();
                foreach ($searchModel1->tonghoptheotram($value->MA_DIENLUC, date('Y'), 'TONGTIEN') as $v) {
                    $data[$value->ID_TRAM][$v['THANG']] += $v['TONG_TT'];
                }
            }
            if ($params['is_excel']) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
                $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
                $spreadsheet->getActiveSheet()->fromArray(
                    [
                        'STT',
                        'Tên đơn vị',
                        'Địa chỉ',
                        'Tháng 1',
                        'Tháng 2',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 3',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 4',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 5',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 6',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 7',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 8',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 9',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 10',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 11',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                        'Tháng 12',
                        'Tăng/Giảm',
                        'Lượng tăng/giảm',
                        'Tỉ lệ tăng/giảm %',
                    ],
                    '',
                    'A1'         
                );
                $key = 0;
                $x = 2;
                foreach ($data as $value) {
                    $chenh21 = $value[2] - $value[1];
                    $chenh32 = $value[3] - $value[2];
                    $chenh43 = $value[4] - $value[3];
                    $chenh54 = $value[5] - $value[4];
                    $chenh65 = $value[6] - $value[5];
                    $chenh76 = $value[7] - $value[6];
                    $chenh87 = $value[8] - $value[7];
                    $chenh98 = $value[9] - $value[8];
                    $chenh109 = $value[10] - $value[9];
                    $chenh1110 = $value[11] - $value[10];
                    $chenh1211 = $value[12] - $value[11];
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", ($key + 1))
                        ->setCellValue("B$x", $value['TEN_TRAM'])
                        ->setCellValue("C$x", $value['DIADIEM'])
                        ->setCellValue("D$x", formatnumber($value[1]))
                        ->setCellValue("E$x", formatnumber($value[2]))
                        ->setCellValue("F$x", $chenh21 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("G$x", $chenh21)
                        ->setCellValue("H$x", $value[1] != 0 ? formatnumber($chenh21/$value[1] * 100, 2): 0)
                        ->setCellValue("I$x", formatnumber($value[3]))
                        ->setCellValue("J$x", $chenh32 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("K$x", $chenh32)
                        ->setCellValue("L$x", $value[2] != 0 ? formatnumber($chenh32/$value[2] * 100, 2): 0)
                        ->setCellValue("M$x", formatnumber($value[4]))
                        ->setCellValue("N$x", $chenh43 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("O$x", $chenh43)
                        ->setCellValue("P$x", $value[3] != 0 ? formatnumber($chenh43/$value[3] * 100, 2): 0)
                        ->setCellValue("Q$x", formatnumber($value[5]))
                        ->setCellValue("R$x", $chenh54 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("S$x", $chenh54)
                        ->setCellValue("T$x", $value[4] != 0 ? formatnumber($chenh54/$value[4] * 100, 2): 0)
                        ->setCellValue("U$x", formatnumber($value[6]))
                        ->setCellValue("V$x", $chenh65 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("W$x", $chenh65)
                        ->setCellValue("X$x", $value[5] != 0 ? formatnumber($chenh65/$value[5] * 100, 2): 0)
                        ->setCellValue("Y$x", formatnumber($value[7]))
                        ->setCellValue("Z$x", $chenh76 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AA$x", $chenh76)
                        ->setCellValue("AB$x", $value[6] != 0 ? formatnumber($chenh76/$value[6] * 100, 2): 0)
                        ->setCellValue("AC$x", formatnumber($value[8]))
                        ->setCellValue("AD$x", $chenh87 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AE$x", $chenh87)
                        ->setCellValue("AF$x", $value[7] != 0 ? formatnumber($chenh87/$value[7] * 100, 2): 0)
                        ->setCellValue("AG$x", formatnumber($value[9]))
                        ->setCellValue("AH$x", $chenh98 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AI$x", $chenh98)
                        ->setCellValue("AJ$x", $value[8] != 0 ? formatnumber($chenh98/$value[8] * 100, 2): 0)
                        ->setCellValue("AK$x", formatnumber($value[10]))
                        ->setCellValue("AL$x", $chenh109 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AM$x", $chenh109)
                        ->setCellValue("AN$x", $value[9] != 0 ? formatnumber($chenh109/$value[9] * 100, 2): 0)
                        ->setCellValue("AO$x", formatnumber($value[11]))
                        ->setCellValue("AP$x", $chenh1110 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AQ$x", $chenh1110)
                        ->setCellValue("AR$x", $value[10] != 0 ? formatnumber($chenh1110/$value[10] * 100, 2): 0)
                        ->setCellValue("AS$x", formatnumber($value[12]))
                        ->setCellValue("AT$x", $chenh1211 > 0 ? 'Tăng' : 'Giảm')
                        ->setCellValue("AU$x", $chenh1211)
                        ->setCellValue("AV$x", $value[11] != 0 ? formatnumber($chenh1211/$value[11] * 100, 2): 0);
                    $key ++;
                    $x ++;
                }
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $file_name = "Báo cáo tổng hợp điện nhiên liệu" .date('Ymd_His');

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save("php://output");
        exit;
            }

            return $this->render('tonghoptheotram', [
                    'data' => $data,
                    'dsdonvi' => $dsdonvi,
                    'params' => $params,
                ]);
        } else {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này');
        }
    }
}
