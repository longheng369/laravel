<?php

namespace App\FileService;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function deleteFile($filename)
    {
        // Check if the file exists
        if (Storage::exists('public' . $filename)) {
            // Delete the file
            Storage::delete('public' . $filename);
            return 'File deleted successfully';
        } else {
            return 'File not found';
        }
    }
}
