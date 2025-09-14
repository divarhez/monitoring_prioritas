<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class FileHelper
{
    /**
     * Upload a file to the specified path.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @return string|null
     */
    public static function upload(UploadedFile $file, string $path): ?string
    {
        if ($file->isValid()) {
            return $file->store($path, 'public');
        }

        return null;
    }
}
