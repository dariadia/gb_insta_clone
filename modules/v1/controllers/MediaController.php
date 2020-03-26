<?php

namespace app\modules\v1\controllers;

use app\models\Media;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;

/**
 * Контроллер работы с media
 */
class MediaController extends ActiveController
{
    const MEDIA_PAGING_LIMIT = 20;

    public $modelClass = \app\models\Media::class;

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

    /**
     * Имитация возможности поставить лайк, через асинхронный запрос
     * @method POST
     * @example
     *   const data = await fetch('http://localhost/v1/media/like', {
     *   method: 'POST',
     *   headers: {
     *        "Content-Type": "application/json",
     *    },
     *    body: JSON.stringify({
     *        mediaId: 1
     *    })
     * })
     * let json = await data.json(); /// собриаем тело запроса
     *
     * @throws BadRequestHttpException
     */
    public function actionLike()
    {
        $data = \Yii::$app->request->post();
        if ( !Yii::$app->request->isPost || isset( $data['mediaId']) ) {
            throw new BadRequestHttpException();
        }
        /// ставим лайк записе которая соответвует id === $data['mediaId']
        return /* $model->update(); */ true;
        return false;
    }

    /**
     * Получить весь список Media ( данный метод будет расширен, для получение списка для конкретного пользователя
     *  и пагинаций
     * )
     * @method GET
     * @param int $userId пользователь медиа ленту которого запрашиваем
     * @param int $page указатель на страницу медиа ( для пагинации если будем реализовывать )
     * @param int $limit необязательный параметр, указывает на колличество записей в ленте
     * @example
     *     const response = await fetch('http://localhost/v1/media/list?userId=1&offset=0', {
     *           method: 'GET',
     *           headers: {
     *               "Content-Type": "application/json",
     *            },
     *       });
     *     const data = await data.json()
     * @return string
     */
    public function actionList( $userId, $page = 0, $limit = self::MEDIA_PAGING_LIMIT )
    {
        return new ActiveDataProvider([
            'query' => Media::find()->where(['user_id' => $userId]),
            'pagination' => [
                'pageSize' => $limit,
                'page' => $page
            ],
            'sort' => [
                'defaultOrder' => [
                    'body' => SORT_DESC,
                ]
            ]
        ]);
    }
}
