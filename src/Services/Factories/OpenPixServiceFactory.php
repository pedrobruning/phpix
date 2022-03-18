<?php

namespace PedroBruning\PhPix\Services\Factories;


use PedroBruning\PhPix\Services\Contracts\PhPixService;
use PedroBruning\PhPix\Services\OpenPix\OpenPixChargeService;
use PedroBruning\PhPix\Services\OpenPix\OpenPixService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenPixServiceFactory
{
    private const BASE_URI = 'https://api.openpix.com.br/api/openpix/v1/';

    public static function make(HttpClientInterface $client): PhPixService
    {
        $client = $client->withOptions(['base_uri' => self::BASE_URI]);
        $chargeService = new OpenPixChargeService($client);
        return new OpenPixService($chargeService);
    }
}