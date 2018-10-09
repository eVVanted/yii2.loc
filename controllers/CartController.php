<?php


namespace app\controllers;
//use app\models\Category;
use app\models\Product;
use app\models\Cart;
use app\models\OrderItems;
use app\models\Order;
use Yii;
//use yii\data\Pagination;

//    Array
//(
//        [1]=>Array
//        (
//            [qty]=>QTY
//            [name]=> NAME
//            [price]=> PRICE
//            [img]=> IMG
//            )
//        [10] => Array
//        (
//            [qty] =>QTY
//            [name]=> NAME
//            [price]=> PRICE
//            [img]=> IMG
//            )
//    )
//    [qty] =>QTY,
//    [sum] =>SUM
//);

class CartController extends AppController{
    public function actionAdd(){
        $id = Yii::$app->request->get('id');
        $qty = (int)Yii::$app->request->get('qty');
        $qty = !$qty ? 1 : $qty;
        $product = Product::findOne($id);
        if (empty($product)) return false;
        //debug($product);
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->addToCart($product, $qty);
        if (!Yii::$app->request->isAjax){
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->layout = false;
//        debug ($session['cart']);
//        debug ($session['cart.qty']);
//        debug ($session['cart.sum']);
//        exit; 
        return $this->render('cart-modal', compact('session'));
    }
    
    public function actionClear(){
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session')); 
    }
    
    public function actionDelItem(){
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session')); 
    }
    
    public function actionShow(){
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;
        
        return $this->render('cart-modal', compact('session')); 
    }
    
    public function actionView(){
        $session = Yii::$app->session;
        $session->open();
        $this->setMeta('Корзина');
        $order = new Order();
        if($order->load(Yii::$app->request->post())){
//            debug(Yii::$app->request->post());
//            exit;
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            if($order->save()){
                $this->saveOrderItems($session['cart'], $order->id);
                Yii::$app->session->setFlash('success', 'Ваш заказ принят. Менеджер Вася.');
                Yii::$app->mailer->compose('order', ['session'=>$session])// compact можно исопльзовать
                    ->setFrom(['test@mail.ru'=> ' Yii2.loc супер пупер магазин'])// после окончания тестирования сюда нужно написать корректный наш имеил
                    ->setTo($order->email)// куда мы будем отправлять письмо
                    ->setSubject('Заказ')// тема письма
                    ->send(); // и отправляем
                $session->remove('cart');
                $session->remove('cart.qty');
                $session->remove('cart.sum');
                return $this->refresh();
            }else{
                Yii::$app->session->setFlash('error', 'Что-то пошло не так .... ');
            }
        }
        return $this->render('view', compact('session', 'order'));
    }
    
    protected function saveOrderItems($items, $order_id){
        foreach ($items as $id => $item){
            $order_items = new OrderItems();
            $order_items->order_id = $order_id;
            $order_items->product_id = $id;
            $order_items->name = $item['name'];
            $order_items->price = $item['price'];
            $order_items->qty_item = $item['qty'];
            $order_items->sum_item = $item['qty']*$item['price'];
            $order_items->save();
        }
    }
}
