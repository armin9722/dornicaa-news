<?php

namespace App\Services;

use App\Models\File;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class FileUploadService
{
    /**
     * Upload an image file and create a database record
     *
     * @param UploadedFile $file
     * @param string $folder The folder to store the file in (e.g., 'avatars', 'posts', 'categories')
     * @param int|null $width Optional width to resize image (default: null, no resize)
     * @param int|null $height Optional height to resize image (default: null, no resize)
     * @return File|null
     * @throws Exception
     */
    public static function uploadImage(UploadedFile $file, string $folder = 'uploads', ?int $width = null, ?int $height = null): ?File
    {
        try {
            // Validate file
            if (!$file->isValid()) {
                throw new Exception('فایل معتبر نیست');
            }

            // Create unique filename
            $filename = time() . '_' . uniqid() . '.jpg';
            $storagePath = $folder . '/' . $filename;
            $fullPath = storage_path('app/public/' . $storagePath);

            // Ensure directory exists
            $directory = dirname($fullPath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Create image and resize if dimensions are specified
            $image = Image::read($file);
            if ($width && $height) {
                $image = $image->cover($width, $height);
            }

            // Save image as JPEG
            $image->save($fullPath, 90, 'jpg');

            // Get file size after processing
            $fileSize = filesize($fullPath);

            // Create file record in database
            $fileRecord = File::create([
                'name' => $file->getClientOriginalName(),
                'extension' => 'jpg',
                'size' => $fileSize,
                'path' => $storagePath,
            ]);

            if (!$fileRecord || !$fileRecord->id) {
                // If database record creation fails, delete the stored file
                @unlink($fullPath);
                Log::error('Failed to create file record in database');
                throw new Exception('خطا در ثبت اطلاعات فایل در پایگاه داده');
            }

            return $fileRecord;
        } catch (Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            Log::error($e);
            throw $e;
        }
    }

    /**
     * Delete a file and its database record
     *
     * @param File $file
     * @return bool
     */
    public static function deleteFile(File $file): bool
    {
        try {
            // Delete from storage
            if (Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }

            // Delete from database
            return $file->delete();
        } catch (Exception $e) {
            Log::error('File deletion error: ' . $e->getMessage());
            return false;
        }
    }
}

