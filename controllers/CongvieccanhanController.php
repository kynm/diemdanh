<?php

namespace app\controllers;

use Yii;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\User;
use app\models\Thietbitram;
use app\models\Dotbaoduong;
use app\models\Noidungbaotrinhomtbi;
use app\models\Noidungcongviec;
use app\models\Noidungbaotri;
use app\models\AuthorizationCodes;
use app\models\AccessTokens;
use app\models\Images;
use app\behaviours\Verbcheck;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class CongvieccanhanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors + [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'congviec' => ['GET'],
                    'hoanthanh' => ['POST'],
                    'xacnhan' => ['POST'],
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

    public function actionLuu()
    {
        $key = Yii::$app->request->bodyParams;
        
        $model = Noidungcongviec::find()->where(['ID_DOTBD' => $key['ID_DOTBD'], 'ID_THIETBI' => $key['ID_THIETBI'], 'MA_NOIDUNG' => $key['MA_NOIDUNG'], 'ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN])->one();
        if(!$model) {
            Yii::$app->api->sendFailedResponse("Không tìm thấy nội dung");
        }
        $data = [];
        if (isset($key['GHICHU'])) {
            $model->GHICHU = @$key['GHICHU'];
            $data['GHICHU'] = $model->GHICHU;
        }
        if (isset($key['KIENNGHI'])) {
            $model->KIENNGHI = @$key['KIENNGHI'];
            $data['KIENNGHI'] = $model->KIENNGHI;
        }
        if (isset($key['SOLIEUTHUCTE'])) {
            $model->SOLIEUTHUCTE = @$key['SOLIEUTHUCTE'];
            $data['SOLIEUTHUCTE'] = $model->SOLIEUTHUCTE;
        }

        $model->save(false);

        Yii::$app->api->sendSuccessResponse($data);
    }

    
    public function actionUrlgetmodal()
    {
        $key = Yii::$app->request->bodyParams;
        $condition = [
            'ID_DOTBD' => $key['ID_DOTBD'], 
            'ID_THIETBI' => $key['ID_THIETBI'],
            'MA_NOIDUNG' => $key['MA_NOIDUNG'],
        ];
        $model = Noidungbaotrinhomtbi::find()->where(['MA_NOIDUNG' => $key['MA_NOIDUNG']])->one();
        $congviec = json_decode($model->SAMPLE_RESULT, true);
        return $this->renderPartial('_aj_ketquacongviec',[
            'model'=>$model,
            'congviec'=>$congviec,
            'condition'=>$key,
        ]);
    }

    public function actionHoanthanh()
    {
        $key = Yii::$app->request->bodyParams;
        $condition = [
            'ID_DOTBD' => $key['ID_DOTBD'], 
            'ID_THIETBI' => $key['ID_THIETBI'],
            'MA_NOIDUNG' => $key['MA_NOIDUNG'],
        ];
        $isDone = $key['IS_DONE'] ? 1 : 0;
        $dobd = Dotbaoduong::findOne($key['ID_DOTBD']);
        if ($dobd->TRANGTHAI != 'dangthuchien') {
            return json_encode(["message" => "Bạn không thể sửa đổi công việc","error" => "1"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        $model = Noidungcongviec::find()->where($condition)->one();
        if(!$model) {
        return json_encode(["message" => "Công việc không tồn tại","error" => "1"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        if ($isDone) {
            $model->TRANGTHAI = "cho_xac_nhan";
            $model->KETQUA = $key['KETQUABAODUONG'];
            if (isset($key['SOLIEUTHUCTE'])) {
                $model->KETQUAXULY = json_encode($key['SOLIEUTHUCTE']);
            }
            $model->KIENNGHI = $key['KIENNGHI'];
            $model->GHICHU = $key['GHICHU'];
            $model->save(false);
            $thietbi = Thietbitram::findOne(['ID_THIETBI' => $model->ID_THIETBI]);
            $thietbi->LANBAODUONGTRUOC = date('Y-m-d');
            $thietbi->save(false);
        } else {
            $model->TRANGTHAI = NULL;
            $model->KETQUA = NULL;
            $model->KIENNGHI = NULL;
            $model->KETQUAXULY = NULL;
            $model->GHICHU = NULL;
            $model->save(false);
        }

        return json_encode([
            "message" => "False!",
            "ID_THIETBI" => $key['ID_THIETBI'],
            "MA_NOIDUNG" => $key['MA_NOIDUNG'],
            "IS_DONE" => $isDone,
            "error" => false
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function actionXacnhan()
    {
        $key = Yii::$app->request->bodyParams;
        if ($key['KETQUA'] == 1) {
            unset($key['KETQUA']);
            $model = Noidungcongviec::find()->where($key)->one();
            $model->TRANGTHAI = "hoan_thanh";
            // $model->KETQUA = "dat";
            $model->save(false);
        } else {
            unset($key['KETQUA']);
            $model = Noidungcongviec::find()->where($key)->one();
            $model->TRANGTHAI = "hoan_thanh";
            // $model->KETQUA = "khong_dat";
            $model->save(false);
        }
        Yii::$app->api->sendSuccessResponse(["message" => "Success!"]);
    }

    public function actionXacnhantatca()
    {
        $key = Yii::$app->request->bodyParams;
        $listNoidung = Noidungcongviec::findAll(['ID_DOTBD' => $key['ID_DOTBD']]);
        $count = 0;
        if ($key['KETQUA'] == 1) {
            foreach ($listNoidung as $noidung) {
                if ($noidung->TRANGTHAI === NULL) {
                    $count++;
                } elseif ($noidung->TRANGTHAI === 'hoan_thanh') {
                    continue;
                } else {
                    $noidung->TRANGTHAI = "hoan_thanh";
                    $noidung->KETQUA = "dat";
                    $noidung->save(false);
                }
            }
        } else {
            foreach ($listNoidung as $noidung) {
                if ($noidung->TRANGTHAI === NULL) {
                    $count++;
                } elseif ($noidung->TRANGTHAI === 'hoan_thanh') {
                    continue;
                } else {   
                    $noidung->TRANGTHAI = "hoan_thanh";
                    $noidung->KETQUA = "khong_dat";
                    $noidung->save(false);
                }
            }
        }

        return json_encode(["message" => "False!","error" => "0"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                
    }

    public function actionUpload()
    {
        $file = UploadedFile::getInstanceByName('file');

        $id = Yii::$app->request->post('ID_DOTBD');
        $dotbd = Dotbaoduong::findOne($id);
        $MA_DOTBD = $dotbd->MA_DOTBD;
        $STT = Yii::$app->request->post('STT');
        $type = Yii::$app->request->post('type');
        $username = Yii::$app->user->identity->username;
        $filename = "$MA_DOTBD-$username-$STT-$type.$file->extension";
        // $path = '/volume1/web/vnpt_mds/uploads/'.$filename;
        $path = 'C:\xampp\htdocs\vnpt_mds\uploads\\'.$filename;
        if ($file->saveAs($path)) {
            if (!Images::find()->where(['MA_DOTBD' => $MA_DOTBD, 'STT' => $STT, 'ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'type' => $type])->exists()) {
                $image = new Images();
            } else {
                $image = Images::find()->where(['MA_DOTBD' => $MA_DOTBD, 'STT' => $STT, 'ID_NHANVIEN' => Yii::$app->user->identity->nhanvien->ID_NHANVIEN, 'type' => $type])->one();
            }
            $image->MA_DOTBD = $MA_DOTBD;
            $image->ANH = $filename;
            $image->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $image->STT = $STT; 
            $image->type = $type;
            $image->save(false);
            Yii::$app->api->sendSuccessResponse(['filename' => $filename]);
        } else {
            Yii::$app->api->sendFailedResponse('Failed!');
        }
    }

    public function actionUploadv2()
    {
        $key = Yii::$app->request->bodyParams;
        $file = UploadedFile::getInstanceByName('file');

        $id = Yii::$app->request->post('ID_DOTBD');
        $dotbd = Dotbaoduong::findOne($id);
        $MA_DOTBD = $dotbd->MA_DOTBD;
        $ID_THIETBI = Yii::$app->request->post('ID_THIETBI');
        $MA_NOIDUNG = Yii::$app->request->post('MA_NOIDUNG');
        $username = Yii::$app->user->identity->username;
        $filename = "$MA_DOTBD-$username-$ID_THIETBI-$MA_NOIDUNG.$file->extension";
        // $path = '/volume1/web/vnpt_mds/uploads/'.$filename;
        $path = 'C:\xampp\htdocs\vnpt_mds\uploads\\'.$filename;
        if ($file->saveAs($path)) {
            
            unset($key['file']);
            $model = Noidungcongviec::find()->where($key)->one();
            $model->ANH = $filename;
            $model->save(false);
        
            Yii::$app->api->sendSuccessResponse(['filename' => $filename]);
        } else {
            Yii::$app->api->sendFailedResponse('Failed!');
        }
    }

    public function actionUploadbase64v2()
    {
        $inputs = Yii::$app->request->bodyParams;
// var_dump($inputs);
// die();
        $id = Yii::$app->request->post('ID_DOTBD');
        $dotbd = Dotbaoduong::findOne($id);
        $MA_DOTBD = $dotbd->MA_DOTBD;
        // $ID_THIETBI = Yii::$app->request->post('ID_THIETBI');
        // $MA_NOIDUNG = Yii::$app->request->post('MA_NOIDUNG');
        // $username = Yii::$app->user->identity->username;
        // $filename = "$MA_DOTBD-$username-" . strtotime("now");
        // // $path = '/volume1/web/vnpt_mds/uploads/'.$filename;
        // $path = 'C:\xampp\htdocs\vnpt_mds\uploads\\';
        // $file = Yii::$app->convert->base64_to_image($inputs['IMAGEBASE64'], $path, $filename);
        if ($inputs['IMAGEBASE64']) {
            $model = new Images();
            $model->ID_DOTBD = $id;
            $model->ANH = $inputs['IMAGEBASE64'];
            $model->ID_NHANVIEN = Yii::$app->user->identity->nhanvien->ID_NHANVIEN;
            $model->STT = 1;
            $model->type = 1;
            if ($model->save(false)) {
                return json_encode(["message" => "True","error" => "0"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode(["message" => "False!","error" => "1"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        } else {
            Yii::$app->api->sendFailedResponse('Failed!');
        }
    }
}