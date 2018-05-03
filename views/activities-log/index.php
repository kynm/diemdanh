<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ActivitiesLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activities Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activities-log-index">
  <div class="box box-primary">
      <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                  'attribute' => 'description',
                  'format' => 'raw',
                ],
                [
                   'attribute' => 'user_id',
                   'value' => 'user.nhanvien.TEN_NHANVIEN',
                ],
                [
                   'attribute' => 'create_at',
                   'format' => ['date', 'php:d-m-Y H:m:s'],
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
      </div>
  </div>
</div>
