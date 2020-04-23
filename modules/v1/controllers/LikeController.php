<?php

namespace app\modules\v1\controllers;

use app\models\Likes;
use app\modules\v1\controllers\_base\BaseRestController;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Контроллер работы с media
 */
class LikeController extends BaseRestController
{
    public $modelClass = Likes::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['delete']);

        return $actions;
    }

    public function actionCreate() {
        $user = $this->getUserByAuthorizationHeader();
        if ( !$user ) {
            \Yii::$app->response->statusCode = 401;
            return null;
        }

        $model = new Likes();
        $model->user_id = $user->id;
        $model->media_id = (int) Yii::$app->request->post('mediaID');

        if ( $model->save() ) {
            return $model->id;
        }
        \Yii::$app->response->statusCode = 400;
        return null;
    }

    public function actionDelete() {
        $user = $this->getUserByAuthorizationHeader();
        if ( !$user ) {
            \Yii::$app->response->statusCode = 401;
            return false;
        }

        $userId = $user->id;
        $mediaId = Yii::$app->request->get('id');

        $like = Likes::find()
            ->where(['user_id' => $userId])
            ->andWhere(['media_id' => $mediaId])
            ->one();

        if ( $like && $like->delete()) return true;

        \Yii::$app->response->statusCode = 400;
        return false;
    }
}
