<?php

namespace app\modules\v1\controllers;

use app\modules\v1\controllers\_base\BaseRestController;
use app\modules\v1\models\Media;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Контроллер работы с media
 */
class MediaController extends BaseRestController
{
    const MEDIA_PAGING_LIMIT = 5;

    public $modelClass = Media::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => function() {
                $params = Yii::$app->request->queryParams;

                $query = Media::find();

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => $params['per-page'] ?? self::MEDIA_PAGING_LIMIT,
                        'page' => $params['page'] ?? 0
                    ],
                ]);

                if (!empty($params['username'])) {
                    $query->joinWith('user as u');
                    $query->andWhere(['u.username' => $params['username']]);
                } else {
                    $query->andFilterWhere([
                        'id' => $params['id'] ?? null,
                        'user_id' => $params['user_id'] ?? null,
                    ]);
                }
                return $dataProvider;
            },
        ];
        return $actions;
    }

    public function actionCreate() {
        $file = \yii\web\UploadedFile::getInstanceByName('file');
        $user = $this->getUserByAuthorizationHeader();
        if ( !$user ) {
            \Yii::$app->response->statusCode = 401;
            return null;
        }
        $model = new Media();
        $model->user_id = $user->id;
        $model->body = preg_replace( '/\.\w+/', '', $file->name );
        $model->media_type_id = 1;
        $model->filename = $file->name;
        $model->size = $file->size;
        if ( $model->save( false ) ) {
            $filePath = '../app/public/static/media/'.$file->name;
            $file->saveAs( $filePath );

             return $model->id;
        }
        \Yii::$app->response->statusCode = 400;
        return false;
    }
}
