<?php

namespace App\Services;

use App\Http\Requests\Admin\AddBlogsRequest;
use Illuminate\Support\Facades\Storage;

class HelperService
{

    public static function uploadImage($file,$path)
    {


        $fileName = uniqid() . "_" . basename($file->getClientOriginalName());

        $file->storeAs($path, $fileName, 'public');

        return $fileName;

    }

    public static function deleteImage($oldImage, $path)
    {

        $fullPath  = $path. "/" . $oldImage;

        if(Storage::disk('public')->exists($fullPath)) {

            Storage::disk('public')->delete($fullPath);

        }

        

    }

}