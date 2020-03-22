<?php


namespace app\modules\v1\controllers;


use app\models\Likes;
use yii\rest\ActiveController;

class LikeController extends ActiveController
{
    public $modelClass = Likes::class;

}