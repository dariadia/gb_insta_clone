<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\Media;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

/**
 * Контроллер работы с media
 */
class MediaController extends ActiveController
{
    const MEDIA_PAGING_LIMIT = 20;

    public $modelClass = Media::class;

    public function actions()
    {
        $actions = parent::actions();
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
                        'pageSize' => self::MEDIA_PAGING_LIMIT,
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

    public function behaviors()
    {
        $parent = parent::behaviors();
        return array_merge($parent, [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    'Access-Control-Expose-Headers' => [ '*' ],
                    'Access-Control-Request-Headers' => [ '*' ],
                    // restrict access to
                    'Origin' => ['http://localhost:8080', 'http://localhost'],
                    // Allow only POST and PUT methods
//                    'Access-Control-Request-Method' => ['POST', 'PUT', 'GET'],
                    // Allow only headers 'X-Wsse'
//                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
//                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
//                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
//                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],
            ]
        ]);
    }
}
