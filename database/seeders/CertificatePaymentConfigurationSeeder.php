<?php

namespace Database\Seeders;

use App\Models\CertificatePaymentConfiguration;
use Illuminate\Database\Seeder;

class CertificatePaymentConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        $configurations = [
            ['certificate_type' => 'upedia', 'delivery_type' => 'hard', 'price' => 150.00],
            ['certificate_type' => 'westminster', 'delivery_type' => 'soft', 'price' => 250.00],
            ['certificate_type' => 'westminster', 'delivery_type' => 'hard', 'price' => 4500.00],
            ['certificate_type' => 'pearson', 'delivery_type' => 'soft', 'price' => 987.00],
            ['certificate_type' => 'upedia', 'delivery_type' => 'soft', 'price' => 0.00],
        ];

        foreach ($configurations as $configuration) {
            CertificatePaymentConfiguration::updateOrCreate(
                [
                    'certificate_type' => $configuration['certificate_type'],
                    'delivery_type' => $configuration['delivery_type'],
                ],
                ['price' => $configuration['price']]
            );
        }
    }
}
