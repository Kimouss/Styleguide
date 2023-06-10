<?php

namespace App\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class CustomSortExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function customSort($array, $key)
    {
        usort($array, function ($a, $b) use ($key) {
            $a = trim(strstr($a[$key], ' ', true));
            $b = trim(strstr($b[$key], ' ', true));
            if (is_numeric($a) && is_numeric($b)) {
                // Si les deux valeurs sont numériques, effectuer un tri numérique
                return $a <=> $b;
            } elseif (is_numeric($a)) {
                // Si la première valeur est numérique et la deuxième non, la première valeur doit être avant
                return -1;
            } elseif (is_numeric($b)) {
                // Si la deuxième valeur est numérique et la première non, la deuxième valeur doit être avant
                return 1;
            } else {
                // Si les deux valeurs ne sont pas numériques, effectuer un tri alphabétique

                return strcmp($a, $b);
            }
        });

        foreach ($array as &$item) {
            if (isset($item['subcategories'])) {
                $item['subcategories'] = $this->customSort($item['subcategories'], $key);
            }
        }

        return $array;
    }
}
