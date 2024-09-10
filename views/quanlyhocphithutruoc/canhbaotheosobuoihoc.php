<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = 'QUẢN LÝ HỌC SINH';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <?= $this->render('/partial/_header_hocphithutruoc', []) ?>
    <div class="box-body">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => '/quanlyhocphithutruoc/canhbaotheosobuoihoc',
            ]); ?>
            <div class="col-md-4 col-xs-4">
                <?= Select2::widget([
                    'name' => 'ID_LOP',
                    'id' => 'ID_LOP',
                    'value' => $params['ID_LOP'] ?? 2,
                    'data' => $dslop,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Chọn lớp'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]); ?>
            </div>
            <div class="col-md-2 col-xs-2">
                <label>Xuất excel</label>
                <input type="checkbox" name="is_excel" value="1">
            </div>
            <div class="col-md-2 col-xs-2">
                <?= Html::submitButton(
                    '<i class="fa fa-search"></i> Xem báo cáo', 
                    [
                        'class'=>'btn btn-primary btn-flat',
                        'id' => 'searchBtn',
                        
                    ])
                ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="box-body table-responsive">
            <div class="col-lg-12 col-12">
                <table class="table table-bordered">
                    <tbody>
                        <tr class="bg-primary text-center">
                            <th class="text-center">STT</th>
                            <th class="text-center">LỚP</th>
                            <th class="text-center">HỌC SINH</th>
                            <th class="text-center">SỐ BUỔI ĐÃ THU TIỀN</th>
                            <th class="text-center">SỐ BUỔI ĐÃ HỌC</th>
                            <th class="text-center">SỐ BUỔI CÒN LẠI</th>
                            <th class="text-center"></th>
                        </tr>
                        <?php
                        foreach ($result as $key => $value):
                        ?>
                        <tr style=" color: <?= $value['SOBUOI_CONLAI'] < 1 ? 'red;' : ''?>;">
                            <td><?= $key + 1?></td>
                            <td><?= $value['TEN_LOP']?></td>
                            <td><?= ($value['HO_TEN'])?></td>
                            <td class="text-center"><?= number_format($value['SOLUONG_DADONGTIEN'])?></td>
                            <td class="text-center"><?= number_format($value['SOLUONG_DAHOC'])?></td>
                            <td class="text-center"><?= number_format($value['SOBUOI_CONLAI'])?></td>
                            <td class="text-center"></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
