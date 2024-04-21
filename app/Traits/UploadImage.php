<?php

namespace App\Traits;

trait UploadImage
{
    public function uploadImageF($folder, $image, $user)
    {
        $url = $image->storeAs(
            "$folder",
            'admin' . $user->id . '_' . $image->getClientOriginalName(),
        );
        return $url;
    }
}
