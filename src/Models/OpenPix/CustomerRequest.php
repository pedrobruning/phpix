<?php

namespace PedroBruning\Models\OpenPix;

class CustomerRequest
{
    public function __construct(
        private string $name,
        private string $email,
        private string $phone,
        private string $taxId
    )
    {}

    public function getFields(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'taxId' => $this->taxId
        ];
    }
}