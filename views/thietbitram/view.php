<?php

use yii\helpers\Html;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model app\models\Thietbitram */

$this->title = $model->iDLOAITB->TEN_THIETBI;
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị', 'url' => ['nhomtbi/index']];
$this->params['breadcrumbs'][] = ['label' => 'Quản lý thiết bị theo trạm', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Trạm '.$model->iDTRAM->MA_TRAM, 'url' => ['tramvt/view', 'id' => $model->ID_TRAM]];
$this->params['breadcrumbs'][] = $this->title;

$visible = false;
if (Yii::$app->user->can('edit-tramvt')) {
    switch (Yii::$app->user->identity->nhanvien->chucvu->cap) {
        case '1':
            $visible = true;
            break;
        case '2':
            if ($model->iDTRAM->iDDAI->ID_DONVI == Yii::$app->user->identity->nhanvien->ID_DONVI) {
                $visible = true;
            }
            break;
        case '3':
            if ($model->iDTRAM->ID_DAI == Yii::$app->user->identity->nhanvien->ID_DAI) {
                $visible = true;
            }
            break;
        case '4':
            if ($model->iDTRAM->ID_NHANVIEN == Yii::$app->user->identity->nhanvien->ID_NHANVIEN) {
                $visible = true;
            }
            break;
        case '5':
            if ($model->iDTRAM->ID_DAI == Yii::$app->user->identity->nhanvien->ID_DAI) {
                $visible = true;
            }
            break;
        
        default:
            $visible = false;
            break;
    }
}
?>
<div class="thietbitram-view">
    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?php 
                if ($visible) { ?>
                    <?= Html::a('<i class="fa fa-pencil-square-o"></i> Cập nhật', ['update', 'id' => $model->ID_THIETBI], ['class' => 'btn btn-primary btn-flat']); ?>
                    <?= Html::a('<i class="fa fa-trash-o"></i> Xóa', ['delete', 'id' => $model->ID_THIETBI], [
                        'class' => 'btn btn-danger btn-flat',
                        'data' => [
                            'confirm' => 'Bạn chắc chắn muốn xóa mục này?',
                            'method' => 'post',
                        ],
                    ]); ?> 
                <?php } ?>
            </p>
            <?php

            $items = [
                [
                    'label'=>'<i class="fa fa-info-circle"></i> Thông tin thiết bị',
                    'content'=>$this->render('_tabthongtin', [
                        'model' => $model
                    ]),
                    'active'=>true
                ],
                [
                    'label'=>'<i class="fa fa-cogs"></i> Lịch sử bảo dưỡng',
                    'content'=>$this->render('_tablichsubaoduong', [
                        'lsbaoduongProvider' => $lsbaoduongProvider 
                    ]),
                ],
                [
                    'label'=>'<i class="fa fa-retweet"></i> Thông tin điều chuyển',
                    'content'=>$this->render('_tabdieuchuyen', [
                        'model' => $model,
                        'dieuchuyenProvider' => $dieuchuyenProvider 
                    ]),
                ],
            ];

            echo TabsX::widget([
                'position'=>TabsX::POS_ABOVE,
                'containerOptions' => [
                    'class' => 'nav-tabs-custom',
                ],
                'items'=>$items,
                'encodeLabels'=>false
            ]);
            ?>            
        </div>
    </div>
</div>

