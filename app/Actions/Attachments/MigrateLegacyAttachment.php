<?php

namespace App\Actions\Attachments;

use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateLegacyAttachment
{
    public function __construct(private readonly AttachmentPath $paths) {}

    public function handle(Attachment $attachment, bool $apply = false): string
    {
        if (! str_starts_with((string) $attachment->file_path, 'uploads/')) {
            return 'skipped';
        }
        if (! $this->paths->handle($attachment)) {
            return 'invalid';
        }
        if (! $apply) {
            return 'eligible';
        }
        if (DB::transactionLevel() !== 0) {
            throw new \LogicException('Legacy migration must own its transaction.');
        }
        $written = null;
        try {
            return DB::transaction(function () use ($attachment, &$written) {
                $locked = Attachment::lockForUpdate()->findOrFail($attachment->id);
                if ($locked->file_path !== $attachment->file_path) {
                    return 'skipped';
                }
                $source = $this->paths->handle($locked);
                if (! $source) {
                    return 'invalid';
                }
                $extension = pathinfo($source, PATHINFO_EXTENSION);
                $suffix = preg_match('/^[a-zA-Z0-9]{1,10}$/D', $extension) ? '.'.$extension : '';
                $written = 'private-attachments/legacy/'.Str::uuid().$suffix;
                $stream = fopen($source, 'rb');
                if ($stream === false) {
                    throw new \RuntimeException('Cannot read legacy attachment.');
                }
                try {
                    if (! Storage::disk('local')->put($written, $stream)) {
                        throw new \RuntimeException('Cannot copy legacy attachment.');
                    }
                } finally {
                    fclose($stream);
                }
                $copy = Storage::disk('local')->path($written);
                if (hash_file('sha256', $source) !== hash_file('sha256', $copy)) {
                    throw new \RuntimeException('Legacy attachment checksum mismatch.');
                }
                $locked->update(['file_path' => $written]);

                return 'migrated';
            });
        } catch (\Throwable $exception) {
            if ($written) {
                Storage::disk('local')->delete($written);
            }
            throw $exception;
        }
    }
}
