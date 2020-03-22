<?php

namespace app\models;

use app\behaviors\TimestampTransformBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "likes".
 *
 * @property int $id
 * @property int $user_id Юзер, который поставил лайк
 * @property int $media_id Медиа, которой поставили лайк
 * @property string|null $created_at
 *
 * @property User $user
 * @property Media $media
 */
class Likes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
            TimestampTransformBehavior::class => [
                'class' => TimestampTransformBehavior::class,
                'attributes' => ['created_at'],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'media_id'], 'required'],
            [['user_id', 'media_id'], 'integer'],
            [['created_at'], 'safe'],
            [['user_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_id' => 'id']
            ],
            [['media_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Media::className(),
                'targetAttribute' => ['media_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'media_id' => 'Медиа',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }
}
