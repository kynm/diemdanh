<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Daivt;
use app\models\Tramvt;
use app\models\Donvi;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TramvtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Iin thống kê sử dụng điện theo trung tâm viễn thông';
$this->params['breadcrumbs'][] = $this->title;

?>
<table class="table">
    <tr style="border: none;">
        <td colspan="2" style="text-align: center;border: none;">VNPT HÀ NAM</td>
        <td colspan="4"style="text-align: center;border: none;"></td>
        <td colspan="2" style="text-align: center;border: none;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</td>
    </tr>
    <tr style="border: none;">
        <td colspan="2" style="text-align: center;border: none;"><?php echo $donvi->TEN_DONVI ?? 'Toàn tỉnh';?></td>
        <td colspan="3" style="text-align: center;border: none;width: 50%"></td>
        <td colspan="3" style="text-align: center;border: none;">Độc lập - Tự do - Hạnh phúc</td>
    </tr>
    <tr style="border: none;">
        <td colspan="2" style="text-align: center;border: none;"></td>
        <td colspan="3"style="text-align: center;border: none;width: 50%"></td>
        <td colspan="3" style="text-align: center;border: none;font-style: italic;">Hà Nam, ngày <?php echo date('d')?> tháng <?php echo date('m')?> năm <?php echo date('Y')?></td>
    </tr>
    <tr style="border: none;">
        <td colspan="8" style="text-align: center;border: none;font-weight: bold;"><h3>TỜ TRÌNH  THANH TOÁN  TIỀN ĐIỆN </h3></td>
    </tr>
        <tr style="border: none;">
        <td colspan="8" style="text-align: center;border: none;"><span style="margin-right: 100px"> Tháng:  <?php echo $inputs['THANG'] . '/' . $inputs['NAM']?> </span></td>
    </tr>
</table>
<div class="tramvt-index">
    <div class="box box-primary">
        <div class="box-body">
            <?= $this->render('_table_data', [
                'dssddien' => $dssddien,
                'tongdiendv' => $tongdiendv,
                'tongdiennh' => $tongdiennh,
            ]) ?>
        </div>
    </div>
</div>
<table class="table">
    <tr style="border: none;"></tr>
    <tr style="border: none;"></tr>
    <tr style="border: none;"></tr>
    <tr style="border: none;"></tr>
    <tr style="border: none;"></tr>
    <tr style="border: none;">
        <td colspan="2" style="text-align: center;border: none;">Người lập biểu</td>
        <td colspan="3" style="text-align: center;border: none;width: 50%"></td>
        <td colspan="3" style="text-align: center;border: none;"></td>
    </tr>
    <tr style="border: none;">
        <td colspan="2" style="text-align: center;border: none;"></td>
        <td colspan="3"style="text-align: center;border: none;width: 50%"></td>
        <td colspan="3" style="text-align: center;border: none;font-style: italic;">Hà Nam, ngày <?php echo date('d')?> tháng <?php echo date('m')?> năm <?php echo date('Y')?></td>
    </tr>
    <tr style="border: none;">
        <td colspan="2" style="text-align: center;border: none;"></td>
        <td colspan="3"style="text-align: center;border: none;width: 50%"></td>
        <td colspan="3" style="text-align: center;border: none;font-style: italic;">Thủ trưởng đơn vị</td>
    </tr>
</table>
