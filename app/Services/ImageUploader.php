<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class ImageUploader extends Model
{
    /**
     * Upload and optionally crop an image file.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $filename
     * @param array|null $resizeDimensions [width, height]
     * @return string relative path of the saved image
     */
    public static function uploadSingleImage(
        UploadedFile $file,
        string $directory,
        ?string $filename = null,
        ?array $resizeDimensions = null
    ): string {
        // Sanitize directory (remove trailing slash)
        $directory = rtrim($directory, '/');

        // Get file extension
        $extension = $file->getClientOriginalExtension();

        // Extract base filename (no extension)
        if (!$filename) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        } else {
            $filenameInfo = pathinfo($filename);
            if (!isset($filenameInfo['extension'])) {
                $filename .= '.' . $extension;
            }
        }

        $uniqueFilename = uniqid() . '-' . $filename;

        // Create directory if not exist
        if (!file_exists(public_path($directory))) {
            mkdir(public_path($directory), 0775, true);
        }

        $fullPath = public_path($directory . '/' . $uniqueFilename);

        $manager = new ImageManager(new GdDriver());
        $image = $manager->read($file->getRealPath());

        if ($resizeDimensions && count($resizeDimensions) === 2) {
            [$width, $height] = $resizeDimensions;
            $image = $image->cover($width, $height);
        }

        $image->save($fullPath);

        return $directory . '/' . $uniqueFilename;
    }

    /**
     * Upload multiple image files to the specified directory with custom names.
     *
     * @param array $files An array of uploaded image files.
     * @param string $directory The directory where the image files should be saved.
     * @param array|null $filenames An array of custom names to give to the image files (optional).
     * @return array An array of paths to the uploaded image files.
     */
    public static function uploadMultipleImages(array $files, string $directory, ?array $filenames = null): array
    {
        $paths = [];

        // Use original filenames if custom filenames are not provided
        if ($filenames === null) {
            $filenames = array_map(fn($file) => $file->getClientOriginalName(), $files);
        }

        foreach ($files as $index => $file) {
            $filename = $filenames[$index] ?? $file->getClientOriginalName();
            $uniqueFilename = uniqid() . '-' . $filename;
            $extension = $file->getClientOriginalExtension();

            $path = $file->move(public_path($directory), $uniqueFilename . '.' . $extension);

            $paths[] = $directory . '/' . $uniqueFilename . '.' . $extension;
        }

        return $paths;
    }
}
