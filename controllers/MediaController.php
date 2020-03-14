<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Контроллер работы с media
 * не реализовывал метод для получения данных на клиен в виде json ( для реализации пагинаций, на клиенте) так как пока не ясно как отрисовка страниц будет
*/
class MediaController extends Controller
{
    /**
     * По хорошему нужно сделать модуль User -> в него вынести меди контроллер, и будет имитация перехода на страницу
     * http://site/user/:id/media
     *
     * Получить весь медиа контент с базы
     * @return string
     **/
    public function actionIndex()
    {
        $mediaList = /* (new Media())->find()->all(); */ []; /// Заменить на получение
        return $this->render('index', [
            'mediaList' => $mediaList
        ]);
    }

    /**
     * Просмотр определенного контента - возможно это уйдет на плечи фронта
     * @param int $mediaId
     * @return string
     **/
    public function actionView( int $mediaId )
    {
        $selectedMedia = /* ( new MediaModel() )->findOne([ 'id' => $mediaId ]) */ null;

        if ( !$selectedMedia ) {
            return $this->redirect( Url::to(['site/404']) );
        }

        return $this->render('view', [
            'selectedMedia' => $selectedMedia
        ]);
    }

    /**
     * Просмотр определенного контента - возможно это уйдет на плечи фронта
     * @example
     *   const data = await fetch('http://localhost/media/like', {
     *   method: 'POST',
     *   headers: {
     *        "Content-Type": "application/json",
     *        "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content,
     *        "X-Requested-With": "XMLHttpRequest",
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
}
