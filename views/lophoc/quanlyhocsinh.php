<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\Daivt */

$this->title = $model->MA_LOP;
$this->params['breadcrumbs'][] = ['label' => 'Đơn vị', 'url' => ['donvi/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daivt-view">
    <?= $this->render('_detail', ['model' => $model,]) ?>
</div>
<?php if (Yii::$app->user->can('quanlyhocsinh')):?>
<div class="daivt-view">
    <?= $this->render('_form_hocsinh', ['model' => $hocsinh, 'id' => $model->ID_LOP]) ?>
</div>
<?php endif; ?>
<div class="box box-primary">
    <div class="box-body">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'MA_HOCSINH',
                    'HO_TEN',
                    'TIENHOC',
                    'DIA_CHI',
                    'SO_DT',
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>