<?php


namespace app\modules\v1\controllers;


use app\models\User;
use yii\web\Controller;

/**
 * Управляет пользовательским профилем, в том числе предоставляет интерфейс для изменения отдельных полей модели User
 * Class ProfileController
 * @package app\modules\v1\controllers
 */
class ProfileController extends Controller
{
    public function actionView(int $userId)
    {
        $user = User::find()->where(['id' => $userId])->one();
    }
}