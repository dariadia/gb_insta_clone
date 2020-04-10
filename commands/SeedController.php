<?php

namespace app\commands;

use app\models\Media;
use app\models\MediaTypes;
use app\models\Profile;
use app\models\User;
use Faker\Factory;
use Faker\Generator;
use yii\console\Controller;

class SeedController extends Controller
{
    /**
     * Template method
     */
    public function actionIndex()
    {
        $generator = Factory::create();

        $this->seedMediaTypes();
        $this->seedUsers($generator);
        $this->seedMedia($generator);
    }

    protected function seedMediaTypes()
    {
        $mediaType = new MediaTypes();

        $mediaType->name = 'image';
        $mediaType->save();
    }

    protected function seedUsers(Generator $generator)
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();

            $user->username = $generator->userName;
            $user->email = $generator->email;
            $user->auth_key = $generator->md5;
            $user->verification_token = $generator->md5;
            $user->password_hash = $generator->md5;
            $user->status = 10;

            if ($user->save()) {
                $profile = new Profile();

                $profile->name = $generator->name;
                $profile->about = $generator->sentence(10);
                $profile->site = $generator->domainName;
                $profile->phone = $generator->phoneNumber;
                $profile->gender_id = $generator->randomElement([1, 2]);
                $profile->user_id = $user->id;

                $profile->save();
            }
        }
    }

    protected function seedMedia(Generator $generator)
    {
        $mediaTypesIDs = array_column(
            MediaTypes::find()->select('id')->asArray()->all(),
            'id'
        );
        $usersIDs = array_column(
            User::find()->select('id')->asArray()->all(),
            'id'
        );

        $filePath = 'app/public/static/media/';
        $fileNames = [];
        foreach (glob($filePath . '*.jpg') as $filename) {
            $fileNames[] = basename($filename);
        }

        for ($i = 0; $i < 20; $i++) {
            $media = new Media();

            $media->media_type_id = $generator->randomElement($mediaTypesIDs);
            $media->user_id = $generator->randomElement($usersIDs);
            $media->body = $generator->sentence(5);
            $media->filename = $generator->randomElement($fileNames);
            $media->size = filesize($filePath . $media->filename);

            $media->save();
        }
    }
}
