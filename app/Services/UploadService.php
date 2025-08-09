<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Services\SupabaseStorage;
use Illuminate\Http\UploadedFile;

class UploadService
{
    protected $supabase;

    public function __construct()
    {
        if (app()->environment('production')) {
            $this->supabase = new SupabaseStorage();
        }
    }

    public function upload($file, $path = '')
    {
        if (!($file instanceof UploadedFile)) {
            // bikin file sementara
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $tempPath = sys_get_temp_dir() . '/' . uniqid('upload_') . '.' . $extension;
            file_put_contents($tempPath, $file);

            // UploadedFile buat Laravel
            $file = new UploadedFile(
                $tempPath,
                basename($tempPath),
                mime_content_type($tempPath),
                null,
                true // mark as test (biar gak perlu move_uploaded_file)
            );
        }

        if (app()->environment('production')) {
            $result = $this->supabase->upload($file, $path);
            return $result['url'];
        } else {
            $path = $file->store($path, 'public');
            return Storage::url($path);
        }
    }
}
