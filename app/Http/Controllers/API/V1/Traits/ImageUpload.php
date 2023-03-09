<?php

namespace App\Http\Controllers\API\V1\Traits;

trait ImageUpload
{
    public function uploadImage($request, $key, $path)
    {
        $img = $request->file($key);

        $stored_img_name = explode('.', $img->getClientOriginalName())[0] . '-' . time() . '-' .
            $img->getClientOriginalExtension() . '.' . $img->getClientOriginalExtension();

        $request->file($key)->storeAs($path, $stored_img_name);

        return $stored_img_name;
    }

    public function uploadCarouselImages($img, $path)
    {
        $stored_img_name = explode('.', $img->getClientOriginalName())[0] . '-' . time() . '-' .
            $img->getClientOriginalExtension() . '.' . $img->getClientOriginalExtension();

        $img->storeAs($path, $stored_img_name);

        return $stored_img_name;
    }
}
