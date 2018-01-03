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

    
    

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            [
                'attribute' => 'role',
                'value' => 'role0.role_name'
            ],
            'email:email',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
