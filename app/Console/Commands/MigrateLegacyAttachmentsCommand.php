<?php

namespace App\Console\Commands;

use App\Actions\Attachments\MigrateLegacyAttachment;
use App\Models\Attachment;
use Illuminate\Console\Command;

class MigrateLegacyAttachmentsCommand extends Command
{
    protected $signature = 'attachments:migrate-private {--apply : Copy files and update attachment paths}';

    protected $description = 'Preview or migrate legacy attachments; public originals are never removed';

    public function handle(MigrateLegacyAttachment $migrate): int
    {
        $counts = ['eligible' => 0, 'migrated' => 0, 'invalid' => 0, 'skipped' => 0, 'failed' => 0];
        Attachment::where('file_path', 'like', 'uploads/%')->chunkById(100, function ($rows) use ($migrate, &$counts) {
            foreach ($rows as $attachment) {
                try {
                    $counts[$migrate->handle($attachment, (bool) $this->option('apply'))]++;
                } catch (\Throwable $exception) {
                    report($exception);
                    $counts['failed']++;
                    $this->error('Attachment '.$attachment->id.' failed; inspect the application log.');
                }
            }
        });
        $this->table(['Result', 'Count'], collect($counts)->map(fn ($count, $result) => [$result, $count])->values()->all());
        $this->warn('Public originals remain accessible. Disable public serving of migrated upload directories after verifying backups and all consumers.');

        return $counts['failed'] || $counts['invalid'] ? self::FAILURE : self::SUCCESS;
    }
}
