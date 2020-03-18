<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Контроллер работы с media
 * не реализовывал метод для получения данных на клиен в виде json ( для реализации пагинаций, на клиенте) так как пока не ясно как отрисовка страниц будет
 */
class MediaController extends Controller
{
    const MEDIA_PAGING_LIMIT = 20;

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
        if ( Yii::$app->request->isAjax ) {
            $data = \Yii::$app->request->post();
            if ( !Yii::$app->request->isPost || isset( $data['mediaId']) ) {
                throw new BadRequestHttpException();
            }
            /// ставим лайк записе которая соответвует id === $data['mediaId']
            return /* $model->update(); */ true;
        }
        return $this->redirect('/media');
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
        if ( Yii::$app->request->isAjax ) {
            /* Набросок запроса для пагинаций
                $querry = (new Media())->find()
                    ->where([ 'user_id' => $userId ])
                    ->limit( $limit )
                    ->offset( $offset )
                    ->all()
            */
            return $this->asJson( /* $querry*/ []);
        }
        return $this->redirect('/media');
    }
}
