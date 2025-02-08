<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $name
 * @property string $email
 * @property string $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_confirm;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'name', 'email', 'password', 'password_confirm'], 'required', 'message' => 'Поле обязательно для заполнения'],
            [['login', 'name', 'email', 'password', 'password_confirm'], 'string'],
            [['email'], 'unique', 'message' => 'Email уже используется'],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            [['password_confirm'], 'safe'],
            [['login', 'password'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 150],
            [['email'], 'string', 'max' => 50],
            [['name'], 'match', 'pattern' => '/^[А-Яа-я\s]{4,}$/u', 'message' => 'Только кириллица']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_confirm' => 'Подтверждение пароля',
            'name' => 'Имя',
            'email' => 'Email',
            'role' => 'Роль',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::find()->where(['login'=>$username])->one();
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

    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {

    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
