<?php

namespace app\modules\v1\models;

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
            'type' => function () {
                return $this->mediaType->name;
            },
            'src' => function () {
                return Url::to('/static/media/' . $this->filename);
            },
            'comments' => function () {
                return $this->comments;
            },
            'likes' => function () {
                return count($this->likes);
            }
        ];
    }
}
