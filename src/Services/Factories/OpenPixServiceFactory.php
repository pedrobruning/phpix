<?php

namespace PedroBruning\PhPix\Factories;


use PedroBruning\PhPix\Services\Contracts\PhPixService;
use PedroBruning\PhPix\Services\OpenPix\ChargeService;
use PedroBruning\PhPix\Services\OpenPix\OpenPixService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenPixServiceFactory
{
    public static function make(HttpClientInterface $client): PhPixService
    {
        $chargeService = new ChargeService($client);
        return new OpenPixService($chargeService);
    }
}