<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MercadoLibreService
{
    protected $client;
    protected $clientId;
    protected $clientSecret;
    protected $accessToken;

    public function __construct()
    {
        $this->client = new Client();
        $this->clientId = config('mercadolibre.client_id');
        $this->clientSecret = config('mercadolibre.client_secret');
        $this->accessToken = config('mercadolibre.access_token');
    }

    public function getUserDetails()
    {
        $response = $this->client->get('https://api.mercadolibre.com/users/me', [
            'query' => [
                'access_token' => $this->accessToken
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function searchProducts($query)
    {
        $response = Http::withOptions(['verify' => false,])->withHeaders([
            'Authorization' => 'Bearer '.$this->accessToken,
            ])->withQueryParameters(['site_id' => 'MLA', 'status' => 'active', 'q' => urlencode($query), ])->get('https://api.mercadolibre.com/products/search');

            return json_decode($response->getBody(), true);
    }
    
}