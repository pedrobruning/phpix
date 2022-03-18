<?php

namespace PedroBruning\PhPix\Services\OpenPix;

use PedroBruning\PhPix\Services\Contracts\ChargeService;
use PedroBruning\PhPix\Services\Contracts\PhPixService;
use PedroBruning\PhPix\Services\Contracts\RefundService;

class OpenPixService implements PhPixService
{

    public function __construct(private ChargeService $chargeService, private RefundService $refundService)
    {}

    public function charges(): ChargeService
    {
        return $this->chargeService;
    }

    public function refunds(): RefundService
    {
        return $this->refundService;
    }
}