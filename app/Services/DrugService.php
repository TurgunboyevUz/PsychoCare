<?php
namespace App\Services;

use App\Utils\GoogleTranslate;
use App\Utils\HttpCrawler;
use Symfony\Component\DomCrawler\Crawler;
use Throwable;

class DrugService
{
    public HttpCrawler $client;

    public function __construct()
    {
        $this->client = new HttpCrawler;
    }

    public function searchFromElactancia($name)
    {
        $data = json_decode($this->client->get('https://e-lactancia.org/megasearch/?query=' . $name), true);

        if (empty($data)) {return false;}

        // ----- Levenshtein bo'yicha eng mos variantni aniqlash -----
        $match            = null;
        $shortestDistance = -1;

        foreach ($data as $item) {
            $distance = levenshtein(strtolower($name), strtolower($item['nombre']));

            if ($distance === 0) {
                $match            = $item;
                $shortestDistance = 0;
                break;
            }

            if ($shortestDistance < 0 || $distance < $shortestDistance) {
                $match            = $item;
                $shortestDistance = $distance;
            }
        }

        $urlInfo = $this->client->redirectUrl('https://e-lactancia.org/buscar/?term_id=' . $match['id'] . '&term_type=' . $match['term']);

        return $urlInfo['url'];
    }

    public function getFromElactancia($url)
    {
        $data    = $this->client->get($url);
        $crawler = $this->client->crawle($data);

        $content1 = $crawler->filter('#body > div:nth-child(3) > div.row-margins > div > div:nth-child(1) > div > h2 > p')->text();
        $content2 = $crawler->filter('#body > div:nth-child(3) > div.row-margins > div > div.column.col-xs-12.col-sm-12.col-md-6.no-lateral-padding > div')->text();

        $content3 = $crawler->filter('#body > div:nth-child(3) > div.row-margins > div > div:nth-child(3) > div > ul > li');
        $content3 = $content3->count() > 0 ? $content3->each(fn($node) => $node->text()) : [];

        return [
            'content1' => GoogleTranslate::translate('auto', 'uz', $content1),
            'content2' => GoogleTranslate::translate('auto', 'uz', $content2),
            'content3' => GoogleTranslate::translate('auto', 'uz', implode("\n", $content3)),
        ];
    }

    public function getFromRls($name)
    {
        $data    = $this->client->get('https://www.rlsnet.ru/search_result.htm?word=' . strtolower($name));
        $crawler = $this->client->crawle($data);

        $base       = $crawler->filter('body > div.wrapper.d-flex.flex-column > div.main.content-main > div > div.search-result > div:nth-child(3) > ul > li > a');
        $baseNameRu = $base->text();
        $baseUrl    = $base->link();

        $data       = $this->client->get($baseUrl->getUri());
        $crawler    = $this->client->crawle($data);
        $baseNameEn = $crawler->filter('body > div.wrapper.d-flex.flex-column > div.main.content-main > div > div.tn > div.content > div:nth-child(8)')->text();

        return [
            'search' => $name,
            'ru'     => $baseNameRu,
            'en'     => $baseNameEn,
        ];
    }

    public function searchFromDrugs($name)
    {
        $data = json_decode($this->client->get('https://www.drugs.com/api/autocomplete/?type=interaction-basic&s=' . $name), true);

        if ($data['resultCount'] == 0) {return false;}

        $results = $data['categories'][0]['results'];

        // ----- Levenshtein bo'yicha eng mos variantni aniqlash -----
        $match            = null;
        $shortestDistance = -1;

        foreach ($results as $item) {
            $distance = levenshtein(strtolower($name), strtolower($item['suggestionRaw']));

            if ($distance === 0) {
                $match            = $item;
                $shortestDistance = 0;
                break;
            }

            if ($shortestDistance < 0 || $distance < $shortestDistance) {
                $match            = $item;
                $shortestDistance = $distance;
            }
        }

        return $match['ddc_id'] . '-' . $match['brand_name_id'];
    }

    public function getFromDrugs($drug_id_list)
    {
        $data = $this->client->get('https://www.drugs.com/interactions-check.php?drug_list=' . $drug_id_list, [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language: en-US,en;q=0.9',
            'Accept-Encoding: gzip, deflate, br',
            'Connection: keep-alive',
            'Upgrade-Insecure-Requests: 1',
            'Cache-Control: max-age=0',
            'Sec-Fetch-Dest: document',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-Site: none',
            'Sec-Fetch-User: ?1',
            'Sec-CH-UA: "Chromium";v="128", "Not;A=Brand";v="24", "Google Chrome";v="128"',
            'Sec-CH-UA-Mobile: ?0',
            'Sec-CH-UA-Platform: "Windows"',
        ]);
        $crawler = $this->client->crawle($data);

        $allTexts = [];
        $crawler->filter('.interactions-reference')->slice(0, 6)->each(function ($node) use (&$allTexts) {
            $h3 = $node->filter('h3');

            $h3Dom = $h3->getNode(0);

            foreach ($h3->filter('svg')->getIterator() as $svg) {
                $replacement = $h3Dom->ownerDocument->createTextNode(' ↔ ');
                $svg->parentNode->replaceChild($replacement, $svg);
            }

            $allTexts[] = strtolower(trim($h3->text()));
            $allTexts[] = trim($node->filter('p')->last()->text());
        });

        if (empty($allTexts)) {
            return [];
        }

        $translatedArray = [];

        foreach($allTexts as $text){
            $translatedArray[] = GoogleTranslate::translate('auto', 'uz', $text);
        }

        $interactions = [];
        for ($i = 0; $i < count($translatedArray); $i += 2) {
            $title                = $translatedArray[$i];
            $content              = $translatedArray[$i + 1];
            $interactions[$title] = $content;
        }

        return $interactions;
    }

