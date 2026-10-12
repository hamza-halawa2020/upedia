<?php

namespace Tests\Feature;

use App\Actions\Attachments\MigrateLegacyAttachment;
use App\Models\Attachment;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LegacyAttachmentMigrationTest extends TestCase
{
    private string $publicRoot;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->publicRoot = storage_path('framework/testing/legacy-'.uniqid());
        $this->app->usePublicPath($this->publicRoot);
        File::ensureDirectoryExists(public_path('uploads/tickets'));
        File::put(public_path('uploads/tickets/legacy.pdf'), 'legacy bytes');
        Schema::create('hr_attachments', function (Blueprint $table) {
            $table->id(); $table->string('file_path'); $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->publicRoot);
        parent::tearDown();
    }

    public function test_preview_does_not_write_and_apply_preserves_original_and_bytes(): void
    {
        $attachment = Attachment::create(['file_path' => 'uploads/tickets/legacy.pdf']);
        $action = app(MigrateLegacyAttachment::class);
        $this->assertSame('eligible', $action->handle($attachment));
        $this->assertSame('uploads/tickets/legacy.pdf', $attachment->fresh()->file_path);
        $this->assertSame([], Storage::disk('local')->allFiles());
        $this->assertSame('migrated', $action->handle($attachment, true));
        $private = $attachment->fresh()->file_path;
        $this->assertStringStartsWith('private-attachments/legacy/', $private);
        $this->assertSame('legacy bytes', Storage::disk('local')->get($private));
        $this->assertFileExists(public_path('uploads/tickets/legacy.pdf'));
        $this->assertSame('skipped', $action->handle($attachment->fresh(), true));
    }

    public function test_failed_database_update_cleans_private_copy_and_keeps_original(): void
    {
        $attachment = Attachment::create(['file_path' => 'uploads/tickets/legacy.pdf']);
        DB::statement("CREATE TRIGGER block_path BEFORE UPDATE ON hr_attachments BEGIN SELECT RAISE(ABORT, 'blocked'); END");
        try {
            app(MigrateLegacyAttachment::class)->handle($attachment, true);
            $this->fail('Expected failed update.');
        } catch (\Illuminate\Database\QueryException) {
            $this->assertSame('uploads/tickets/legacy.pdf', $attachment->fresh()->file_path);
            $this->assertSame([], Storage::disk('local')->allFiles());
            $this->assertFileExists(public_path('uploads/tickets/legacy.pdf'));
        }
    }

    public function test_invalid_or_missing_paths_are_not_migrated(): void
    {
        foreach (['uploads/tickets/../secret', 'uploads/tickets/missing.pdf', 'uploads/other/legacy.pdf'] as $path) {
            $attachment = Attachment::create(['file_path' => $path]);
            $this->assertSame('invalid', app(MigrateLegacyAttachment::class)->handle($attachment, true));
        }
        $this->assertSame([], Storage::disk('local')->allFiles());
    }
}
