<?php

namespace App\Http\Traits;

use Intervention\Image\Facades\Image as ImageInt;
use Storage;

trait UploadImageTrait
{
    public function uploadImage($requestFile, $folder)
    {
        $img = ImageInt::make($requestFile)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        $extension = $requestFile->extension();
        $imgName = str_random(20).'.'.$extension;
        $img->stream();
        Storage::disk('public')->put($folder.'/'.$imgName, $img);
        return $imgName;
    }
}
