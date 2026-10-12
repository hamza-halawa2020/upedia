<?php

use App\Models\JournalEntry;
use App\Models\Purchase;
use App\Models\StudentInvoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('finanace_student_invoices')) {
            Schema::table('finanace_student_invoices', function (Blueprint $table) {
                $this->addColumn($table, 'string', 'source_service', ['length' => 80]);
                $this->addColumn($table, 'string', 'external_booking_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_schedule_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_student_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_course_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_course_name');
                $this->addColumn($table, 'string', 'external_student_name');
                $this->addColumn($table, 'string', 'currency', ['length' => 10, 'default' => 'EGP']);
                $this->addColumn($table, 'unsignedBigInteger', 'sessions_count');
                $this->addColumn($table, 'decimal', 'original_amount', ['total' => 15, 'places' => 2, 'default' => 0]);
                $this->addColumn($table, 'decimal', 'discount_amount', ['total' => 15, 'places' => 2, 'default' => 0]);
                $this->addColumn($table, 'decimal', 'final_amount', ['total' => 15, 'places' => 2, 'default' => 0]);
                $this->addColumn($table, 'string', 'registration_type');
                if (!Schema::hasColumn('finanace_student_invoices', 'invoice_journal_entry_id')) {
                    $table->foreignIdFor(JournalEntry::class, 'invoice_journal_entry_id')->nullable()->constrained()->nullOnDelete();
                }
                if (!Schema::hasColumn('finanace_student_invoices', 'sales_order_id')) {
                    $table->foreignIdFor(Purchase::class, 'sales_order_id')->nullable()->constrained()->nullOnDelete();
                }
                $this->addColumn($table, 'timestamp', 'cancelled_at');
                $this->addColumn($table, 'timestamp', 'voided_at');

                if (!$this->hasIndex('finanace_student_invoices', 'student_invoices_booking_unique')) {
                    $table->unique(['source_service', 'external_booking_reference'], 'student_invoices_booking_unique');
                }
            });
        }

        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                $this->addColumn($table, 'string', 'source_service', ['length' => 80]);
                $this->addColumn($table, 'string', 'external_booking_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_schedule_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_student_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_course_reference', ['length' => 120]);
                if (!Schema::hasColumn('purchases', 'student_invoice_id')) {
                    $table->foreignIdFor(StudentInvoice::class)->nullable()->constrained()->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('purchase_details')) {
            Schema::table('purchase_details', function (Blueprint $table) {
                $this->addColumn($table, 'string', 'external_booking_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_course_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_schedule_reference', ['length' => 120]);

                if (!$this->hasIndex('purchase_details', 'purchase_details_student_invoice_idx')) {
                    $table->index('student_invoice_id', 'purchase_details_student_invoice_idx');
                }
            });
        }

        if (Schema::hasTable('payments')) {
            Schema::table('payments', function (Blueprint $table) {
                $this->addColumn($table, 'string', 'source_service', ['length' => 80]);
                $this->addColumn($table, 'string', 'external_booking_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'external_transaction_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'payment_reference', ['length' => 120]);

                if (!$this->hasIndex('payments', 'payments_external_transaction_unique')) {
                    $table->unique(['source_service', 'external_transaction_reference'], 'payments_external_transaction_unique');
                }

                if (!$this->hasIndex('payments', 'payments_external_reference_unique')) {
                    $table->unique(['source_service', 'payment_reference'], 'payments_external_reference_unique');
                }
            });
        }

        if (Schema::hasTable('journal_entries')) {
            Schema::table('journal_entries', function (Blueprint $table) {
                $this->addColumn($table, 'string', 'source_service', ['length' => 80]);
                $this->addColumn($table, 'string', 'source_type', ['length' => 80]);
                $this->addColumn($table, 'string', 'source_id', ['length' => 120]);
                $this->addColumn($table, 'string', 'business_operation', ['length' => 80]);
                $this->addColumn($table, 'string', 'business_reference', ['length' => 120]);
                $this->addColumn($table, 'string', 'idempotency_key');

                if (!$this->hasIndex('journal_entries', 'journal_entries_business_unique')) {
                    $table->unique(['business_operation', 'source_service', 'business_reference'], 'journal_entries_business_unique');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('finanace_student_invoices') && $this->hasIndex('finanace_student_invoices', 'student_invoices_booking_unique')) {
            Schema::table('finanace_student_invoices', fn (Blueprint $table) => $table->dropUnique('student_invoices_booking_unique'));
        }

        if (Schema::hasTable('payments')) {
            Schema::table('payments', function (Blueprint $table) {
                if ($this->hasIndex('payments', 'payments_external_transaction_unique')) {
                    $table->dropUnique('payments_external_transaction_unique');
                }
                if ($this->hasIndex('payments', 'payments_external_reference_unique')) {
                    $table->dropUnique('payments_external_reference_unique');
                }
            });
        }

        if (Schema::hasTable('journal_entries') && $this->hasIndex('journal_entries', 'journal_entries_business_unique')) {
            Schema::table('journal_entries', fn (Blueprint $table) => $table->dropUnique('journal_entries_business_unique'));
        }

        if (Schema::hasTable('purchase_details') && $this->hasIndex('purchase_details', 'purchase_details_student_invoice_idx')) {
            Schema::table('purchase_details', fn (Blueprint $table) => $table->dropIndex('purchase_details_student_invoice_idx'));
        }

        if (Schema::hasTable('finanace_student_invoices')) {
            Schema::table('finanace_student_invoices', function (Blueprint $table) {
                foreach (['invoice_journal_entry_id', 'sales_order_id'] as $column) {
                    if (Schema::hasColumn('finanace_student_invoices', $column)) {
                        $table->dropConstrainedForeignId($column);
                    }
                }
            });
        }

        if (Schema::hasTable('purchases') && Schema::hasColumn('purchases', 'student_invoice_id')) {
            Schema::table('purchases', fn (Blueprint $table) => $table->dropConstrainedForeignId('student_invoice_id'));
        }

        $drops = [
            'finanace_student_invoices' => [
                'source_service',
                'external_booking_reference',
                'external_schedule_reference',
                'external_student_reference',
                'external_course_reference',
                'external_course_name',
                'external_student_name',
                'currency',
                'sessions_count',
                'original_amount',
                'discount_amount',
                'final_amount',
                'registration_type',
                'cancelled_at',
                'voided_at',
            ],
            'purchases' => [
                'source_service',
                'external_booking_reference',
                'external_schedule_reference',
                'external_student_reference',
                'external_course_reference',
            ],
            'purchase_details' => [
                'external_booking_reference',
                'external_course_reference',
                'external_schedule_reference',
            ],
            'payments' => [
                'source_service',
                'external_booking_reference',
                'external_transaction_reference',
                'payment_reference',
            ],
            'journal_entries' => [
                'source_service',
                'source_type',
                'source_id',
                'business_operation',
                'business_reference',
                'idempotency_key',
            ],
        ];

        foreach ($drops as $table => $columns) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table, $columns) {
                foreach ($columns as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        $blueprint->dropColumn($column);
                    }
                }
            });
        }
    }

    private function addColumn(Blueprint $table, string $type, string $name, array $options = []): void
    {
        if (Schema::hasColumn($table->getTable(), $name)) {
            return;
        }

        $column = match ($type) {
            'decimal' => $table->decimal($name, $options['total'] ?? 15, $options['places'] ?? 2),
            'string' => $table->string($name, $options['length'] ?? 255),
            'timestamp' => $table->timestamp($name),
            // 'unsignedBigInteger' => $table->unsignedBigInteger($name),
            'unsignedBigInteger' => $table->unsignedBigInteger($name),
            default => $table->{$type}($name),
        };

        if (($options['default'] ?? null) !== null) {
            $column->default($options['default']);
        }

        $column->nullable();
    }

    private function hasIndex(string $table, string $index): bool
    {
        return collect(Schema::getIndexes($table))->contains(fn (array $existing) => ($existing['name'] ?? null) === $index);
    }
};
