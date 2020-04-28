<?php


namespace app\modules\v1\controllers;


use app\models\Profile;

use app\models\User;
use app\modules\v1\controllers\_base\BaseRestController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\BaseJson;
use yii\helpers\Json;
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
            'updateProfile' => [ 'PUT', 'OPTIONS' ],
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
        $user = $this->getUserByAuthorizationHeader();
        if ( $user ) {
            return Profile::find()
                ->where(['user_id' => $user->id ])
                ->one();
        }
        \Yii::$app->response->statusCode = 404;
        return null;
    }

    public function actionUploadPhoto() {
        $file = \yii\web\UploadedFile::getInstanceByName('file');
        $user = $this->getUserByAuthorizationHeader();
        if ( !$user ) {
            \Yii::$app->response->statusCode = 401;
            return null;
        }

        $filePath = Yii::$app->params['staticPath'] . Profile::tableName() . DIRECTORY_SEPARATOR . $file->name;
        $profile = Profile::findOne([ 'user_id' => $user->id ]);
        $profile->profile_photo = $file->name;

        if ( $file->saveAs( $filePath ) && $profile->save() ) {
            return $profile;
        }

        return false;
    }

    public function actionUpdateProfile() {
        $request = Json::decode( Yii::$app->request->getRawBody() );

        $profile = Profile::findOne([ 'id' => $request[ 'id' ] ]);

        if ( !$profile ) {
            \Yii::$app->response->statusCode = 404;
            return null;
        }

        $user = $profile->user;

        $profile->name = $request['name'];
        $profile->site = $request['site'];
        $profile->about = $request['about'];

        $user->username = $request['username'];

        if ( $profile->save( ) && $user->save() ) {
            return true;
        }

        \Yii::$app->response->statusCode = 400;
        return false;
    }
}