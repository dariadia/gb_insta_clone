<?php


namespace app\modules\v1\controllers;


use app\models\Profile;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\rest\IndexAction;

/**
 * Управляет пользовательским профилем, в том числе предоставляет интерфейс для изменения отдельных полей модели User
 * Class ProfileController
 * @package app\modules\v1\controllers
 */
class ProfileController extends ActiveController
{
    public const PROFILES_PER_PAGE = 20;

    public $modelClass = Profile::class;

    public function behaviors()
    {
        $parent = parent::behaviors();
        return array_merge($parent, [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Access-Control-Expose-Headers' => [ '*' ],
                    'Access-Control-Request-Headers' => [ '*' ],
                    'Origin' => ['http://localhost:8080', 'http://localhost'],
                    'Allow' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'GET', 'OPTIONS'],
                ],
            ],
        ]);
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index'] = [
            'class' => IndexAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],

            'prepareDataProvider' => function() {
                $query = Profile::find()->joinWith('user as user');

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => Yii::$app->request->get('per-page', static::PROFILES_PER_PAGE),
                    ],
                ]);
                return $dataProvider;
            },
        ];
        return $actions;
    }

    /**
     * Получить профиль пользователя ( Набросок, может быть изменен по необходимости )
     * !ВНИМАНИЕ! пользователи в статусе 9 не смогут пройти аутентефикацию по токену, установить им 10
     * @todo сделать механизм активации пользователя
     * @return Profile
     **/
    public function actionGet() {
        /** временная мера, пока отключаем тут поведение, потом чтото другое придумаем */
        $token = Yii::$app->request->headers->get('authorization');
        $token = str_replace('Bearer', '', $token );
        $user = ( new User())->findIdentityByAccessToken( trim($token) );

        if ( $user ) {
            return Profile::find()
                ->where(['user_id' => $user->id ])
                ->one();
        }
        \Yii::$app->response->statusCode = 404;
        return null;
    }
}