<?php

namespace app\components;
use yii\base\Widget;
use app\models\Category;
use Yii;

class MenuWidget extends Widget{
    
    public $tpl;
    public $model;
    public $data; // все записи категорий из бд
    public $tree; // результат работы функции которая будет строить из обычного масиива массив дерево
    public $menuHtml; // готовый код в зависимости от того шаблона что хранится в тпл
    
    public function init(){
        parent::init();
        if($this->tpl === null){
            $this->tpl = 'menu';
        }
        $this->tpl.='.php';
    }
    
    public function run(){
        // пытаемся получить нужные данные из кеша
        if($this->tpl== 'menu.php'){ // ставим условие чтобы кушировалось только menu.php , а кешировать select.php не нужно
            $menu = Yii::$app->cache->get('menu');
            // проверяем если у нас чтото получено из кеша, то возвращаем меню
            if($menu) return $menu;
        }
        
        
        // если не получено, то формируем меню и пишем его в кеш
        $this->data = Category::find()->indexBy('id')->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        if($this->tpl== 'menu.php'){ // ставим условие чтобы кушировалось только menu.php , а кешировать select.php не нужно
            Yii::$app->cache->set('menu', $this->menuHtml, 1); // последний параметр время на которое кешируются данные
        }
        
        //debug($this->tree);
        return $this->menuHtml;
    }
    
    protected function getTree(){
        $tree = [];
        foreach ($this->data as $id=>&$node){
            if(!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
            
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = ''){ // принеимает некий параметр, наше дерево
        $str = '';
        foreach ($tree as $category){
            $str .= $this->catToTamplate($category, $tab);
        }
        return $str;
    }

    protected function catToTamplate($category, $tab){
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }

}