<?php

namespace api\common\models;

use Yii;

/**
 * This is the model class for table "media_types".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Media[] $media
 */
class MediaTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::class, ['media_type_id' => 'id']);
    }
}
