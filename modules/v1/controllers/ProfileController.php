<?php


namespace app\modules\v1\controllers;


use app\models\Profile;
use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\rest\IndexAction;

/**
 * Управляет пользовательским профилем, в том числе предоставляет интерфейс для изменения отдельных полей модели User
 * Class ProfileController
 * @package app\modules\v1\controllers
 */
class ProfileController extends ActiveController
{
    public const PROFILES_PER_PAGE = 20;

    public $modelClass = Profile::class;

    public function actions()
    {
        $actions = parent::actions();

        $actions['index'] = [
            'class' => IndexAction::class,
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],

            'prepareDataProvider' => function() {
                $query = Profile::find()->joinWith('user as user');

                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => Yii::$app->request->get('per-page', static::PROFILES_PER_PAGE),
                    ],
                ]);
                return $dataProvider;
            },
        ];
        return $actions;
    }
}