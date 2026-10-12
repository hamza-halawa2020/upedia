<?php

namespace Tests\Feature;

use App\Actions\Attachments\StoreAttachments;
use App\Actions\Attachments\WithAttachments;
use App\Models\Ticket;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SharedAttachmentsTest extends TestCase
{
    private string $directory;
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        $this->directory = storage_path('framework/testing/attachment-'.uniqid());
        $this->app->usePublicPath($this->directory);
        Schema::create('tickets', function (Blueprint $t) { $t->id(); $t->string('title'); $t->timestamps(); });
        Schema::create('hr_attachments', function (Blueprint $t) {
            $t->id(); $t->integer('model_id'); $t->string('model_type'); $t->string('file_path');
            $t->string('original_name'); $t->string('file_type'); $t->timestamps();
        });
    }
    protected function tearDown(): void
    {
        File::deleteDirectory($this->directory);
        parent::tearDown();
    }
    public function test_upload_names_do_not_collide_and_preserve_metadata(): void
    {
        $ticket = Ticket::create(['title' => 'Issue']);
        app(StoreAttachments::class)->handle($ticket, [UploadedFile::fake()->image('same.png'), UploadedFile::fake()->image('same.png')], 'tickets');
        $attachments = $ticket->attachments()->get();
        $this->assertCount(2, $attachments);
        $this->assertNotSame($attachments[0]->file_path, $attachments[1]->file_path);
        foreach ($attachments as $attachment) {
            $this->assertSame('same.png', $attachment->original_name);
            $this->assertFileExists(public_path($attachment->file_path));
        }
    }
    public function test_database_failure_cleans_files_and_rolls_back_owner(): void
    {
        DB::statement("CREATE TRIGGER block_attachment BEFORE INSERT ON hr_attachments BEGIN SELECT RAISE(ABORT, 'blocked'); END");
        try {
            app(WithAttachments::class)->handle([UploadedFile::fake()->image('upload.png')], 'tickets',
                fn () => Ticket::create(['title' => 'Issue']));
            $this->fail('Expected failed attachment write');
        } catch (QueryException) {
            $this->assertDatabaseCount('tickets', 0);
            $this->assertDatabaseCount('hr_attachments', 0);
            $this->assertCount(0, File::files(public_path('uploads/tickets')));
        }
    }

    public function test_solution_upload_keeps_department_links_and_appends_files(): void
    {
        Schema::create('it_solutions', function (Blueprint $t) {
            $t->id(); $t->string('title'); $t->string('topic_name'); $t->text('description');
            $t->string('visibility'); $t->timestamps();
        });
        Schema::create('it_solution_sm_human_department', function (Blueprint $t) {
            $t->integer('it_solution_id'); $t->integer('sm_human_department_id');
        });
        $department = \App\Models\SmHumanDepartment::create(['name' => 'IT']);
        $data = ['title' => 'Guide', 'topic_name' => 'Topic', 'description' => 'Content',
            'visibility' => 'departments', 'department_ids' => [$department->id],
            'attachments' => [UploadedFile::fake()->image('one.png')]];
        $save = app(\Modules\IT\Solutions\Actions\SaveSolution::class);
        $solution = $save->handle($data);
        $this->assertSame([$department->id], $solution->departments->pluck('id')->all());
        $this->assertCount(1, $solution->attachments()->get());
        $data['attachments'] = [UploadedFile::fake()->image('two.png')];
        $save->handle($data, $solution->id);
        $this->assertCount(2, $solution->attachments()->get());
    }
}