    public function getListFromPsychiatrienet($url)
    {
        try {
            $html = $this->client->get($url);
        } catch (\Throwable $e) {
            return $this->getListFromPsychiatrienet($url);
        }

        $crawler = new Crawler($html);
        $tbody   = $crawler->filter('tbody')->html();

        preg_match_all('/<tr\b[^>]*>\s*<th>\s*([^<\s]+)\s*<\/th>\s*<th>\s*([^<]+?)\s*<\/th>/si', $tbody, $drugs, PREG_SET_ORDER);
        preg_match_all('/\/switchdetail\/([^"\'>]+)/', $tbody, $urls);

        $names = collect($drugs)->pluck(2)->map('trim')->unique()->values()->all();

        $ru_names = [];
        foreach ($names as $name) {
            $ru_names[] = ucfirst(str_replace(['_LA', '_ER', '_MA'], [' UT', ' KR', ' O\'T'], $name));
        }
        $ru_names = explode("\n\n", GoogleTranslate::translate('en', 'uz', implode("\n\n", $ru_names)));

        return [
            'urls'     => $urls[1],
            'names'    => $names,
            'names_ru' => $ru_names,
        ];
    }

    public function getSwitchFromPsychiatrienet($url)
    {
        $data    = $this->client->get('https://psychiatrienet.nl/switchdetail/' . $url);
        $crawler = $this->client->crawle($data);

        // ----- 1-header -----
        $start_div = 3;

        try {
            $header1 = $crawler->filter('#content > article > div > div > div.column > div > div:nth-child(' . $start_div . ')')->text();
        } catch (Throwable $e) {
            $start_div = 4;
            $header1   = $crawler->filter('#content > article > div > div > div.column > div > div:nth-child(' . $start_div . ')')->text();
        }

        $array1 = $crawler->filter('#content > article > div > div > div.column > div > ul:nth-child(' . ($start_div + 1) . ') > li')->each(fn($node) => trim($node->text()));

        // ----- 2-header -----
        $filter  = $crawler->filter('#content > article > div > div > div.column > div > div:nth-child(' . ($start_div + 2) . ')');
        $header2 = '';
        $array2  = [];

        if ($filter->count() > 0) {
            $header2 = $filter->text();

            $list_filter = $crawler->filter('#content > article > div > div > div.column > div > ul:nth-child(' . ($start_div + 3) . ') > li');
            $array2      = $list_filter->count() > 0 ? $list_filter->each(fn($node) => trim($node->text())) : [];
        }

        // ----- 3-header -----
        $filter  = $crawler->filter('#content > article > div > div > div.column > div > div:nth-child(' . ($start_div + 4) . ')');
        $header3 = '';
        $array3  = [];

        if ($filter->count() > 0) {
            $header3 = $filter->text();

            $list_filter = $crawler->filter('#content > article > div > div > div.column > div > ul:nth-child(' . ($start_div + 5) . ') > li');
            $array3      = $list_filter->count() > 0 ? $list_filter->each(fn($node) => trim($node->text())) : [];
        }

        return [
            [
                'header' => $header1,
                'data'   => $array1,
            ],
            [
                'header' => $header2,
                'data'   => $array2,
            ],
            [
                'header' => $header3,
                'data'   => $array3,
            ],
        ];
    }

    public function getStopFromPsychiatrienet($url)
    {
        $data    = $this->client->get('https://psychiatrienet.nl/switchdetail/' . $url);
        $crawler = $this->client->crawle($data);

        try {
            $header1 = $crawler->filter('#content > article > div > div > div.column > div > div:nth-child(3)')->text();
            $array1  = $crawler->filter('#content > article > div > div > div.column > div > ul:nth-child(4) > li')->each(fn($node) => trim($node->text()));
        } catch (Throwable $e) {
            return ['header' => 'Not available', 'data' => []];
        }

        $filter     = $crawler->filter('#content > article > div > div > div.column > div > dl > dd > ul > li');
        $additional = $filter->count() > 0 ? $filter->each(fn($node) => trim($node->text())) : [];

        return [
            'header' => $header1,
            'data'   => array_merge($array1, $additional),
        ];
    }

    public function parseDrugsList($text)
    {
        $text = mb_strtolower($text, 'utf-8');
        if (strpos($text, "\n") !== false) {
            return array_map('trim', explode("\n", $text));
        }
        if (strpos($text, ',') !== false) {
            return array_map('trim', explode(',', $text));
        }
        return [$text];
    }
}
