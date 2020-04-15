<?php

namespace app\modules\v1\controllers;

use yii\filters\Cors;

use app\models\User;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;

class AuthController extends ActiveController
{
    public $modelClass = User::class;
    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'login' => ['POST', 'OPTIONS'],
        ];
    }

    public function behaviors()
    {
        $parent = parent::behaviors();
        return array_merge($parent, [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Expose-Headers' => [ '*' ],
                    'Access-Control-Request-Headers' => [ '*' ],
                    'Access-Control-Allow-Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'GET', 'OPTIONS'],
                ],
            ]
        ]);
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

        if ( $model && \Yii::$app->security->validatePassword( $loginData[ 1 ], $model->password_hash ) ) {
            return $model->authKey;
        }
        return $model;
    }
}