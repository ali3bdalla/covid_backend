<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPhotoRequest;
use Illuminate\Support\Facades\Storage;

use BigV\ImageCompare;


class UploaderController extends Controller
{

    public function __invoke(UploadPhotoRequest $request)
    {
        $business_logo = $request->file('photo')->store(
            'uploads', 'public'
        );

        $path = $this->getImageFullPath($business_logo);
//        return $business_logo;

        $response = [];
        $compObj = new ImageCompare();
        $counter = 0;
        foreach (config('images') as $image) {
            $value = $compObj->compare($path, $this->getImageFullPath($image));
            $response[] = [
                'image' => Storage::url($image),
                "value" => $value
            ];

            if ($value == 0)
                $counter++;
        }
        return [
            'match' => $counter,
            'data' => $response,
        ];
    }


    public function getImageFullPath($path)
    {
        return storage_path("app/public/" . $path);
    }

}
