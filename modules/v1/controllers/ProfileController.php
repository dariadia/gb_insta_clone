<?php


namespace app\modules\v1\controllers;


use app\models\Profile;
use app\models\search\ProfileSearch;
use app\models\User;
use app\modules\v1\controllers\_base\BaseRestController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\rest\IndexAction;

/**
 * Управляет пользовательским профилем, в том числе предоставляет интерфейс для изменения отдельных полей модели User
 * Class ProfileController
 * @package app\modules\v1\controllers
 */
class ProfileController extends BaseRestController
{
    public const PROFILES_PER_PAGE = 20;

    public $modelClass = Profile::class;

    protected function verbs()
    {
        return [
            'index' => [ 'GET', 'OPTIONS' ],
        ];
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index'] = [
            'class' => IndexAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],

            'prepareDataProvider' => function() {
                $params = Yii::$app->request->queryParams;

                $query = Profile::find()->joinWith('user as user');

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => $params['per-page'] ?? self::PROFILES_PER_PAGE,
                    ],
                ]);

                if (!empty($params['username'])) {
                    $query->andWhere(['user.username' => $params['username']]);
                }
                return $dataProvider;
            },
        ];
        return $actions;
    }

    /**
     * Получить профиль пользователя по токену ( Набросок, может быть изменен по необходимости )
     * @return ActiveRecord | null
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