<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div data-productid="<?= $model->id?>" id ="product-view" class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    <? $img = $model->getImage(); ?>
    <? 
        $gallery = $model->getImages(); ;
       
        $images="";
        foreach($gallery as $image){
            $images= $images. "<img class='del-gallery-img' data-id='".$image->id."'src='".$image->getUrl('200x')."' >";
        }
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'category_id',
            [
                'attribute' => 'category_id',
                'value' => $model->category->name,
                
            ],
            'name',
            'content:html',
            'price',
            'keywords',
            'description',
//            'img',
            [
                'attribute' => 'image',
                'value' => "<img src='{$img->getUrl('200x')}'>",
                'format' => 'html',
                
            ],
                        [
                'attribute' => 'gallery',
                'value' => $images,
                'format' => 'raw',
                
            ],
            
            'hit',
            'new',
            'sale',
        ],
    ]) ?>

</div>
