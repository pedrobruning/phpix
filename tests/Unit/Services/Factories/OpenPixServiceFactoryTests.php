<?php

namespace Tests\Unit\Factories;

use PedroBruning\PhPix\Services\Factories\OpenPixServiceFactory;
use PedroBruning\PhPix\Services\OpenPix\OpenPixService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenPixServiceFactoryTests extends TestCase
{
    public function test_make_method_returns_instance_of_OpenPixService()
    {
        $clientMock = $this->createMock(HttpClientInterface::class);
        $sut = OpenPixServiceFactory::make($clientMock);
        $this->assertInstanceOf(OpenPixService::class, $sut);
    }

}