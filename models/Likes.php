<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property int $id
 * @property int $user_id
 * @property int $media_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Media $media
 * @property User $user
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'media_id'], 'required'],
            [['user_id', 'media_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['media_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Media::class,
                'targetAttribute' => ['media_id' => 'id']
            ],
            [['user_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
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
            'user_id' => 'User ID',
            'media_id' => 'Media ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Media::class, ['id' => 'media_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLike($media_id, $user_id)
    {
        return Likes::find()->where(['media_id' => $media_id])->andWhere(['user_id' => $user_id])->one() ? true : false;
    }
}
