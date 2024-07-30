<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Hocsinh;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $model->MA_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('_detail', [
        'model' => $model,
    ]) ?>
    <p>
        <?php if (Yii::$app->user->can('quanlyhocsinh')):?>
            <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID_LOP], ['class' => 'btn btn-primary btn-flat']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('diemdanhlophoc') && $model->STATUS == 1):?>
            <?= Html::a('<i class="fa fa-pencil-square-o"></i> Quản lý điểm danh', ['lophoc/quanlydiemdanh', 'id' => $model->ID_LOP], ['class' => 'btn btn-danger btn-flat']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('quanlyhocsinh')):?>
            <?= Html::a('<i class="fa fa-pencil-square-o"></i> Quản lý học sinh', ['quanlyhocsinh', 'id' => $model->ID_LOP], ['class' => 'btn btn-primary btn-flat']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('quanlyhocsinh') && !$model->getDshocsinh()->count()): ?>
            <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID_LOP], [
                'class' => 'btn btn-danger btn-flat',
                'data' => [
                    'confirm' => 'Bạn chắc chắn muốn xóa mục này?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>
</div>
<div class="box-body table-responsive">
    <h1>NGÀY HIỆN TẠI</h1>
    <table class="table table-bordered" style="font-size: 20px;">
        <tbody>
            <tr class="bg-primary">
                <th>THỨ</th>
                <th>NGÀY</th>
                <th>TỔNG SỐ <br/>HỌC SINH</th>
                <th>SỐ HỌC SINH <br/>ĐI HỌC</th>
                <th>DANH SÁCH HS NGHỈ</th>
                <th></th>
            </tr>
            <?php
            $diemdanh = $model->getDsdiemdanh()->andWhere(['NGAY_DIEMDANH' => date('Y-m-d')])->one();
            if($diemdanh):?>
                <tr class="bg-primary">
                    <th><?= dateofmonth()[date_format(date_create($diemdanh->NGAY_DIEMDANH), 'w')];?></th>
                    <th><?= $diemdanh->NGAY_DIEMDANH?></th>
                    <th><?= $diemdanh->getDschitietdiemdanh()->count()?></th>
                    <th><?= $diemdanh->getDschitietdiemdanh()->andWhere(['STATUS' => 1])->count()?></th>
                    <th><?php
                        $idhocsinh = ArrayHelper::map($diemdanh->getDschitietdiemdanh()->andWhere(['STATUS' => 0])->all(), 'ID_HOCSINH', 'ID_HOCSINH');
                                $dshocsinhvang = ArrayHelper::map(Hocsinh::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['in', 'ID', $idhocsinh])->all(), 'ID', 'HO_TEN');
                        echo implode(',', $dshocsinhvang);
                        ?>
                    </th>
                    <th><?=  $diemdanh->lop->STATUS ? Html::a('<i class="fa fa-pencil-square-o"></i>Cập nhật', '/lophoc/capnhatdiemdanh?diemdanhid=' . $diemdanh->ID, ['class' => 'btn btn-primary']) : '';?></th>
                </tr>
            <?php else:?>
            <?php endif;?>
        </tbody>
    </table>
</div>
<div class="row">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        // 'action' => ['baocaotheothoigian'],
    ]); ?>
    <div class="col-sm-3" style="margin-top: 15px">
        <label class="control-label">Từ ngày</label>
        <?= DatePicker::widget([
            'attribute' => 'TU_NGAY',
            'name' => 'TU_NGAY',
            'value' => $params['TU_NGAY'] ?? null,
            'removeButton' => false,
            'options' => ['required' => true],
            'pluginOptions' => [
                'placeholder' => 'TỪ NGÀY', 
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]); ?>
    </div>

    <div class="col-sm-3" style="margin-top: 15px">
        <label class="control-label">Đến ngày</label>
        <?= DatePicker::widget([
            'attribute' => 'DEN_NGAY',
            'name' => 'DEN_NGAY', 
            'value' => $params['DEN_NGAY'] ?? null,
            'removeButton' => false,
            'options' => ['placeholder' => 'ĐẾN NGÀY', 'required' => true, 'allowClear' => true],
            'pluginOptions' => [

                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]); ?>
    </div>
    <div class="col-md-2 col-xs-2">
        <?= Html::submitButton(
            '<i class="fa fa-search"></i> Xem', 
            [
                'class'=>'btn btn-primary btn-flat',
                'id' => 'searchBtn',
                
            ])
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<div class="box-body table-responsive">
    <table class="table table-bordered" style="font-size: 20px;">
        <tbody>
            <tr class="bg-primary">
                <th style="width: 10px">#</th>
                <th >HỌC SINH</th>
                <th >TỔNG SỐ <br/>BUỔI</th>
                <th >SỐ BUỔI <br/>HỌC</th>
                <th >SỐ BUỔI <br/>NGHỈ</th>
                <th >NGÀY NGHỈ</th>
            </tr>
            <?php foreach ($data as $key => $value): ?>
                <tr>
                    <td scope="col"><?= $key + 1;?></td>
                    <td scope="col"><?= $value['HO_TEN']?></td>
                    <td scope="col"><?= $value['SO_LUONG']?></td>
                    <td scope="col"><?= $value['SOLUONGDIHOC']?></td>
                    <td scope="col" style="<?= $value['SO_LUONG'] != $value['SOLUONGDIHOC'] ? 'color: red;' : ''?>"><?= $value['SO_LUONG'] - $value['SOLUONGDIHOC']?></td>
                    <td scope="col"><?= $value['NGAYNGHI']?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>