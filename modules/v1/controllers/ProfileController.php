<?php


namespace app\modules\v1\controllers;


use app\models\Profile;
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
        $profile = $user->profile;
        $response = [
            'id' => $user->id,
            'username' => $user->username,
            'e-mail' => $user->email,
            'name' => $profile->name,
            'about' => $profile->about,
            'site' => $profile->site,
            'phone' => $profile->phone,
            'gender' => $profile->getGender(),
            'profile_photo' => $profile->profile_photo
        ];
        return print_r($response);
    }
}