<?php

namespace PedroBruning\PhPix\Services\OpenPix;

use PedroBruning\PhPix\Services\Contracts\ChargeService;
use PedroBruning\PhPix\Services\Contracts\PhPixService;

class OpenPixService implements PhPixService
{

    public function __construct(private ChargeService $chargeService)
    {}

    public function charges(): ChargeService
    {
        return $this->chargeService;
    }
}