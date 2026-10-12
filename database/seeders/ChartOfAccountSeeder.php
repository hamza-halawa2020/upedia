<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChartOfAccountSeeder extends Seeder
{
    private const ACCOUNTS = [
        ['code' => '1', 'title' => 'Assets', 'name_en' => 'Assets', 'parent_code' => null, 'account_type' => 'asset', 'account_nature' => 'debit', 'is_nature_inherited' => false, 'can_delete' => false],
        ['code' => '2', 'title' => 'Liabilities', 'name_en' => 'Liabilities', 'parent_code' => null, 'account_type' => 'liability', 'account_nature' => 'credit', 'is_nature_inherited' => false, 'can_delete' => false],
        ['code' => '3', 'title' => 'Expenses', 'name_en' => 'Expenses', 'parent_code' => null, 'account_type' => 'expense', 'account_nature' => 'debit', 'is_nature_inherited' => false, 'can_delete' => false],
        ['code' => '4', 'title' => 'Revenues', 'name_en' => 'Revenues', 'parent_code' => null, 'account_type' => 'income', 'account_nature' => 'credit', 'is_nature_inherited' => false, 'can_delete' => false],
        ['code' => '5', 'title' => 'Equity', 'name_en' => "Shareholders' equity", 'parent_code' => null, 'account_type' => 'equity', 'account_nature' => 'credit', 'is_nature_inherited' => false, 'can_delete' => false],

        ['code' => '11', 'title' => 'أصول متداولة', 'name_en' => 'Current assets', 'parent_code' => '1', 'account_type' => 'asset', 'account_nature' => 'debit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '111', 'title' => 'النقدية وما في حكمها', 'name_en' => 'Cash and cash equivalents', 'parent_code' => '11', 'account_type' => 'asset', 'account_nature' => 'debit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '1111', 'title' => 'Cash on hand', 'name_en' => 'Cash on hand', 'parent_code' => '111', 'account_type' => 'asset', 'account_nature' => 'debit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '112', 'title' => 'العملاء وأوراق القبض', 'name_en' => 'Accounts Receivable and Notes Receivable', 'parent_code' => '11', 'account_type' => 'asset', 'account_nature' => 'debit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '1121', 'title' => 'Accounts Receivable', 'name_en' => 'Clients - Account Re', 'parent_code' => '112', 'account_type' => 'asset', 'account_nature' => 'debit', 'is_nature_inherited' => true, 'can_delete' => false],

        ['code' => '21', 'title' => 'الخصوم المتداولة', 'name_en' => 'Current liabilities', 'parent_code' => '2', 'account_type' => 'liability', 'account_nature' => 'credit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '211', 'title' => 'الإيرادات المؤجلة', 'name_en' => 'Deferred revenue', 'parent_code' => '21', 'account_type' => 'liability', 'account_nature' => 'credit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '2111', 'title' => 'إيراد مؤجل للبرنامج', 'name_en' => 'Deferred Program revenue', 'parent_code' => '211', 'account_type' => 'liability', 'account_nature' => 'credit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '212', 'title' => 'مصروفات مستحقة', 'name_en' => 'Accrued Expenses', 'parent_code' => '21', 'account_type' => 'liability', 'account_nature' => 'credit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '22', 'title' => 'خصوم غير متداولة', 'name_en' => 'Non-Current Liabilities', 'parent_code' => '2', 'account_type' => 'liability', 'account_nature' => 'credit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '23', 'title' => 'Accounts Payable', 'name_en' => 'Vendors - Account Payable', 'parent_code' => '2', 'account_type' => 'liability', 'account_nature' => 'credit', 'is_nature_inherited' => false, 'can_delete' => false],

        ['code' => '31', 'title' => 'Rent Expense', 'name_en' => 'Rent Expense', 'parent_code' => '3', 'account_type' => 'expense', 'account_nature' => 'debit', 'is_nature_inherited' => false, 'can_delete' => false],
        ['code' => '32', 'title' => 'Salary Expense', 'name_en' => 'Salary Expense', 'slug' => 'salaries', 'parent_code' => '3', 'account_type' => 'expense', 'account_nature' => 'debit', 'is_nature_inherited' => true, 'can_delete' => true, 'is_system' => false],

        ['code' => '41', 'title' => 'إيرادات التشغيل', 'name_en' => 'Operating revenues', 'parent_code' => '4', 'account_type' => 'income', 'account_nature' => 'credit', 'is_nature_inherited' => true, 'can_delete' => false],
        ['code' => '42', 'title' => 'Service Revenue', 'name_en' => 'Service revenue', 'parent_code' => '4', 'account_type' => 'income', 'account_nature' => 'credit', 'is_nature_inherited' => false, 'can_delete' => false],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            foreach (self::ACCOUNTS as $account) {
                $this->upsertAccount($account);
            }
        });
    }

    private function upsertAccount(array $account): void
    {
        $now = now();
        $parentId = $account['parent_id'] ?? null;

        if (($account['parent_code'] ?? null) !== null) {
            $parentId = DB::table('chart_of_accounts')->where('code', $account['parent_code'])->value('id');
        }

        $existing = DB::table('chart_of_accounts')
            ->where('code', $account['code'])
            ->first(['id', 'slug', 'created_at']);

        $payload = [
            'code' => $account['code'],
            'title' => $account['title'],
            'name_en' => $account['name_en'],
            'slug' => $account['slug'] ?? ($existing?->slug ?: $this->makeUniqueSlug($account['title'], $account['code'])),
            'parent_id' => $parentId,
            'account_type' => $account['account_type'],
            'account_nature' => $account['account_nature'],
            'is_nature_inherited' => $account['is_nature_inherited'],
            'status' => 'Active',
            'can_delete' => $account['can_delete'],
            'is_system' => $account['is_system'] ?? true,
            'updated_at' => $now,
        ];

        if (array_key_exists('created_by', $account)) {
            $createdBy = $this->optionalUserId($account['created_by']);

            if ($createdBy !== null) {
                $payload['created_by'] = $createdBy;
            }
        }

        if ($existing) {
            DB::table('chart_of_accounts')
                ->where('id', $existing->id)
                ->update($payload);

            return;
        }

        DB::table('chart_of_accounts')->insert($payload + [
            'created_at' => $now,
        ]);
    }

    private function makeUniqueSlug(string $title, string $code): string
    {
        $baseSlug = Str::slug($title) ?: 'account';
        $slug = "{$baseSlug}-{$code}";
        $counter = 1;

        while (DB::table('chart_of_accounts')->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$code}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function optionalUserId(?int $userId): ?int
    {
        return $userId ? DB::table('users')->where('id', $userId)->value('id') : null;
    }
}
