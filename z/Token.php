<?php


use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/../vendor/autoload.php';

        $client = new Client();
        $resposta = $client->request('GET','http://192.168.1.98:81/login');
        $html = $resposta->getBody()->getContents();
//var_dump($html);

        $crawler = new Crawler();
        $crawler->addContent($html);

//$token = $crawler->filterXPath('//*[@id="app"]/main/div/div/div/div/div[2]/form/input')->attr('_token');
        $token = $crawler->filter('#app > main > div > div > div > div > div.card-body > form > input[type=hidden]')->attr('value');

//var_dump($token);
        echo $token . PHP_EOL;
        return $token;
