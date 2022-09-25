<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;


class WirelessSpider extends BasicSpider
{
    public array $startUrls = [
        'https://wltest.dns-systems.net/'
    ];

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {

        $headlines = $response->filter('.header.dark-bg>h3');
        $descriptions = $response->filter('.package-description');
        $price = $response->filter('span.price-big');
        $discount = $response->filter('.package-price');

        $count = $headlines->count();

        for ($i = 0; $i < $count; $i++) {

            yield $this->item([
                'option title' => $headlines->getNode($i)->textContent,
                'description' => $descriptions->getNode($i)->textContent,
                'price' => $price->getNode($i)->textContent,
                'discount' => is_null($discount->getNode($i - 3)) ? '' : $discount->getNode($i - 3)->textContent,
            ]);

        }


    }

}
