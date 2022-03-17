<?php

namespace PedroBruning\PhPix\Services\Contracts;

use Symfony\Contracts\HttpClient\HttpClientInterface;

interface ChargeService
{
    public function __construct(HttpClientInterface $client);
}