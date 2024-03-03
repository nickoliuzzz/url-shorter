<?php

declare(strict_types=1);

namespace App\Service\UrlChecker;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class UrlChecker implements UrlCheckerInterface
{
    const API_URL = 'https://www.virustotal.com/api/v3/urls';
    const MINIMUM_HARMLESS_COUNT_FOR_SUCCESS = 1;
    const MINIMUM_MALICIOUS_COUNT_FOR_FAIL = 0;
    const MINIMUM_SUSPICIOUS_COUNT_FOR_FAIL = 0;

    public function __construct(
        private string $url,
    ) {}

    public function isUrlSafe(string $url): bool
    {
        try {
            $client = new Client();
            $headers = [
                'x-apikey' => $this->url,
            ];
            $options = [
                'multipart' => [
                    [
                        'name' => 'url',
                        'contents' => $url
                    ]
                ]];
            $request = new Request('POST', self::API_URL, $headers);
            $res = $client->sendAsync($request, $options)->wait();
            if (!$res instanceof Response || $res->getStatusCode() !== 200) {
                return false;
            }

            $link = json_decode((string) $res->getBody(), true)['data']['links']['self'] ?? null;

            if ($link === null) {
                return false;
            }

            $res = $client->sendAsync(new Request('GET', $link, $headers))->wait();

            if (!$res instanceof Response || $res->getStatusCode() !== 200) {
                return false;
            }

            $stats = json_decode((string) $res->getBody(), true)['data']['attributes']['stats'] ?? false;
            if ($stats === false) {
                return false;
            }
        } catch (\Throwable $throwable) {
            return false;
        }

        if (
            (isset($stats['harmless']) && $stats['harmless'] >= self::MINIMUM_HARMLESS_COUNT_FOR_SUCCESS)
            && (
                (isset($stats['malicious']) && $stats['malicious'] > self::MINIMUM_MALICIOUS_COUNT_FOR_FAIL)
            || (isset($stats['suspicious']) && $stats['suspicious'] > self::MINIMUM_SUSPICIOUS_COUNT_FOR_FAIL)
            )
        ) {
            return false;
        }

        return true;
    }
}
