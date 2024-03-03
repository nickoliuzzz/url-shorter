<?php

declare(strict_types=1);

namespace App\Service\UrlChecker;

interface UrlCheckerInterface
{
    public function isUrlSafe(string $url): bool;
}
