<?php 

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CurrencyService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();   
    }

    public function fetchCurrencyData(array $params)
    {
        // Fazer a requisição HTTP para a página da Wikipedia
        $response = $this->httpClient->request('GET', 'https://pt.wikipedia.org/wiki/ISO_4217');

        // Obter o conteúdo da resposta
        
        $html = $response->getBody()->getContents();

        // Parsear o HTML usando Symfony DomCrawler
        $crawler = new Crawler($html);
        // dd($crawler);
        // Inicializar o array para armazenar os dados
        $data = [];
        // dd($crawler);
        // $crawler->filter('table.wikitable')->each(function (Crawler $table) use (&$data, $params) {
        //     $
        // });
        // dd($tables->each(function (Crawler $node) {
        //     return $node->html();
        // }));
        $crawler->filter('table.wikitable')->each(function (Crawler $table) use (&$data, $params) {
           
            $table->filter('tr')->each(function (Crawler $row) use (&$data, $params) {
                dd($row->html());
                // Adicione a lógica de extração de dados aqui
                $cells = $row->filter('td');
                
                if ($cells->count() > 0) {
                    dd($cells->html());
                    $currencyCode = $cells->eq(0)->text();
                    $currencyNumber = $cells->eq(1)->text();
                    $currencyDecimal = $cells->eq(2)->text();
                    $currencyName = $cells->eq(3)->text();
                    $currencyLocations = $cells->eq(4)->text();

                    if (in_array($currencyCode, $params['code_list'] ?? []) ||
                        in_array((int)$currencyNumber, $params['number_list'] ?? [])) {
                        $data[] = [
                            'code' => $currencyCode,
                            'number' => $currencyNumber,
                            'decimal' => $currencyDecimal,
                            'currency' => $currencyName,
                            'currency_locations' => $currencyLocations, // Você pode precisar parsear isso conforme necessário
                        ];
                    }
                }
            });
        });
        dd($data);
        return $data;
    }
}