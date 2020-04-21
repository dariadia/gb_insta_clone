<?php


namespace app\modules\v1\controllers;

use app\models\search\UsersSearch;
use app\models\User;
use app\modules\v1\controllers\_base\BaseRestController;
use Yii;
use yii\rest\IndexAction;

/**
 * Управляет пользовательским профилем, в том числе предоставляет интерфейс для изменения отдельных полей модели User
 * Class ProfileController
 * @package app\modules\v1\controllers
 */
class UsersController extends BaseRestController
{
    public $modelClass = User::class;

    public function actions()
    {
        return array_merge( parent::actions(), [
            'search' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'checkAccess' => [ $this, 'checkAccess' ],
                'prepareDataProvider' => function() {
                    return ( new UsersSearch() )->search( Yii::$app->request->queryParams );
                },
            ]
        ]);
    }
}