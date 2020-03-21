<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $username;
    public $password;
    public $password_repeat;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Пользователь с таким e-mail уже существует'],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'max' => 30],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Пользователь с таким именем уже существует'],

            ['password', 'trim'],
            ['password', 'required'],
            ['password', 'string', 'max' => 30],

            ['password_repeat', 'trim'],
            ['password_repeat', 'required'],
            ['password_repeat', 'string', 'max' => 30],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>'Пароли не совпадают']
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws \yii\base\Exception
     */
    public function signup(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = new User();
        $user->email = $this->email;
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $isSaved = $user->save();

        if ($isSaved) {
            $this->sendEmail($user);
        }
        return $isSaved;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Регистрация на ' . Yii::$app->name)
            ->send();
    }
}
