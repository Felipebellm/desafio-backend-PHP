<?php

namespace App\Services;

use App\Interfaces\HttpClientInterface;
use App\Interfaces\CurrencyParserInterface;
use App\Exceptions\HttpRequestException;

class CurrencyService
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;
    
    /**
     * @var CurrencyParserInterface
     */
    protected $currencyParser;

    /**
     * CurrencyService constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param CurrencyParserInterface $currencyParser
     */
    public function __construct(HttpClientInterface $httpClient, CurrencyParserInterface $currencyParser)
    {
        $this->httpClient = $httpClient;
        $this->currencyParser = $currencyParser;
    }

    /**
     * Fetch currency data from the source.
     *
     * @param array $params
     * @return array
     */
    public function fetchCurrencyData(array $params): array
    {
        $html = $this->httpClient->get('https://pt.wikipedia.org/wiki/ISO_4217');

        return $this->currencyParser->parse($html, $params);
    }
}