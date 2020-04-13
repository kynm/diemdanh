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
use app\models\DotbaoduongCanhanSearch;
use app\models\AuthorizationCodes;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\MultipleUploadForm;

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
                    'hoanthanh' => ['POST'],
                    'uploadanhdotbaoduong' => ['POST'],
                    'nhanvienhoanthanh' => ['POST'],
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

    public function actionDanhsachvieccanxacnhan($trangthai = '', $daivt='', $tramvt='')
    {
        $trangthai = $trangthai ? $trangthai : 'chuahoanthanh';

        $searchModel = new DotbaoduongCanhanSearch();
        switch ($trangthai) {
            case 'chuahoanthanh':
                $planProvider = $searchModel->searchChxn(Yii::$app->request->queryParams);
                break;
            case 'ketthuc':
                $planProvider = $searchModel->searchKtbd(Yii::$app->request->queryParams);
                break;
            default:
                $planProvider = $searchModel->searchDskh(Yii::$app->request->queryParams);
                break;
        }

        return $this->render('danhsachvieccanxacnhan', [
            'searchModel' => $searchModel,
            'planProvider' => $planProvider,
            'trangthai' => $trangthai,
        ]);
    }

    public function actionDanhsach($trangthai = '', $daivt='', $tramvt='')
    {

        $trangthai = $trangthai ? $trangthai : 'kehoach';
        $searchModel = new DotbaoduongCanhanSearch();
        switch ($trangthai) {
            case 'kehoach':
                $planProvider = $searchModel->searchDskh(Yii::$app->request->queryParams);
                break;
            case 'dangthuchien':
                $planProvider = $searchModel->searchDsth(Yii::$app->request->queryParams);
                break;
            case 'chuahoanthanh':
                $planProvider = $searchModel->searchChxn(Yii::$app->request->queryParams);
                break;
            default:
                $planProvider = $searchModel->searchDskh(Yii::$app->request->queryParams);
                break;
        }

        return $this->render('danhsach', [
            'searchModel' => $searchModel,
            'planProvider' => $planProvider,
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
        $data = [];
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
        return $this->render('lichsu', [
            'data' => $data,
        ]);
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
        
        $array = [];
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
            'dotbd' => $dotbd,
        ]);
    }

    public function actionXacnhancongviec($id)
    {
        $dotbd = Dotbaoduong::findOne(['ID_DOTBD' => $id]);
        $data["THONGTIN_DBD"] = $dotbd->attributes;
        unset($data["THONGTIN_DBD"]["ID_TRAM"]);
        $data["THONGTIN_DBD"]["TRAMVT"] = $dotbd->tRAMVT;
        $query = Noidungcongviec::find()->where(['ID_DOTBD' => $dotbd->ID_DOTBD]);
        $listCongViec = $query->all();
        $array = [];
        foreach ($listCongViec as $each) {
            $array = $each->attributes;
            $array['NOIDUNG'] = $each->mANOIDUNG->attributes;
            $array['NHANVIEN'] = $each->nHANVIEN->TEN_NHANVIEN;
            unset($array['MA_NOIDUNG']);
            unset($array['NOIDUNG']['ID_THIETBI']);
            $congviec[$each->tHIETBI->iDLOAITB->TEN_THIETBI][] = $array;
        }
        $data["DS_CONGVIEC"] = $congviec;
        return $this->render('xacnhancongviec', [
            'data' => $data,
            'dotbd' => $dotbd,
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
        
        $array = [];
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

                return $this->redirect(['xem', 'id' => $id]);
            }
        } else {
            return $this->redirect(['xem', 'id' => $id]);
        }
    }

    public function actionNhanvienhoanthanh()
    {
        $inputs = Yii::$app->request->bodyParams;
        $id = $inputs['ID_DOTBD'];
        $dotbd = Dotbaoduong::findOne(['ID_DOTBD' => $id]);
        $errors = [
            'error' => 0,
            'message' => '',
        ];
        if ($dotbd->TRANGTHAI == "dangthuchien") {
            if ($dotbd->ID_NHANVIEN !== Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
                $errors['error'] = 1;
                $errors['message'] = 'Bạn không có quyền hoàn thành đợt bảo dưỡng';
            }

            $hoanthanh = Noidungcongviec::find()->where(['ID_DOTBD' => $id])
                ->andWhere(['TRANGTHAI' => 'cho_xac_nhan'])
                ->count();
            $all = Noidungcongviec::find()->where(['ID_DOTBD' => $id])
                ->count();
            if ($hoanthanh !== $all) {
                $errors['error'] = 1;
                $errors['message'] = 'Còn nội dung công việc chưa hoàn thành!';
            }

            if ($errors['error']) {
                return json_encode($errors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                $dotbd->TRANGTHAI = "chuahoanthanh";
                $dotbd->save(false);
                return json_encode($errors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }

        } else {
            $errors['error'] = 1;
            $errors['message'] = 'Bạn không có quyền hoàn thành đợt bảo dưỡng';
            return json_encode($errors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function actionHoanthanh()
    {
        $key = Yii::$app->request->bodyParams;
        $id = $key['ID_DOTBD'];
        $dotbd = Dotbaoduong::findOne($id);
        $hoanthanh = Noidungcongviec::find()->where(['ID_DOTBD' => $id])
            ->andWhere(['TRANGTHAI' => 'hoan_thanh'])
            ->count();
        $all = Noidungcongviec::find()->where(['ID_DOTBD' => $id])
            ->count();
        $count = Images::find()->where(['MA_DOTBD' => $dotbd->MA_DOTBD, 'type' => 0])->count();
        $errors = [
            'error' => 1,
            'message' => '',
        ];
        if ($hoanthanh !== $all) {
            $errors['message'] = 'Còn nội dung công việc chưa hoàn thành!';
        } elseif ($count < 0) {
            $errors['message'] = 'Nhân viên bảo dưỡng chưa upload đủ hình ảnh';
        } else {
            $dotbd->NGAY_KT = date('Y-m-d');
            $dotbd->TRANGTHAI = 'ketthuc';
            $dotbd->save(false);
            if ($dotbd->baoduongtong->TYPE == 2) {
                $tramvt = Tramvt::findOne($dotbd->ID_TRAM);
                $tramvt->NGAY_KTNT = $dotbd->NGAY_KT;
                $tramvt->save(false);
            }
            $errors['error'] = 0;
            $errors['message'] = 'Success';
        }

        return json_encode($errors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

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

    public function actionUploadanhdotbaoduong()
    {
        $model = new MultipleUploadForm();
        // $file = UploadedFile::getInstanceByName('file');

        // $id = Yii::$app->request->post('ID_DOTBD');
        $inputs = Yii::$app->request->bodyParams;
        echo "<pre>";
        die(var_dump($inputs));
        $dotbd = Dotbaoduong::findOne($id);
        // var_dump(Yii::$app->request->post()); die;

        $MA_DOTBD = $dotbd->MA_DOTBD;
        $STT = Yii::$app->request->post('STT');
        $type = Yii::$app->request->post('type');
        $username = Yii::$app->user->identity->username;

        $filename = "$MA_DOTBD-$username-$STT-$type";
        $path = 'C:\xampp\htdocs\vnpt_mds\uploads\\';
        // var_dump(Yii::$app->request->post('file')); die;
        $file = Yii::$app->convert->base64_to_image(Yii::$app->request->post('file'), $path, $filename);

        // var_dump($file); die;
        
        if ($file) {
            if (!Images::find()->where(['MA_DOTBD' => $MA_DOTBD, 'STT' => $STT, 'ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'type' => $type])->exists()) {
                $image = new Images();
            } else {
                $image = Images::find()->where(['MA_DOTBD' => $MA_DOTBD, 'STT' => $STT, 'ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'type' => $type])->one();
            }
            $image->MA_DOTBD = $MA_DOTBD;
            $image->ANH = $file;
            $image->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $image->STT = $STT; 
            $image->type = $type;
            $image->save(false);
            Yii::$app->api->sendSuccessResponse(['filename' => $file]);
        } else {
            Yii::$app->api->sendFailedResponse('Failed!');
        }
    }
}
