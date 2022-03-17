<?php

namespace PedroBruning\PhPix\Services\Contracts;

use PedroBruning\Models\Contracts\ChargeRequest;

interface ChargeService
{
    public function getById(string $id);

    public function getByFilter(array $filter);

    public function create(ChargeRequest $chargeRequest);

    public function getQrCodeById(string $id);
}