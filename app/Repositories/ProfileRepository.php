<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Profile;
use App\Models\Image;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Http\Traits\UploadImageTrait;

class ProfileRepository implements ProfileRepositoryInterface
{
    use UploadImageTrait;

    protected $model;

    public function __construct(Profile $profile)
    {
        $this->model = $profile;
    }

    public function update($profileRequest, $id)
    {
        $user = User::find($id)->update([
            'first_name' => $profileRequest->first_name,
            'last_name' => $profileRequest->last_name,
            'email' => $profileRequest->email
        ]);
        
        $profile = Profile::updateOrCreate(
            ['user_id' => $id],
            [
            'birhdate' => $profileRequest->birhdate,
            'phone' => $profileRequest->phone,
            'city' => $profileRequest->city
            ]
        );
        $photo = $profile && $profile->image ? $profile->image->image_name : '';
       
        if ($profileRequest->hasFile('avatar')) {
            $photo = $this->uploadImage($profileRequest->avatar, 'avatar');
        }
        if ($profile->image) {
            $profile->image()->delete();
        }
        $image = new Image;
        $image->image_name = $photo;
        
        $profile->image()->save($image);
    }
}
