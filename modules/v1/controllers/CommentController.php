<?php


namespace app\modules\v1\controllers;


use app\models\Comment;
use app\modules\v1\controllers\_base\BaseRestController;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
use yii\web\Response;

class CommentController extends BaseRestController
{
    public $modelClass = Comment::class;


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);

        return $actions;
    }

    /**
     * Возвращает массив объектов вида:
     * [
     *  {"author_name":"John","comment":"super","comment_date":"2020-03-20 14:07:22"},
     *  {"author_name":"Peter","comment":"wow","comment_date":"2020-03-20 14:07:22"}
     * ]
     * @param int $media_id - GET параметр контента, к которому выбираются комментарии
     * @param int $limit - лимит выборки комментариев по умолчанию 10, можно передать GET параметром.
     * @param int $offset - смещение выборки
     * @return array
     */
    public function actionIndex(int $media_id, $limit = 10, $offset = 0): array
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $comments = Comment::find()->where(['media_id' => $media_id])->offset($offset)->limit($limit)->all();
        if (count($comments) === 0) {
            return [];
        }

        return ArrayHelper::toArray($comments, [
            Comment::class => [
                'author_name' => function ($comment) {
                    /* @var Comment $comment*/
                    return $comment->author->username;
                },
                'comment',
                'comment_date' => 'created_at'
            ]
        ]);
    }

    /**
     * Принимает объект комментария в виде JSON строки. JSON строка передаётся в качестве POST параметра 'comment'.
     * Объект комментария должен содержать поля media_id и 'text', т.е. {"media_id":"1","text":"Dummy comment text"}
     * @uses $_POST['comment']
     * Возвращает ответ в виде объекта {"status":"true|false"}
     *
     * @return boolean|Comment
     */
    public function actionCreate()
    {
        $user = $this->getUserByAuthorizationHeader();
        $comment = \Yii::$app->getRequest()->post('comment');

        if (!$user) {
            \Yii::$app->response->statusCode = 403;
            return false;
        }

        if ( $comment === null ) {
            \Yii::$app->response->statusCode = 400;
            return false;
        }

        $model = new Comment([
            'author_id' => $user->id,
            'media_id' => (int)\Yii::$app->getRequest()->post('mediaId'),
            'comment' => HtmlPurifier::process( $comment )
        ]);

        if ( $model->save() ) {
            return $model;
        }
        \Yii::$app->response->statusCode = 500;
        return false;
    }

    /**
     * Возвращает массив с ключом 'status' и значением true|false
     * @param bool $result
     * @return array
     */
    private function sendStatus(bool $result): array
    {
        return ['status' => $result];
    }
}