<?php

namespace App\Actions\Attachments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteAttachments
{
    public function __construct(private readonly AttachmentPath $paths) {}
    public function handle(Model $owner, ?int $id = null): void
    {
        DB::transaction(function () use ($owner, $id) {
            $query = $owner->attachments();
            if ($id !== null) { $query->whereKey($id); }
            $attachments = $query->lockForUpdate()->get();
            $files = $attachments->map(fn ($file) => $this->paths->handle($file))->filter()->unique()->all();
            if ($attachments->isNotEmpty()) { $owner->attachments()->whereKey($attachments->modelKeys())->delete(); }
            DB::afterCommit(function () use ($files) {
                foreach ($files as $path) {
                    if (is_file($path) && !@unlink($path)) { Log::warning('Attachment cleanup failed', ['path' => $path]); }
                }
            });
        });
    }
}
