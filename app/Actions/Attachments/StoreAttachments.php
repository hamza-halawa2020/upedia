<?php

namespace App\Actions\Attachments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreAttachments
{
    public function handle(Model $owner, ?array $files, string $directory): void
    {
        if (!$files) { return; }
        if (!preg_match('/^[a-z-]+$/D', $directory)) { throw new \InvalidArgumentException('Invalid attachment directory.'); }
        $written = [];
        try {
            DB::transaction(function () use ($owner, $files, $directory, &$written) {
                foreach ($files as $file) {
                    if (!$file instanceof UploadedFile || !$file->isValid()) {
                        throw new \InvalidArgumentException('Invalid uploaded file.');
                    }
                    $mime = $file->getMimeType();
                    $name = Str::uuid().'.'.$file->guessExtension();
                    $path = 'uploads/'.$directory.'/'.$name;
                    $target = public_path('uploads/'.$directory);
                    if (!is_dir($target) && !mkdir($target, 0755, true) && !is_dir($target)) {
                        throw new \RuntimeException('Could not create attachment directory.');
                    }
                    $file->move($target, $name);
                    $written[] = public_path($path);
                    $owner->attachments()->create(['file_path' => $path,
                        'original_name' => basename($file->getClientOriginalName()), 'file_type' => $mime]);
                }
            });
        } catch (\Throwable $exception) {
            foreach ($written as $path) { if (is_file($path)) { unlink($path); } }
            throw $exception;
        }
    }
}
