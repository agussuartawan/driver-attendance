<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupabaseStorage
{
    protected $url;
    protected $anonKey;
    protected $bucket;

    public function __construct()
    {
        $this->url = config('supabase.url') . '/storage/v1/object';
        $this->anonKey = config('supabase.service_key') ?: config('supabase.anon_key');
        $this->bucket = config('supabase.storage_bucket');
    }

    public function upload($file, $path = '')
    {
        $filename = ($path ? rtrim($path, '/') . '/' : '') . Str::random(20) . '.' . $file->getClientOriginalExtension();

        $response = Http::withHeaders([
            'apikey' => $this->anonKey,
            'Authorization' => 'Bearer ' . $this->anonKey,
            'Content-Type' => $file->getMimeType(),
        ])->withBody(fopen($file->getRealPath(), 'r'), $file->getMimeType())
            ->put("{$this->url}/{$this->bucket}/{$filename}");

        if ($response->successful()) {
            return [
                'path' => $filename,
                'url' => config('supabase.url') . "/storage/v1/object/public/{$this->bucket}/{$filename}"
            ];
        }

        throw new \Exception('Upload gagal: ' . $response->body());
    }

    public function delete($path)
    {
        $response = Http::withHeaders([
            'apikey' => $this->anonKey,
            'Authorization' => 'Bearer ' . $this->anonKey,
        ])->delete("{$this->url}/{$this->bucket}/{$path}");

        return $response->successful();
    }
}
