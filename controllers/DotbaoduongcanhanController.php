<?php

namespace app\controllers;

use Yii;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;

use app\models\Tramvt;
use app\models\Dotbaoduong;
use app\models\Images;
use app\models\Noidungcongviec;
use app\models\AuthorizationCodes;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class DotbaoduongcanhanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $this->layout = 'baoduongLayout';
        return $behaviors + [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'danhsach' => ['GET'],
                    // 'danhsachcanhan' => ['GET'],
                    'index' => ['GET'],
                    'thuchien' => ['GET'],
                    'hoanthanh' => ['GET'],
                    'upload' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public $imageFile;

    public function actionDanhsach($trangthai = '', $daivt='', $tramvt='')
    {
        $trangthai = $trangthai ? $trangthai : 'kehoach';

        $query = Dotbaoduong::find()->select('dotbaoduong.ID_TRAM')->where(['dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'TRANGTHAI' => $trangthai])->groupBy('dotbaoduong.ID_TRAM');

        $query->joinWith('tRAMVT.iDDAI');

        if ($daivt!=='') {
            $query->andWhere(['tramvt.ID_DAI' => $daivt]);
        }

        if ($tramvt!=='') {
            if ($tramvt !== 'all') {
                $query->andWhere(['dotbaoduong.ID_TRAM' => $tramvt]);
            }
        }
        $ids = $query->orderBy(['tramvt.TEN_TRAM' => SORT_ASC])->all();
        $data = [];
        foreach ($ids as $id) {
            $tram = Tramvt::findOne($id["ID_TRAM"]);
            $list['ThongTinTram'] = $tram;
            $list['DS_DotBaoDuong'] = Dotbaoduong::findAll(['ID_TRAM' => $id["ID_TRAM"], 'TRANGTHAI' => $trangthai, 'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
            $data[] = $list;
        }
        // echo "<pre>";
        // var_dump($data);
        return $this->render('danhsach', [
            'data' => $data,
            'trangthai' => $trangthai,
        ]);
    }

    public function actionDanhsachcanhan($trangthai, $daivt='', $tramvt='')
    {
        $query = Dotbaoduong::find()->select('dotbaoduong.ID_TRAM')->joinWith('noidungcongviecs')->where(['noidungcongviec.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'dotbaoduong.TRANGTHAI' => $trangthai])->groupBy('dotbaoduong.ID_TRAM');
    
        $query->joinWith('tRAMVT.iDDAI');
        

        if ($daivt!=='') {
            $query->andWhere(['tramvt.ID_DAI' => $daivt]);
        }

        if ($tramvt!=='') {
            if ($tramvt !== 'all') {
                $query->andWhere(['dotbaoduong.ID_TRAM' => $tramvt]);
            }
        }

        $ids = $query->orderBy(['TEN_TRAM' => SORT_ASC])->all();

        foreach ($ids as $id) {
            $tram = Tramvt::findOne($id["ID_TRAM"]);
            $list['ThongTinTram'] = $tram;
            $list['DS_DotBaoDuong'] = Dotbaoduong::find()->joinWith('noidungcongviecs')->where(['dotbaoduong.ID_TRAM' => $id["ID_TRAM"], 'noidungcongviec.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'dotbaoduong.TRANGTHAI' => $trangthai])->groupBy('dotbaoduong.ID_DOTBD')->all();
            $data[] = $list;
        }
        
        return $this->render('danhsachcanhan', [
            'data' => $data,
            // 'planProvider' => $planProvider,
            // 'inprogressProvider' => $inprogressProvider,
            // 'finishedProvider' => $finishedProvider
        ]);
    }

    public function actionLichsu($daivt='', $tramvt='', $start='', $end='')
    {
        $query = Dotbaoduong::find()
            ->select('dotbaoduong.ID_TRAM')
            ->joinWith('noidungcongviecs')
            ->where([
                'noidungcongviec.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN
            ])
            ->andWhere(['or', ['dotbaoduong.TRANGTHAI' => 'ketthuc'], ['dotbaoduong.TRANGTHAI' => 'chuahoanthanh'], ['dotbaoduong.TRANGTHAI' => 'chuathuchien']])
            ->orWhere([
                'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN,
                'dotbaoduong.TRANGTHAI' => 'ketthuc'
            ])
            ->groupBy('dotbaoduong.ID_TRAM');
    
        $query->joinWith('tRAMVT.iDDAI');
        

        if ($daivt!=='') {
            $query->andWhere(['tramvt.ID_DAI' => $daivt]);
        }

        if ($tramvt!=='') {
            if ($tramvt !== 'all') {
                $query->andWhere(['dotbaoduong.ID_TRAM' => $tramvt]);
            }
        }
        if (($start!=='') & ($end!=='')) {
            $start = date('Y-m-d', strtotime($start));
            $end = date('Y-m-d', strtotime($end));
            $query->andWhere(['>=', 'NGAY_KT', $start])
                ->andWhere(['<=', 'NGAY_KT', $end]);
        }

        $ids = $query->orderBy(['TEN_TRAM' => SORT_ASC])->all();

        if (empty($ids)) {
            Yii::$app->api->sendFailedResponse("Không có đợt bảo dưỡng!");
        }
        foreach ($ids as $id) {
            $tram = Tramvt::findOne($id["ID_TRAM"]);
            $list['ThongTinTram'] = $tram;
            $query2 = Dotbaoduong::find()->joinWith('noidungcongviecs')
                ->where([
                    'dotbaoduong.ID_TRAM' => $id["ID_TRAM"],
                    'noidungcongviec.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN,
                    'dotbaoduong.TRANGTHAI' => 'ketthuc'
                ])
                ->orWhere([
                    'dotbaoduong.ID_TRAM' => $id["ID_TRAM"],
                    'dotbaoduong.ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN,
                    'dotbaoduong.TRANGTHAI' => 'ketthuc'
                ])
                ->groupBy('dotbaoduong.ID_DOTBD');
            if (($start!=='') & ($end!=='')) {
                $start = date('Y-m-d', strtotime($start));
                $end = date('Y-m-d', strtotime($end));
                $query2->andWhere(['>=', 'NGAY_KT', $start])
                    ->andWhere(['<=', 'NGAY_KT', $end]);
            }

            $listDBD = $query2->all();
            $array = [];
            foreach ($listDBD as $each) {
                $dotbd = $each->attributes;
                $dotbd['TEN_NHANVIEN'] = $each->nHANVIEN->TEN_NHANVIEN;
                $array[] = $dotbd;
            }
            $list['DS_DotBaoDuong'] = $array;
            $data[] = $list;
        }
        
        Yii::$app->api->sendSuccessResponse($data);
    }

    public function actionXem($id, $canhan = 0)
    {
        $dotbd = Dotbaoduong::findOne(['ID_DOTBD' => $id]);
        $data["THONGTIN_DBD"] = $dotbd->attributes;
        unset($data["THONGTIN_DBD"]["ID_TRAM"]);
        $data["THONGTIN_DBD"]["TRAMVT"] = $dotbd->tRAMVT;
        $query = Noidungcongviec::find()->where(['ID_DOTBD' => $dotbd->ID_DOTBD]);
        if ($canhan == 1) {
            $query->andWhere(['ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $listCongViec = $query->all();
        
        $array = array();
        foreach ($listCongViec as $each) {
            $array = $each->attributes;
            $array['NOIDUNG'] = $each->mANOIDUNG->attributes;
            $array['NHANVIEN'] = $each->nHANVIEN->TEN_NHANVIEN;
            unset($array['MA_NOIDUNG']);
            unset($array['NOIDUNG']['ID_THIETBI']);
            $congviec[$each->tHIETBI->iDLOAITB->TEN_THIETBI][] = $array;
        }
        $data["DS_CONGVIEC"] = $congviec;
        
        return $this->render('xemdotbaoduong', [
            'data' => $data,
        ]);
    }

    public function actionXemlichsu($id)
    {
        $dotbd = Dotbaoduong::findOne(['ID_DOTBD' => $id]);
        $data["THONGTIN_DBD"] = $dotbd->attributes;
        unset($data["THONGTIN_DBD"]["ID_TRAM"]);
        $data["THONGTIN_DBD"]["TRAMVT"] = $dotbd->tRAMVT;
        $query = Noidungcongviec::find()->where(['ID_DOTBD' => $dotbd->ID_DOTBD]);
        if ($dotbd->ID_NHANVIEN !== Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
            $query->andWhere(['ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN]);
        }
        $listCongViec = $query->all();
        
        $array = array();
        foreach ($listCongViec as $each) {
            $array = $each->attributes;
            $array['NOIDUNG'] = $each->mANOIDUNG->attributes;
            $array['NHANVIEN'] = $each->nHANVIEN->TEN_NHANVIEN;
            unset($array['MA_NOIDUNG']);
            unset($array['NOIDUNG']['ID_THIETBI']);
            $congviec[$each->tHIETBI->iDLOAITB->TEN_THIETBI][] = $array;
        }
        $data["DS_CONGVIEC"] = $congviec;
        
        Yii::$app->api->sendSuccessResponse($data);
    }

    public function actionThuchien($id='')
    {
        $dotbd = Dotbaoduong::findOne(['ID_DOTBD' => $id]);
        if ($dotbd->TRANGTHAI == "kehoach") {
            if ($dotbd->ID_NHANVIEN !== Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
                return $this->redirect(['xem', 'id' => $id]);
            } else {
                $dotbd->NGAY_BD = date('Y-m-d');
                $dotbd->TRANGTHAI = "dangthuchien";
                $dotbd->save(false);
                // $danhsachcongviec = Noidungcongviec::find()->where(['ID_DOTBD' => $id])->all();
                // foreach ($danhsachcongviec as $congviec) {
                //     $congviec->KETQUA = 'Chưa đạt';
                //     $congviec->save(false);
                // }
                return $this->redirect(['xem', 'id' => $id]);
            }
        } else {
            return $this->redirect(['xem', 'id' => $id]);
        }
    }
        
    public function actionHoanthanh($id)
    {
        $dotbd = Dotbaoduong::findOne($id);
        $hoanthanh = Noidungcongviec::find()->where(['ID_DOTBD' => $id])
            ->andWhere(['TRANGTHAI' => 'Hoàn thành'])
            ->count();
        $all = Noidungcongviec::find()->where(['ID_DOTBD' => $id])
            ->count();
        // $check_image = Images::find()->where(['MA_DOTBD' => $dotbd->MA_DOTBD, 'type' => 0])->exists();
        $count = Images::find()->where(['MA_DOTBD' => $dotbd->MA_DOTBD, 'type' => 0])->count();
        if ($hoanthanh !== $all) {
            Yii::$app->api->sendFailedResponse("Còn nội dung công việc chưa hoàn thành!");
        } elseif ($count < 3) {
            Yii::$app->api->sendFailedResponse("Nhân viên bảo dưỡng chưa upload đủ hình ảnh");
        } else {
            $dotbd->NGAY_KT = date('Y-m-d');
            $dotbd->TRANGTHAI = 'ketthuc';
            $dotbd->save(false);
            if ($dotbd->baoduongtong->TYPE == 2) {
                $tramvt = Tramvt::findOne($dotbd->ID_TRAM);
                $tramvt->NGAY_KTNT = $dotbd->NGAY_KT;
                $tramvt->save(false);
            }
            Yii::$app->api->sendSuccessResponse("Success");
        }
    }
        
            

    public function actionGetImages($id, $type = '')
    {
        $dotbd = Dotbaoduong::findOne($id);
        $query = Images::find()->where(['MA_DOTBD' => $dotbd->MA_DOTBD]);
        if ($type === '0') {
            $query->andWhere(['ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'type' => 0]);
        } elseif ($type === '1') {
            $query->andWhere(['ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'type' => 1]);
        } elseif ($type === '2') {
            $query->andWhere(['or', ['ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'type' => 0], ['ID_NHANVIEN' => $dotbd->ID_NHANVIEN, 'type' => 1]]);
        }
        $listAnh = $query->orderBy(['type' => SORT_ASC])->all();
        
        
        if (empty($listAnh)) {
            Yii::$app->api->sendFailedResponse("Không có ảnh");
        }
        foreach ($listAnh as $each) {
            ($each->type == 0) ? $data['nhanvien'][$each->nHANVIEN->TEN_NHANVIEN][] = $each->attributes : $data['totruong'][$each->nHANVIEN->TEN_NHANVIEN][] = $each->attributes;
        }
        Yii::$app->api->sendSuccessResponse($data);
    }

    public function actionGetNhanvien($id)
    {
        $list = Noidungcongviec::find()->where(['ID_DOTBD' => $id])->groupBy('ID_NHANVIEN')->all();
        if (empty($list)) {
            Yii::$app->api->sendFailedResponse("Đợt bảo dưỡng không có công việc!!!");
        }
        foreach ($list as $each) {
            $data[] = ['ID_NHANVIEN' => $each->ID_NHANVIEN, 'TEN_NHANVIEN' => $each->nHANVIEN->TEN_NHANVIEN];
        }
        Yii::$app->api->sendSuccessResponse($data);
    }
}
