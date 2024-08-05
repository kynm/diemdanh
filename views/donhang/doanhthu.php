<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel app\models\lophocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Doanh thu';
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lophoc-index">
<?= $this->render('/partial/_header_donhang', []) ?>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <?php if (Yii::$app->user->can('Administrator')):?>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-check" aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number" style="font-size: 20px; color: red;">DOANH THU</span>
                            <?= number_format($tongdoanhthu) ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
