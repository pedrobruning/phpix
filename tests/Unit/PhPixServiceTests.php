<?php

namespace Tests;

use PedroBruning\PhPix\Services\Contracts\PhPixService;
use PedroBruning\PhPix\Services\PhPixServiceFactory;
use PHPUnit\Framework\TestCase;

class PhPixServiceTests extends TestCase
{

    private function makeSut(string $provider): PhPixService
    {
        return PhPixServiceFactory::make($provider);
    }

    public function test_ensure_PhPixServiceRepository_returns_correct_service_based_on_provided_provider()
    {
        $repositoryMock = $this->getMockBuilder(PhPixService::class)->getMock();
        $phPixServiceRepositoryStub = $this->createStub(PhPixServiceFactory::class);

        $phPixServiceRepositoryStub->method('make')
            ->willReturn($repositoryMock);

        $this->assertSame($repositoryMock, $phPixServiceRepositoryStub->make('mock'));
    }

}