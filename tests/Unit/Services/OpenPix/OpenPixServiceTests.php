<?php

namespace Tests\Unit\Services\OpenPix;

use PedroBruning\PhPix\Services\Contracts\ChargeService;
use PedroBruning\PhPix\Services\OpenPix\OpenPixService;
use PHPUnit\Framework\TestCase;

class OpenPixServiceTests extends TestCase
{
    public function test_charges_method_returns_instance_of_charge_service()
    {
        $chargeServiceMock = $this->createMock(ChargeService::class);
        $sut = new OpenPixService($chargeServiceMock);
        $this->assertEquals($chargeServiceMock, $sut->charges());
    }

}