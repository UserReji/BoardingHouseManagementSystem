<?php

namespace App\Services\Files;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoStorage
{
    public function store(?UploadedFile $file, string $directory): ?string
    {
        if (! $file) {
            return null;
        }

        return $file->store($directory, 'public');
    }

    public function replace(?UploadedFile $file, ?string $currentPath, string $directory): ?string
    {
        if (! $file) {
            return $currentPath;
        }

        $this->delete($currentPath);

        return $this->store($file, $directory);
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
