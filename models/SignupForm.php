<?php
namespace app\models;

use Cassandra\Exception\ValidationException;
use Yii;
use yii\base\Model;
use yii\db\Exception;

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
     * Регистрация пользователя
     * @return array
     **/
    public function signup()
    {
        try {
            if ( !$this->validate() ) {
                throw new \Exception();
            }
            $user = $this->saveUser();
            $this->saveProfile( $user->id );
//          $this->sendEmail( $user ); временно отключил
            Yii::$app->response->statusCode = 200;
            return [ 'token' => $user->authKey ];
        } catch (\Exception $ex ) {
            Yii::$app->response->statusCode = 400;
            return [ 'errors' => $this->getErrors() ];
        }
    }

    /**
     * Сохранение данных о пользователе
     * @return User
     * @throws \Exception
     **/
    private function saveUser() {
        $user = new User();
        $user->email = $this->email;
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = 10; /// временно отключил проверку по почте, и активация происходит автоматом

        if ( !$user->save() ) {
            throw new \Exception();
        }
        return $user;
    }

    /**
     * Сохранение данных о профиле
     * @param int $userId
     * @return void
     * @throws \Exception
     **/
    private function saveProfile( $userId ) {
        $profile = new Profile(['user_id' => $userId ]);
        $profile->save(false);
        if ( !$profile ) {
            throw new \Exception();
        }
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
