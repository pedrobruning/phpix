<?php

namespace PedroBruning\PhPix\Services;

use PedroBruning\PhPix\Services\Contracts\PhPixService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PhPixServiceFactory
{
    public static function make(string $provider, HttpClientInterface $client): PhPixService
    {
        switch ($provider)
        {}
    }
}