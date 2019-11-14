<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Description of ImageHelper
 *
 * @author Achmad Munandar
 */
class ImageHelper
{

    public static function saveStringImage($image, $fileDirectory)
    {
        if (strpos($image, 'base64') !== false) {
            return self::saveBase64Image($image, $fileDirectory);
        }
        return $image;
    }

    private static function saveBase64Image($base64, $fileDisrectory)
    {
        $base64_str = substr($base64, strpos($base64, ",") + 1);
        $decoded = base64_decode($base64_str);
        $f = finfo_open();

        $mime_type = finfo_buffer($f, $decoded, FILEINFO_MIME_TYPE);
        if (strpos($mime_type, 'image') !== FALSE) {
            $mime_type = substr($mime_type, 6);
        }
        $filename = time() . Str::random(6) . '.' . $mime_type;
        $destinationPath = storage_path("app/" . $fileDisrectory); // upload path
        File::makeDirectory($destinationPath, 0777, true, true);
        $path = $destinationPath . $filename;
        file_put_contents($path, $decoded);
        return $filename;
    }

}