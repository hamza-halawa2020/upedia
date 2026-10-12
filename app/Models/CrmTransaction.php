<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrmTransaction extends Model
{
    use HasFactory;
    protected $table = 'crm_transactions';
    protected $guarded = [];
    public function invoice()
    {
        return $this->belongsTo(StudentInvoice::class, 'invoice_id');
    }
}
