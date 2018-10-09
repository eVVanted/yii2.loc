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
use yii\data\Pagination;

class CategoryController extends AppController{

    public function actionIndex(){
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('E-SHOPPER');
        //debug($hits);
        return $this->render('index', compact('hits'));
    }
    
    public function actionView($id){
        //$id = Yii::$app->request->get('id'); $id можно получить 2мя способами, как параметр метода и через get
        $category = Category::findOne($id);
        if (empty($category)){
            throw new \yii\web\HttpException(404, 'Такой категории не существует.');
        }
        //debug($id);
//        $products = Product::find()->where(['category_id' => $id])->all();
        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(),'pageSize' =>3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $this->setMeta('E-SHOPPER | '. $category->name, $category->keywords, $category->description);
        return $this->render('view', compact('products','pages', 'category'));
        //debug($products);
    }

    public function actionSearch(){
        $q = trim(Yii::$app->request->get('q')); // здесь получаем поисковый запрос
        $this->setMeta('E-SHOPPER | '. $q);
        if(!$q)
            return $this->render('search');
        $query = Product::find()->where(['like', 'name', $q]);
        $pages = new Pagination(['totalCount' => $query->count(),'pageSize' =>3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('search', compact('products','pages', 'q'));
    }

}