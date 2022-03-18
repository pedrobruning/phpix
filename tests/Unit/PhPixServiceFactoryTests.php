<?php

namespace Tests;

use PedroBruning\PhPix\Services\Contracts\PhPixService;
use PedroBruning\PhPix\Services\OpenPix\OpenPixService;
use PedroBruning\PhPix\Services\PhPixServiceFactory;
use PedroBruning\PhPix\Services\Providers;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PhPixServiceFactoryTests extends TestCase
{
    public function test_make_method_returns_the_right_service_provider()
    {
        $provider = Providers::OpenPix;
        $clientMock = $this->createMock(HttpClientInterface::class);
        $sut = PhPixServiceFactory::make($provider, $clientMock);
        $this->assertInstanceOf(OpenPixService::class, $sut);
    }

}