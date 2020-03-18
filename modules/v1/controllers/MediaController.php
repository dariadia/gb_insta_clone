<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;

/**
 * Контроллер работы с media
 * не реализовывал метод для получения данных на клиен в виде json ( для реализации пагинаций, на клиенте) так как пока не ясно как отрисовка страниц будет
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
                    // restrict access to
                    'Origin' => ['http://localhost:8080', 'http://localhost:8081', 'http://localhost:8082'],
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
     * @param int $offset указатель на страницу медиа ( для пагинации если будем реализовывать )
     * @param int $limit необязательный параметр, указывает на колличество записей в ленте
     * @example
     *     const response = await fetch('http://localhost/v1/media/list?userId=1&offset=5', {
     *           method: 'GET',
     *           headers: {
     *               "Content-Type": "application/json",
     *            },
     *       });
     *     const data = await data.json()
     * @return string
     */
    public function actionList($userId, $offset = 1, $limit = self::MEDIA_PAGING_LIMIT )
{
        /* Набросок запроса для пагинаций
            $querry = (new Media())->find()
                ->where([ 'user_id' => $userId ])
                ->limit( $limit )
                ->offset( $offset )
                ->all()
        */
        return $this->asJson( /* $querry*/ []);
    }
}
