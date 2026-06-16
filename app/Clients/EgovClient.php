<?php

declare(strict_types=1);

namespace App\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class EgovClient
{
    private const EGOV_URL = 'http://egov.siakkab.go.id/api/user-by-token';

    public function getUserByToken(string $token): array
    {
        try {
            $response = Http::withHeaders([
                'Accept'        => 'application/json',
                'Authorization' => "Bearer {$token}",
            ])->timeout(10)->get(self::EGOV_URL);

            return [
                'http_status' => $response->status(),
                'json'        => $response->json(),
            ];
        } catch (ConnectionException $e) {
            report($e);
            throw new \RuntimeException('Server eGov sedang tidak dapat dihubungi.');
        }
    }
}
