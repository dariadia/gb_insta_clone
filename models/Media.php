<?php

namespace app\models;

use app\behaviors\TimestampTransformBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property int|null $media_type_id
 * @property int|null $user_id
 * @property string|null $body
 * @property string|null $filename Прикрепленный файл
 * @property int|null $size
 * @property string|null $metadata Сериализованные данные либо json
 * @property int $created_at
 * @property int $updated_at
 * @property MediaTypes $mediaType
 * @property User $user
 * @property Comment[] $comments
 * @property Likes[] $likes
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['media_type_id', 'user_id', 'size', 'created_at', 'updated_at'], 'integer'],
            [['body', 'metadata'], 'string'],
            [['created_at', 'updated_at'], 'required'],
            [['filename'], 'string', 'max' => 255],
            [['media_type_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => MediaTypes::class,
                'targetAttribute' => ['media_type_id' => 'id']
            ],
            [['user_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            TimestampTransformBehavior::class => [
                'class' => TimestampTransformBehavior::class,
                'attributes' => ['created_at', 'updated_at'],
                ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'media_type_id' => 'Media Type ID',
            'user_id' => 'User ID',
            'body' => 'Body',
            'filename' => 'Filename',
            'size' => 'Size',
            'metadata' => 'Metadata',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[MediaType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMediaType()
    {
        return $this->hasOne(MediaTypes::class, ['id' => 'media_type_id']);
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

    /**
     * Gets query for [[Comment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['media_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Likes::class, ['media_id' => 'id']);
    }

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
            'username' => function () {
                return $this->user->username;
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
