<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kehoachbdtb */

$this->title = 'Chi tiết công việc';
$this->params['breadcrumbs'][] = ['label' => 'Công việc', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kehoachbdtb-view">
    <div class="box box-primary">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'ID_DOTBD',
                        'value' => $model->dOTBD->MA_DOTBD
                    ],
                    [
                        'attribute' => 'ID_THIETBI',
                        'value' => $model->tHIETBI->iDLOAITB->TEN_THIETBI
                    ],
                    [
                        'attribute' => 'MA_NOIDUNG',
                        'value' => $model->mANOIDUNG->NOIDUNG
                    ],
                    [
                        'attribute' => 'Ngày bảo dưỡng',
                        'value' => $model->dOTBD->NGAY_BD
                    ],
                    [ 
                        'attribute' => 'TRANGTHAI',
                        'visible' => ($model->dOTBD->TRANGTHAI == 'Kế hoạch') ? false : true
                    ],
                    [ 
                        'attribute' => 'KETQUA',
                        'visible' => ($model->dOTBD->TRANGTHAI == 'Kế hoạch') ? false : true
                    ],
                    [ 
                        'attribute' => 'GHICHU',
                        'visible' => ($model->dOTBD->TRANGTHAI == 'Kế hoạch') ? false : true
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
