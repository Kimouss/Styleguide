<?php

namespace App\Service;

class SidebarManager
{
    private const ARRAY_BANNED_FOLDER = [
        'partials',
        'bundles',
        'styleguide',
        'components',
    ];

    public function getSidebarEntries(): array
    {
        $templateDirectory = \dirname(__DIR__) . '/../templates';

        return $this->getDirectoryContents($templateDirectory, '/');
    }

    private function getDirectoryContents(string $directory, string $basePath): array
    {
        $contents = [];
        $iterator = new \DirectoryIterator($directory);
        foreach ($iterator as $item) {
            if ($item->isDir() && !$item->isDot() && !in_array($item->getFilename(), self::ARRAY_BANNED_FOLDER)) {
                $url = '/' . ltrim($basePath . '/' . $item->getFilename(), '/');
                $category = [
                    'label' => str_replace("_", " ", $item->getFilename()),
                    'url' => $url,
                    'active' => $this->isActiveUrl($url),
                ];

                $subdirectory = $directory . '/' . $item->getFilename();

                if (is_dir($subdirectory)) {
                    $subContents = $this->getDirectoryContents($subdirectory, $basePath . '/' . $item->getFilename());
                    if (!empty($subContents)) {
                        $category['active'] = false;
                        $category['subcategories'] = $subContents;
                        if ($this->hasActiveSubcategory($subContents)) {
                            $category['active'] = true;
                        }
                    }
                }

                $contents[] = $category;
            }
        }

        return $contents;
    }

    private function isActiveUrl(string $url): bool
    {
        $currentUrl = $_SERVER['REQUEST_URI'];

        return $currentUrl === $url;
    }

    private function hasActiveSubcategory(array $subcategories): bool
    {
        foreach ($subcategories as $subcategory) {
            if (isset($subcategory['active']) && $subcategory['active']) {
                return true;
            }

            if (isset($subcategory['subcategories']) && $this->hasActiveSubcategory($subcategory['subcategories'])) {
                return true;
            }
        }

        return false;
    }
}
