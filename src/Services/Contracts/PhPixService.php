<?php

namespace PedroBruning\PhPix\Services\Contracts;

interface PhPixService
{
    public function charges(): ChargeService;

    public function refunds(): RefundService;
}