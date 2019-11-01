<?php

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/../vendor/autoload.php';

$client = new Client(['cookies' => true]);
$response = $client->request(
    'GET',
    'http://192.168.1.98:81/login'

);
$cookieJar = $client->getConfig('cookies');
//var_dump($cookieJar);

$client = new Client([
    'headers' => [
        'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
    ],
    'cookies' => $cookieJar,
    'verify' => false,
]);

$resposta = $client->request('GET', 'http://192.168.1.98:81/login');
$html = $resposta->getBody()->getContents();
//var_dump($html);

$crawler = new Crawler();
$crawler->addContent($html);

//$token = $crawler->filterXPath('//*[@id="app"]/main/div/div/div/div/div[2]/form/input')->attr('_token');
$token = $crawler->filter('#app > main > div > div > div > div > div.card-body > form > input[type=hidden]')->attr('value');

//var_dump($token);
//echo $token . PHP_EOL;

$resposta = $client->request('POST', 'http://192.168.1.98:81/login',
    [
        'form_params' => [
            '_token' => $token,
            'email' => 'henrique.moreira@forseti.com.br',
            'password' => 'forseti4968'
        ]
    ]);
$cookieJar = $client->getConfig('cookies');
//var_dump($cookieJar);

$painel = $client->request('GET','http://192.168.1.98:81/panel');
$gt = $painel->getBody()->getContents();

var_dump($gt);
