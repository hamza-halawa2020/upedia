<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TreasuryTransaction extends Model
{
    use HasFactory;

    protected $table = 'treasury_transactions';

    protected $fillable = [
        'treasury_id',
        'journal_entry_id',
        'amount',
        'direction',
        'balance_after',
        'description',
        'party_type',
        'party_id',
        'party_name',
        'party_ref',
    ];

    public function treasury()
    {
        return $this->belongsTo(Treasury::class, 'treasury_id');
    }

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    }
}
