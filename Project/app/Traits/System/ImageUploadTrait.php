<?php

namespace App\Traits\System;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    // for multi image upload
    protected function uploadMultiImages(Request $request, $counter, $destinationPath)
    {
        $imagePaths = [];

        for ($i = 1; $i <= $counter; $i++) {
            $fieldName = 'image' . $i;
            if ($request->hasFile($fieldName)) {
                $imagePath = $this->uploadImage($request, $fieldName, $destinationPath);
                $imagePaths[$fieldName] = $imagePath;
            }
        }
        return $imagePaths;
    }
    // using this function  to upload image
    protected function uploadImage(Request $request, $imageField, $destinationPath)
    {
        if ($request->hasFile($imageField)) {

            $image = $request->file($imageField);
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($destinationPath), $imageName);
            return $destinationPath . '/' . $imageName;
        }
        return null;
    }
    // using this function  to delete function
    protected function deleteOldImage($imagePath)
    {

        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
