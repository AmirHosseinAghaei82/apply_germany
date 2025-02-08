<?php

namespace App\Services;

use App\Http\Requests\Admin\AddBlogsRequest;

class HelperService
{

    public static function uploadImage($file,$path)
    {

        $fileName = uniqid() . "_" . basename($file->getClientOriginalName());

        $file->store($path, 'public');

        return $fileName;

    }

}