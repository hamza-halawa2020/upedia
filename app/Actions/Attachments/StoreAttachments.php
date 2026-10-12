<?php

namespace App\Actions\Attachments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
                    $path = 'private-attachments/'.$directory.'/'.$name;
                    if (!Storage::disk('local')->putFileAs('private-attachments/'.$directory, $file, $name)) {
                        throw new \RuntimeException('Could not store attachment.');
                    }
                    $written[] = $path;
                    $owner->attachments()->create(['file_path' => $path,
                        'original_name' => basename($file->getClientOriginalName()), 'file_type' => $mime]);
                }
            });
        } catch (\Throwable $exception) {
            foreach ($written as $path) { Storage::disk('local')->delete($path); }
            throw $exception;
        }
    }
}
