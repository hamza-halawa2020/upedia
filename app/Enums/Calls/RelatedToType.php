<?php

namespace App\Enums\Calls;

use App\Models\Contact;
use App\Models\Lead;
use App\Models\Product;

enum RelatedToType: string
{
    case LEAD = Lead::class;
    case CONTACT = Contact::class;
    case PRODUCT = Product::class;
}
