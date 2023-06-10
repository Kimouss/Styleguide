<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CustomSortExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CustomSortExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('custom_sort', [CustomSortExtensionRuntime::class, 'customSort']),
        ];
    }
}
