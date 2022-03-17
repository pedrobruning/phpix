<?php

namespace PedroBruning\Models\Contracts;

interface CustomerRequest
{
    public function getFields(): array;
}