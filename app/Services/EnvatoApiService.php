<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Exceptions\Api\EnvatoApiException;


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
        if (in_array($domain, ['localhost', '127.0.0.1']) || str_ends_with($domain, '.test')) {
            return false;
        }

        return true;
    }

}
