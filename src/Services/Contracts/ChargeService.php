<?php

namespace PedroBruning\PhPix\Services\Contracts;

use PedroBruning\PhPix\Models\Contracts\Request;
use PedroBruning\PhPix\Models\Charge;

interface ChargeService
{
    public function getById(string $id): array;

    public function getByFilter(array $filter): array;

    public function create(Request $chargeRequest): array;
}