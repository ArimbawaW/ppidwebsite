<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HandlesFileUploads
{
    /**
     * Handle file upload and return the stored path
     *
     * @param \Illuminate\Http\UploadedFile|null $file
     * @param string $directory
     * @param string|null $oldFilePath
     * @return string|null
     */
    protected function handleFileUpload($file, string $directory, ?string $oldFilePath = null): ?string
    {
        if (!$file) {
            return null;
        }

        // Delete old file if exists
        if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
            Storage::disk('public')->delete($oldFilePath);
        }

        return $file->store($directory, 'public');
    }

    /**
     * Delete file from storage
     *
     * @param string|null $filePath
     * @return bool
     */
    protected function deleteFile(?string $filePath): bool
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }

        return false;
    }
}

