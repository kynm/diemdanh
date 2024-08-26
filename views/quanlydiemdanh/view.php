<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use app\models\Hocsinh;

/* @var $this yii\web\View */
/* @var $model app\models\Donvi */

$this->title = $model->TIEUDE;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="donvi-view">

    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('In điểm danh', ['indiemdanhngay', 'id' => $model->ID], ['class' => 'btn btn-primary btn-flat', 'target' => '_blank']) ?>
            </p>

            <div class="col-lg-12 col-12">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'ID_LOP',
                        'value' => function ($model) {
                            return  Html::a($model->lop->TEN_LOP, ['/lophoc/view', 'id' => $model->ID_LOP], ['data-pjax' => 0]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'THU',
                        'value' => function ($model) {
                            return dateofmonth()[date_format(date_create($model->NGAY_DIEMDANH), 'w')];
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'ID_NHANVIEN',
                        'value' => function ($model) {
                            return $model->nhanvien->TEN_NHANVIEN;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'NOIDUNG',
                        'value' => function ($model) {
                            return  nl2br($model->NOIDUNG);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'SOHOCSINH',
                        'value' => function ($model) {
                            return $model->getDschitietdiemdanh()->count();
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'SOHOCSINHDIHOC',
                        'value' => function ($model) {
                            return $model->getDschitietdiemdanh()->andWhere(['STATUS' => 1])->count();
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'VANG',
                        'value' => function ($model) {
                            return '<span style="color: red; font-size:20px">' . $model->getDschitietdiemdanh()->andWhere(['STATUS' => 0])->count() . '</span>';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'DSHOCSINHVANG',
                        'value' => function ($model) {
                            $idhocsinh = ArrayHelper::map($model->getDschitietdiemdanh()->andWhere(['STATUS' => 0])->all(), 'ID_HOCSINH', 'ID_HOCSINH');
                            $dshocsinhvang = ArrayHelper::map(Hocsinh::find()->where(['ID_DONVI' => Yii::$app->user->identity->nhanvien->ID_DONVI])->andWhere(['in', 'ID', $idhocsinh])->all(), 'ID', 'HO_TEN');
                            return $dshocsinhvang ? implode(',', $dshocsinhvang) : null;
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'GHICHU',
                        'value' => function ($model) {
                            return $model->ghichu;
                        },
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
            </div>
        </div>
    </div>
</div>