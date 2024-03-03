<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Route;
use Illuminate\Support\Str;

class RouteService
{
    private const HASH_LENGTH = 6;

    public function getHash(string $url): string
    {
        $route = Route::where('url', '=', $url)->first();

        if ($route !== null) {
            return $route->hash;
        }

        $route = new Route();
        $route->url = $url;
        $route->hash = $this->generateHash();

        $route->save();

        return $route->hash;
    }

    public function getUrl(string $hash): ?string
    {
        $route = Route::where('hash', '=', $hash)->first();

        if ($route === null) {
            return null;
        }

        return $route->url;
    }

    private function generateHash(): string
    {
        do {
            $hash = Str::random(self::HASH_LENGTH);
        } while (Route::where('hash', $hash)->exists());

        return $hash;
    }
}
