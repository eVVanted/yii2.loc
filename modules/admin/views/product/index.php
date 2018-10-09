<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'category_id',
            [
                'attribute' => 'category_id',
                'value' => function($data){
                    return $data->category->name;
                }
            ],
            'name',
//            'content:ntext',
            'price',
            //'keywords',
            //'description',
            //'img',
            //'hit',
//            'gallery',
            [
                'attribute' => 'gallery',
                'value' => function($data){
                    $gallery = $data->getImages();
                    $images="";
                    foreach($gallery as $image){
                        $images= $images. "<img src='".$image->getUrl('50x')."'>";
                    }
                    return $images;
                },
                'format' => 'raw', // это чтобы было видно оформление вместо кода, вместо raw можно использовать html
            ],
            [
                    'attribute' => 'hit',
                    'value' => function($data){
                        return !$data->hit ? '<span class="glyphicon glyphicon-remove text-danger" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>';
                    },
                    'format' => 'raw', // это чтобы было видно оформление вместо кода, вместо raw можно использовать html
            ],
            //'new',
            [
                    'attribute' => 'new',
                    'value' => function($data){
                        return !$data->new ? '<span class="text-danger">Нет</span>' : '<span class="text-success">Да</span>';
                    },
                    'format' => 'raw', // это чтобы было видно оформление вместо кода, вместо raw можно использовать html
            ],
            //'sale',
            [
                    'attribute' => 'sale',
                    'value' => function($data){
                        return !$data->sale ? '<span class="text-danger">Нет</span>' : '<span class="text-success">Да</span>';
                    },
                    'format' => 'raw', // это чтобы было видно оформление вместо кода, вместо raw можно использовать html
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
