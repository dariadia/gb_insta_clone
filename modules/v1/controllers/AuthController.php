<?php

namespace app\modules\v1\controllers;

use app\models\Profile;
use app\models\SignupForm;
use app\modules\v1\controllers\_base\BaseRestController;
use yii\filters\Cors;

use app\models\User;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class AuthController extends BaseRestController
{
    public $modelClass = User::class;
    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'signup' => [ 'POST', 'OPTIONS' ],
            'login' => [ 'POST', 'OPTIONS' ],
        ];
    }

    public function actionLogin()
    {
        $loginData = \Yii::$app->request->post( 'auth');
        if ( !$loginData ) {
            throw new BadRequestHttpException();
        }
        $base64String = base64_decode( $loginData );
        $loginData = explode( ':', $base64String );
        $model = ( new User() )->findOne(['username' => $loginData[ 0 ]]);

        if ( $model && \Yii::$app->security->validatePassword( $loginData[ 1 ], $model->password_hash) ) {
            return $model->authKey;
        }
        \Yii::$app->response->statusCode = 400;
        return null;
    }

    
    public function actionSignup()
    {
        $formValues = json_decode( \Yii::$app->request->getRawBody() );
        $model = new SignupForm();
        $model->email = $formValues->email ?? null;
        $model->username = $formValues->username ?? null;
        $model->password = $formValues->password ?? null;
        $model->password_repeat = $formValues->passwordRepeat ?? null;

        return $model->signup();
    }
}