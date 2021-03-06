<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
//    public $id;  поскольку это Active record? то поля для формы будут получены автоматически
//    public $username;
//    public $password;
//    public $authKey;
//    public $accessToken;

//    private static $users = [   юзеры тоже здесь не нужны
//        '100' => [
//            'id' => '100',
//            'username' => 'admin',
//            'password' => 'admin',
//            'authKey' => 'test100key',
//            'accessToken' => '100-token',
//        ],
//        '101' => [
//            'id' => '101',
//            'username' => 'demo',
//            'password' => 'demo',
//            'authKey' => 'test101key',
//            'accessToken' => '101-token',
//        ],
//    ];


    
    public static function tableName(){
        return 'user';
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
//        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null; копируем методы из документации
        return static::findOne($id);
        
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        foreach (self::$users as $user) {  
//            if ($user['accessToken'] === $token) {
//                return new static($user);
//            }
//        }
//
//        return null;
        
//        return static::findOne(['access_token' => $token]);  нам не нужен, оставим пустым
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
//        foreach (self::$users as $user) {
//            if (strcasecmp($user['username'], $username) === 0) {
//                return new static($user);
//            }
//        }
//
//        return null;
        return static::findOne(['username' => $username]);
        
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key; // переименовываем т.к. в таблице поле называется
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
//        return $this->password === $password; // сравнивает пароль тот что в базе данных с тем что вводит пользователь
        // но мы пароль должны хешировать
        return \Yii::$app->security->validatePassword($password, $this->password);
        
    }
    
    public function generateAuthKey(){
        $this->auth_key = \Yii::$app->security->generateRandomString(); // восстановление авторизации пользователя после закрытия браузера генерируем эту куку и пишем в ячейку auth_key таблицы при успешной авторизации
    }
}
