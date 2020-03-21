<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

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
 *
 * @property MediaTypes $mediaType
 * @property User $user
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
            TimestampBehavior::class => ['class' => TimestampBehavior::class]
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
}
