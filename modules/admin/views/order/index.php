<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_at',
            'updated_at',
            'qty',
            'sum',
//            'status', // если нам нужно подставить наши значения вместо 1 и 0
            [
                    'attribute' => 'status',
                    'value' => function($data){
                        return !$data->status ? '<span class="text-danger">Новый</span>' : '<span class="text-success">Завершен</span>';
                    },
                    'format' => 'raw', // это чтобы было видно оформление вместо кода, вместо raw можно использовать html
            ],
            'name',
            //'email:email',
            //'phone',
            //'address',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
