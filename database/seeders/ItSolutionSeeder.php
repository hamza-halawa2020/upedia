<?php

namespace Database\Seeders;

use App\Models\ItSolution;
use App\Models\SmHumanDepartment;
use Illuminate\Database\Seeder;

class ItSolutionSeeder extends Seeder
{
    public function run(): void
    {
        $solutions = [
            [
                'title' => 'How to Reset Your VPN Password',
                'topic_name' => 'VPN & Connectivity',
                'description' => "To reset your VPN password, please follow these steps:\n1. Open the VPN client.\n2. Click on 'Forgot Password'.\n3. Enter your corporate email.\n4. Follow the instructions sent to your inbox.\n\nNote: Password must be at least 12 characters long.",
                'keywords' => 'vpn, password, reset, login',
                'visibility' => 'all',
            ],
            [
                'title' => 'Connecting to the Office Printer',
                'topic_name' => 'Printers & Hardware',
                'description' => "1. Go to Settings > Devices.\n2. Click 'Add printer or scanner'.\n3. Select 'HP-Office-Main' from the list.\n4. Use your employee ID for authentication if prompted.",
                'keywords' => 'printer, hp, canon, scan, copy',
                'visibility' => 'all',
            ],
            [
                'title' => 'Server Maintenance Checklist',
                'topic_name' => 'IT Internal',
                'description' => "Weekly Internal Checklist:\n1. Check storage levels on Node A.\n2. Review system logs for unauthorized access.\n3. Verify nightly backup completion.\n4. Update firewall rules based on security alerts.",
                'keywords' => 'server, maintenance, internal, it-only',
                'visibility' => 'it_only',
            ],
            [
                'title' => 'CRM Access for Sales Team',
                'topic_name' => 'Software Support',
                'description' => "This guide is specifically for Sales personnel accessing the CRM:\n1. Log in via the Sales Gateway.\n2. Ensure multi-factor authentication is enabled.\n3. Do not share customer data outside the organization.",
                'keywords' => 'crm, sales, customer, data',
                'visibility' => 'departments',
                'departments' => [5] // Sales department ID from tinker
            ],
            [
                'title' => 'Finance Software Installation Guide',
                'topic_name' => 'Software Support',
                'description' => "Installation steps for the new Finance suite:\n1. Download the installer from the internal portal.\n2. Run as administrator.\n3. Input the license key provided by your manager.\n4. Restart the system.",
                'keywords' => 'finance, software, tool, money',
                'visibility' => 'departments',
                'departments' => [2] // Finance department ID from tinker
            ],
            [
                'title' => 'Academy Portal Troubleshooting',
                'topic_name' => 'LMS Support',
                'description' => "If the Academy portal is slow:\n1. Clear browser cache.\n2. Use Chrome or Edge browsers.\n3. Check your internet connection.\n4. Contact Academy support if issues persist.",
                'keywords' => 'academy, lms, student, course',
                'visibility' => 'departments',
                'departments' => [3] // Academy department ID from tinker
            ],
        ];

        foreach ($solutions as $item) {
            $deptIds = $item['departments'] ?? [];
            unset($item['departments']);

            $solution = ItSolution::create($item);

            if (!empty($deptIds)) {
                $solution->departments()->sync($deptIds);
            }
        }
    }
}
