<?php

namespace app\modules\v1\models;

use app\models\Likes;
use yii\helpers\Url;


class Media extends \app\models\Media
{
    public function fields()
    {
        return [
            'id',
            'body',
            'metadata',
            'created_at',
            'updated_at'
        ];
    }

    public function extraFields()
    {
        return [
            'name' => function () {
                return $this->user->profile->name;
            },
            'username' => function () {
                return $this->user->username;
            },
            'type' => function () {
                return $this->mediaType->name;
            },
            'src' => function () {
                return Url::to( $this->filename );
            },
            'comments' => function () {
                return $this->comments;
            },
            'likes' => function () {
                return count($this->likes);
            },
            'like' => function () {
                $params = \Yii::$app->request->queryParams;
                $like = new Likes();
                return $like->getLike($params['id'], $this->user->id) ? true : false;
            },
            'usersLikeIt' => function () {
                return $this->usersLikeIt;
            },
        ];
    }
}
