<?php

require __DIR__ . '/vendor/autoload.php';

use PedroBruning\PhPix\Services\PhPixServiceFactory;
use PedroBruning\PhPix\Services\Providers;
use Symfony\Component\HttpClient\HttpClient;

$provider = Providers::OpenPix;
$client = HttpClient::create();
$client = $client->withOptions([
    'base_uri' => 'https://pokeapi.co/api/v2/'
]);

$response = $client->request('GET', 'pokemon/ditto');

// var_dump($response);

$phPixService = PhPixServiceFactory::make($provider, $client);

var_dump($phPixService->charges());