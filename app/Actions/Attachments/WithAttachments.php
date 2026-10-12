<?php

namespace App\Actions\Attachments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WithAttachments
{
    public function __construct(private readonly StoreAttachments $store) {}

    public function handle(?array $files, string $directory, callable $save): Model
    {
        return DB::transaction(function () use ($files, $directory, $save) {
            $owner = $save();
            $this->store->handle($owner, $files, $directory);

            return $owner;
        });
    }
}
