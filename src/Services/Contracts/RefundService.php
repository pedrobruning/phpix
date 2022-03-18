<?php

namespace PedroBruning\PhPix\Services\Contracts;

use PedroBruning\PhPix\Models\Contracts\Request;

interface RefundService
{
    public function getById(string $id): array;

    public function getAll(): array;

    public function create(Request $refundRequest): array;
}