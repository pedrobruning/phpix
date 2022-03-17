<?php

namespace PedroBruning\PhPix\Services;

use PedroBruning\PhPix\Services\Contracts\PhPixService;
use PedroBruning\PhPix\Services\Factories\OpenPixServiceFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PhPixServiceFactory
{
    public static function make(Providers $provider, HttpClientInterface $client): PhPixService
    {
        return match ($provider) {
            Providers::OpenPix => OpenPixServiceFactory::make($client)
        };
    }
}