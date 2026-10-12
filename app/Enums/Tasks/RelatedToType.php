<?php

namespace App\Enums\Tasks;

use App\Models\Contact;
use App\Models\Product;
use App\Models\Lead;

enum RelatedToType: string
{
    case LEAD = Lead::class;
    case CONTACT = Contact::class;
    // case PRODUCT = Product::class;

    public static function valueFromName(string $name): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->name === strtoupper($name)) {
                return $case->value;
            }
        }

        return null;
    }
}
