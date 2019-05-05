<?php

namespace app\models;


use app\models\activeRecord\User;
use yii\helpers\ArrayHelper;
use yii\validators\InlineValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;

/**
 * Class UserModel
 * @package app\models
 *
 * @property int $id
 * @property string $username
 * @property string $password
 */
class UserModel extends User
{
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';

    public static function tableName()
    {
        return 'user';
    }

    public function scenarios()
    {
        return ArrayHelper::merge(
            [
                self::SCENARIO_LOGIN => ['username', 'password'],
                self::SCENARIO_REGISTER => ['username', 'password']
            ],
            parent::scenarios()
        );
    }

    public function rules()
    {
        return [
            [['username', 'password'], RequiredValidator::class],
            [['username', 'password'], StringValidator::class],
            [['username'], 'confirmUsername', 'on' => self::SCENARIO_LOGIN],
            [['password'], 'confirmPassword', 'on' => self::SCENARIO_LOGIN]
        ];
    }

    /**
     * @return bool
     */
    public function runLogin(): bool
    {
        $user = User::findOne(['username' => $this->username]);

        return \Yii::$app->user->login($user);
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function runRegister(): bool
    {
        $user = new User();
        $user->username = $this->username;
        $user->password = User::hashPassword($this->password);
        $user->save();

        return \Yii::$app->user->login($user);
    }

    /**
     * @param $attribute
     * @param $params
     * @param InlineValidator $validator
     */
    public function confirmUsername($attribute, $params, InlineValidator $validator): void
    {
        $user = User::findOne(['username' => $this->username]);

        if (empty($user)) {
            $validator->addError($this, $attribute, 'Invalid {attribute}.');
        }
    }

    /**
     * @param $attribute
     * @param $params
     * @param InlineValidator $validator
     */
    public function confirmPassword($attribute, $params, InlineValidator $validator): void
    {
        $user = User::findOne(['username' => $this->username]);

        if (!empty($user) && !User::validatePassword($this->{$attribute}, $user->{$attribute})) {
            $validator->addError($this, $attribute, 'Invalid {attribute}.');
        }
    }
}