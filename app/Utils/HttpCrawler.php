<?php

namespace App\Utils;

use Symfony\Component\DomCrawler\Crawler;

class HttpCrawler
{
    public $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36';
    public $headers    = ['accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7,uz;q=0.6'];

    public function get($url, $headers = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers ?? $this->headers);
        curl_setopt($ch, CURLOPT_ENCODING, '');

        if (curl_error($ch) or curl_error($ch)) {
            return false;
        }

        return curl_exec($ch);
    }

    public function redirectUrl($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        curl_exec($ch);

        if (curl_error($ch) or curl_error($ch)) {
            return false;
        }

        return curl_getinfo($ch);
    }

    public function crawle(string $data)
    {
        return new Crawler($data);
    }
}
