<?php

namespace App\Enums;

enum IndustryEnum: string
{
    case TECHNOLOGY = 'Technology';
    case HEALTHCARE = 'Healthcare';
    case FINANCE = 'Finance';
    case EDUCATION = 'Education';
    case MANUFACTURING = 'Manufacturing';
    case RETAIL = 'Retail';
    case HOSPITALITY = 'Hospitality';
    case TRANSPORTATION = 'Transportation';
    case CONSTRUCTION = 'Construction';
    case AGRICULTURE = 'Agriculture';
    case ENERGY = 'Energy';
    case TELECOMMUNICATIONS = 'Telecommunications';
    case ENTERTAINMENT = 'Entertainment';
    case REAL_ESTATE = 'Real Estate';
    case FOOD_AND_BEVERAGE = 'Food and Beverage';
    case GOVERNMENT = 'Government';
    case LEGAL = 'Legal';
    case MARKETING = 'Marketing';
    case NON_PROFIT = 'Non-Profit';
    case SPORTS = 'Sports';
    case TEXTILES = 'Textiles';
    case AUTOMOTIVE = 'Automotive';
    case CHEMICALS = 'Chemicals';
    case ECOMMERCE = 'E-Commerce';
    case INSURANCE = 'Insurance';
    case PHARMACEUTICALS = 'Pharmaceuticals';
    case MEDIA = 'Media';
    case MINING = 'Mining';
    case AEROSPACE = 'Aerospace';
    case LOGISTICS = 'Logistics';
    case BEAUTY_AND_COSMETICS = 'Beauty and Cosmetics';
    case FASHION = 'Fashion';
    case MARITIME = 'Maritime';
    case SECURITY = 'Security';
    case WASTE_MANAGEMENT = 'Waste Management';
    case CONSULTING = 'Consulting';
    case HUMAN_RESOURCES = 'Human Resources';
    case ART_AND_DESIGN = 'Art and Design';

    public static function options(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
}
