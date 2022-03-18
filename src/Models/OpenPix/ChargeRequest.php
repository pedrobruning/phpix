<?php

namespace PedroBruning\PhPix\Models\OpenPix;

use PedroBruning\PhPix\Models\Contracts\Request;

class ChargeRequest implements Request
{
    private const OPTIONAL_FIELDS = [
        'comment', 'identifier', 'customer', 'expiresIn', 'additionalInfo'
    ];

    private array $optionalFields;

    public function __construct(
        private string $correlationId,
        private int $value,
        private ?string $comment = null,
        private ?string $identifier = null,
        private ?int $expiresIn = null,
        private ?array $customer = null,
        private ?array $additionalInfo = null
    ){
        $this->setOptionalFields();
    }

    public function getPayload(): array
    {    
        $result = [
            'correlationId' => $this->correlationId,
            'value' => $this->value,
        ];

        return array_merge($result, $this->optionalFields);
    }

    private function setOptionalFields(): void
    {
        foreach (self::OPTIONAL_FIELDS as $field) {
            $this->appendToOptionalFieldIfNotNull($field);
        }
    }

    private function appendToOptionalFieldIfNotNull($field): void
    {
        if (!is_null($this->{$field})) {
            $this->optionalFields[$field] = $this->{$field};
        }
    }
}