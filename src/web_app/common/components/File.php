<?php

namespace common\components;

class File
{
    public static function rrmdir(string $directory): bool
    {
        array_map(fn (string $file) => is_dir($file) ? File::rrmdir($file) : unlink($file), glob($directory . '/' . '*'));

        return rmdir($directory);
    }
}