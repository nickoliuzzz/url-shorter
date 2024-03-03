<?php

declare(strict_types=1);

namespace App\Service\UrlChecker;

class UrlCheckerLocal implements UrlCheckerInterface
{
    public function isUrlSafe(string $url): bool
    {
        return true;
    }
}
