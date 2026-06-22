<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class ProfileImage
{
    /**
     * Store a profile image resized for crisp display in lists and avatars.
     */
    public static function store(UploadedFile $file, string $relativeDir, int $maxDimension = 480): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $saveExt = $extension === 'jpeg' ? 'jpg' : $extension;
        $filename = time() . '.' . $saveExt;
        $dir = public_path($relativeDir);

        if (!in_array($extension, $allowed, true) || !function_exists('imagecreatetruecolor')) {
            $file->move($dir, $filename);

            return $filename;
        }

        $image = self::createImageFromFile($file->getRealPath(), $extension);
        if (!$image) {
            $file->move($dir, $filename);

            return $filename;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width <= $maxDimension && $height <= $maxDimension) {
            $file->move($dir, $filename);
            imagedestroy($image);

            return $filename;
        }

        $ratio = min($maxDimension / $width, $maxDimension / $height);
        $newW = max(1, (int) round($width * $ratio));
        $newH = max(1, (int) round($height * $ratio));

        $dest = imagecreatetruecolor($newW, $newH);
        if (in_array($extension, ['png', 'webp'], true)) {
            imagealphablending($dest, false);
            imagesavealpha($dest, true);
            $transparent = imagecolorallocatealpha($dest, 0, 0, 0, 127);
            imagefill($dest, 0, 0, $transparent);
        }

        imagecopyresampled($dest, $image, 0, 0, 0, 0, $newW, $newH, $width, $height);
        self::saveImage($dest, $dir . DIRECTORY_SEPARATOR . $filename, $extension);

        imagedestroy($image);
        imagedestroy($dest);

        return $filename;
    }

    private static function createImageFromFile(string $path, string $extension)
    {
        return match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($path),
            'png' => @imagecreatefrompng($path),
            'gif' => @imagecreatefromgif($path),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };
    }

    private static function saveImage($image, string $path, string $extension): void
    {
        match ($extension) {
            'jpg', 'jpeg' => imagejpeg($image, $path, 90),
            'png' => imagepng($image, $path, 6),
            'gif' => imagegif($image, $path),
            'webp' => function_exists('imagewebp') ? imagewebp($image, $path, 90) : imagejpeg($image, $path, 90),
            default => imagejpeg($image, $path, 90),
        };
    }
}
