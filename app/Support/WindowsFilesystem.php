<?php

namespace App\Support;

use Illuminate\Filesystem\Filesystem;
use RuntimeException;

class WindowsFilesystem extends Filesystem
{
    public function replace($path, $content, $mode = null)
    {
        clearstatcache(true, $path);

        $path = realpath($path) ?: $path;
        $directory = dirname($path);

        if (! $this->exists($directory)) {
            $this->makeDirectory($directory, 0777, true, true);
        }

        $tempPath = tempnam($directory, basename($path));

        if (! is_null($mode)) {
            @chmod($tempPath, $mode);
        } else {
            @chmod($tempPath, 0777 - umask());
        }

        file_put_contents($tempPath, $content);

        if ($this->exists($path)) {
            @unlink($path);
        }

        if (! @copy($tempPath, $path)) {
            @unlink($tempPath);

            throw new RuntimeException("Unable to replace file at path [{$path}].");
        }

        @unlink($tempPath);
    }
}
