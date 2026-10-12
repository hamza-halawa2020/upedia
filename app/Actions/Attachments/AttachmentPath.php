<?php

namespace App\Actions\Attachments;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class AttachmentPath
{
    public function handle(Attachment $attachment): ?string
    {
        $relative = (string) $attachment->file_path;
        if (str_contains($relative, '..') || str_contains($relative, '\\')) { return null; }
        if (preg_match('#^private-attachments/[a-z-]+/[a-zA-Z0-9_.-]+$#D', $relative)) {
            $root = realpath(Storage::disk('local')->path('private-attachments'));
            $path = realpath(Storage::disk('local')->path($relative));
        } elseif (preg_match('#^uploads/(scripts|marketing-plans|complains|solutions|tickets|purchases)/[^/]+$#D', $relative)) {
            $root = realpath(public_path('uploads'));
            $path = realpath(public_path($relative));
        } else { return null; }
        return $root && $path && is_file($path) && str_starts_with($path, $root.DIRECTORY_SEPARATOR) ? $path : null;
    }
}
