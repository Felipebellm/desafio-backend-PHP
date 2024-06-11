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
                // dd($row->html());
                // Adicione a lógica de extração de dados aqui
                $cells = $row->filter('td');
                
                if ($cells->count() > 0) {
                    $currency = [];
                    $currency['code'] = $cells->eq(0)->text();
                    $currency['number'] = $cells->eq(1)->text();
                    $currency['decimal'] = $cells->eq(2)->text();
                    $currency['name'] = $cells->eq(3)->text();
                    $currency['location'] = $cells->eq(4)->text();
                    dd($params);
                    if (isset($params['code_list'])) {
                        if (in_array($currency['code'], $params['code_list'] ?? []) ||
                            in_array((int)$currency['number'], $params['number_list'] ?? [])) {

                                dd($params);
                            // $data[] = [
                            //     'code' => $currencyCode,
                            //     'number' => $currencyNumber,
                            //     'decimal' => $currencyDecimal,
                            //     'currency' => $currencyName,
                            //     'currency_locations' => $currencyLocations, // Você pode precisar parsear isso conforme necessário
                            // ];
                        }
                    }
                }
            });
        });
        dd($data);
        return $data;
    }
    public function getData ($params)
    {
        $data[] = [
            'code' => $currencyCode,
            'number' => $currencyNumber,
            'decimal' => $currencyDecimal,
            'currency' => $currencyName,
            'currency_locations' => $currencyLocations, // Você pode precisar parsear isso conforme necessário
        ];
    }


}