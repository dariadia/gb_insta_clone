<?php


namespace api\modules\v1\controllers;


use api\common\models\Comment;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class CommentController extends Controller
{
    public function actionIndex(int $media_id, $limit = 10, $offset = 1)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $comments = Comment::find()->where(['media_id' => $media_id])->all();
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

}