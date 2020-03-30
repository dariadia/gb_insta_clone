<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $about
 * @property string|null $site
 * @property string|null $phone
 * @property int|null $gender_id
 * @property string|null $profile_photo
 * @property int|null $user_id
 *
 * @property array $genders
 * @property string $gender
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_UNKNOWN = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender_id', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['about', 'site'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 30],
            [['profile_photo'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'about' => 'About',
            'site' => 'Site',
            'phone' => 'Phone',
            'gender_id' => 'Gender ID',
            'profile_photo' => 'Profile Photo',
            'user_id' => 'User ID',
            'gender' => 'Пол',
        ];
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
     * Возвращает массив с названиями пола
     * @return array
     */
    public function getGenders(): array
    {
        // TODO: Подумать о мультиязычной поддержке
        return [
            self::GENDER_UNKNOWN => 'Не указан',
            self::GENDER_MALE => 'Мужской',
            self::GENDER_FEMALE => 'Женский',
        ];
    }

    /**
     * Возвращает пол пользователя
     * @return string
     */
    public function getGender(): string
    {
        return $this->getGenders()[$this->gender_id];
    }
}
