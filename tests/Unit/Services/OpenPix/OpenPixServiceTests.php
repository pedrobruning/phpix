<?php

namespace Tests\Unit\Services\OpenPix;

use PedroBruning\PhPix\Services\Contracts\ChargeService;
use PedroBruning\PhPix\Services\Contracts\RefundService;
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

    public function test_refunds_method_returns_instance_of_charge_service()
    {
        $chargeServiceMock = $this->createMock(ChargeService::class);
        $refundServiceMock = $this->createMock(RefundService::class);
        $sut = new OpenPixService(chargeService: $chargeServiceMock, refundService: $refundServiceMock);
        $this->assertEquals($refundServiceMock, $sut->refunds());
    }

}