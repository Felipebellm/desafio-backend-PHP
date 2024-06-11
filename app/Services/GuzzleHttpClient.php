<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Interfaces\HttpClientInterface;
use App\Exceptions\CurrencyNotFoundException;

class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client();   
    }

    public function get(string $url): string
    {
        $response = $this->client->request('GET', $url);
        return $response->getBody()->getContents();
    }
}