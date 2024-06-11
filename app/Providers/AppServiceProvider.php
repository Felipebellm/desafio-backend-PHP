<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\HttpClientInterface;
use App\Services\GuzzleHttpClient;
use App\Interfaces\CurrencyParserInterface;
use App\Services\WikipediaCurrencyParser;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(HttpClientInterface::class, GuzzleHttpClient::class);
        $this->app->singleton(CurrencyParserInterface::class, WikipediaCurrencyParser::class);
    }

    public function boot()
    {
        //
    }
}