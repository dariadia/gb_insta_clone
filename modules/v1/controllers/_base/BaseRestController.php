<?php

namespace app\modules\v1\controllers\_base;

use app\models\User;
use yii\filters\Cors;
use yii\rest\ActiveController;

class BaseRestController extends ActiveController
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        return array_merge($parent, [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Access-Control-Expose-Headers' => [ '*' ],
                    'Access-Control-Request-Headers' => [ '*' ],
                    'Origin' => ['*'],
                    'Allow' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'GET', 'OPTIONS'],
                ],
            ],
        ]);
    }

    /**
     * Получить пользователя по заголовкам авторизации
     * @return User|null
     **/
    protected function getUserByAuthorizationHeader() {
        $token = \Yii::$app->request->headers->get('authorization');
        $token = str_replace('Bearer', '', $token );

        return ( new User())->findIdentityByAccessToken( trim($token) );
    }
}