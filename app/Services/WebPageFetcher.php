<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebPageFetcher {
    /**
     * Fetches the content of a given URL using an HTTP GET request.
     * Logs success or failure and throws an exception if the request fails.
     *
     * @param string $url
     * @return string 
     * @throws \Exception
     */
    public function fetch(string $url): string
    {
        try {
            $response = Http::get($url);

            if ($response->failed()) {
                Log::error('WebPageFetcher: failed to fetch URL', [
                    'url' => $url,
                    'status' => $response->status(),
                ]);
                throw new \RuntimeException('Failed to fetch URL: ' . $url);
            }

            Log::info('WebPageFetcher: successfully fetched URL', [
                'url' => $url,
                'body_length' => strlen($response->body()),
            ]);

            return $response->body();
        } catch (\Exception $e) {
            Log::error('WebPageFetcher exception', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
            throw $e; 
        }
    }
}
