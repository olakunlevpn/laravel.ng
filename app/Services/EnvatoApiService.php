<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;
use App\Exceptions\Api\EnvatoApiException;
use Illuminate\Support\Str;

class EnvatoApiService
{
    protected string $access_token;
    protected string $baseUrl;


    public function __construct()
    {
        $this->setEnvironmentEndpoint();
        $this->setAccessToken();
    }


    public function getSaleInformation(string $purchaseCode)
    {
        if (!$this->access_token) {
            throw new EnvatoApiException('Envato personal token is not set.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->access_token,
            'User-Agent' => 'Purchase code verification',
        ])->get($this->baseUrl, ['code' => $purchaseCode]);

        $responseCode = $response->status();

        if ($responseCode === 200) {
            return $response->json();
        }

        throw EnvatoApiException::fromResponseCode($responseCode);
    }

    /**
     * @return void
     */
    public function setEnvironmentEndpoint(): void
    {
        $this->baseUrl = config('envato.envato_endpoint');
    }

    /**
     * @return void
     */
    public function setAccessToken(): void
    {
        $this->access_token = config('envato.envato_personal_token');
    }

    public function isValidDomain($domain): bool
    {
        $allowedDomains = collect([
            'localhost',
            '127.0.0.1',
        ]);

        $allowedExtensions = collect([
            '.test',
            '.example',
            '.invalid',
            '.localhost',
            '.local',
        ]);

        $allowedPrefixes = collect([
            'staging.',
            'stage.',
            'test.',
            'testing.',
            'dev.',
            'development.',
        ]);

        if ($allowedDomains->containsStrict($domain)) {
            return true;
        }

        if ($allowedExtensions->contains(function ($extension) use ($domain) {
            return Str::endsWith($domain, $extension);
        })) {
            return true;
        }

        if ($allowedPrefixes->contains(function ($prefix) use ($domain) {
            return Str::startsWith($domain, $prefix);
        })) {
            return true;
        }

        return false;
    }

}
