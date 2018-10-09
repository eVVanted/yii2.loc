<?php
/**
 * Created by PhpStorm.
 * User: Wanted
 * Date: 05.06.2018
 * Time: 22:48
 */

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;


class ProductController extends AppController{
    
    public function actionView($id){
        //$id = Yii::$app->request->get('id'); $id можно получить 2мя способами, как параметр метода и через get
        //ленивая загрузка
        $product = Product::findOne($id);
        if (empty($product)){
            throw new \yii\web\HttpException(404, 'Такого товара не существует.');
        }
        // жадная загрузка
//        $product = Product::find->with('category')->where('id'=>$id)->limit(1)->one();
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('E-SHOPPER | '. $product->name, $product->keywords, $category->product);
        return $this->render('view', compact('product','hits'));
    }
}