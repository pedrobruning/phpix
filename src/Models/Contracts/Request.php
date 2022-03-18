<?php

namespace PedroBruning\PhPix\Models\Contracts;

interface Request
{
    public function getPayload(): array;
}