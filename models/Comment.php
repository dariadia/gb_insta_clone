<?php

namespace app\models;

use app\behaviors\TimestampTransformBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "media".
 *
 * @property int $id
 * @property int $author_id
 * @property int $media_id
 * @property string $comment
 * @property int $created_at
 * @property User $author
 * @property int $updated_at
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id'], 'integer'],
            //[['created_at', 'updated_at'], 'required'],
            [['comment'], 'string', 'max' => 255],
            [['author_id'], 'exist',
                'skipOnError' => false,
                'targetClass' => User::class,
                'targetAttribute' => ['author_id' => 'id']
            ],
            [['media_id'], 'exist',
                'skipOnError' => false,
                'targetClass' => Media::class,
                'targetAttribute' => ['media_id' => 'id']
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
            'author_id' => 'Автор',
            'comment' => 'Комментарий',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}
