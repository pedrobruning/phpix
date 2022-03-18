<?php

namespace PedroBruning\PhPix\Models\OpenPix;

use PedroBruning\PhPix\Models\Contracts\Request;

class RefundRequest implements Request
{

    public function __construct(
        private int $value,
        private string $transactionEndToEndId,
        private string $correlationId
    )
    {
    }

    public function getPayload(): array
    {
        return [
            'value' => $this->value,
            'transactionEndToEndId' => $this->transactionEndToEndId,
            'correlationID' => $this->correlationId
        ];
    }
}