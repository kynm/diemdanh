<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="box box-primary">
        <div class="box-body">
            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Create User', ['create'], ['class' => 'btn btn-primary btn-flat']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'username',
                    'email:email',
                    ['class' => 'yii\grid\ActionColumn',
                    'template' => (Yii::$app->user->can('edit-user')) ? '{view} {update} {delete}' : '{view}'],
                ],
            ]); ?>
        </div>
    </div>
</div>
