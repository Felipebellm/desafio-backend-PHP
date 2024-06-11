<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use App\Interfaces\CurrencyParserInterface;

class WikipediaCurrencyParser implements CurrencyParserInterface
{
    /**
     * Parse the HTML and extract data based params.
     *
     * @param string $html
     * @param array $params
     * @return array
     */
    public function parse(string $html, array $params): array
    {
        $crawler = new Crawler($html);
        $data = [];

        $crawler->filter('table.wikitable')->each(function (Crawler $table) use (&$data, $params) {
            $table->filter('tr')->each(function (Crawler $row) use (&$data, $params) {
                $cells = $row->filter('td');
                if ($cells->count() > 0) {
                    $currency = [];
                    $currency['code'] = $cells->eq(0)->text();
                    $currency['number'] = $cells->eq(1)->text();
                    $currency['decimal'] = $cells->eq(2)->text();
                    $currency['name'] = $cells->eq(3)->text();
                    $currency['location'] = $cells->eq(4);

                    if (isset($params['number_list']) && in_array($currency['number'], $params['number_list']) ||
                        isset($params['code_list']) && in_array($currency['code'], $params['code_list'])) {
                        $data[] = $this->handleData($currency);
                    } 
                    if (isset($params['number']) && $params['number'] === $currency['number']) {
                        $data[] = $this->handleData($currency);
                    } 
                    if (isset($params['code']) && $params['code'] === $currency['code']) {
                        $data[] = $this->handleData($currency);
                    }


                }
            });
        });
        
        return $data;
    }

    /**
     * Process and structure the currency data.
     *
     * @param array $currency
     * @return array
     */
    private function handleData($currency): array
    {
        $icons = [];
        $countries = [];

        $currency['location']->filter('.mw-file-element')->each(function (Crawler $icon) use (&$icons) {
            $icons[] = $icon->attr('src');
        });

        $currency['location']->filter('a')->each(function (Crawler $country) use (&$countries) {
            if ($country->attr('class') !== 'mw-file-description') {
                $countries[] = $country->attr('title');
            }
        });

        $location = [];
        foreach ($countries as $key => $country) {

            $location[$key]['location'] = $country;
            $location[$key]['icon'] = (isset($icons[$key]) ? 'https:' . $icons[$key] : '');
        }

        return [
            'code' => $currency['code'],
            'number' => $currency['number'],
            'decimal' => $currency['decimal'],
            'currency' => $currency['name'],
            'currency_locations' => $location,
        ];
    }
}
