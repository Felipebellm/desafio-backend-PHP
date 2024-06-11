<?php

namespace App\Interfaces;

interface HttpClientInterface
{
    /**
     * Send a GET request.
     *
     * @param string $url
     * @return string
     */
    public function get(string $url): string;
}