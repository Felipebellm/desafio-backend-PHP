<?php

namespace App\Interfaces;

interface CurrencyParserInterface
{
    /**
     * Send a GET request.
     *
     * @param string $url
     * @return string
     */
    public function parse(string $html, array $params): array;
}