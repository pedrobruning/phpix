<?php

namespace PedroBruning\Models\OpenPix;

use PedroBruning\Models\Contracts\ChargeRequest as ChargeRequestContract;
use PedroBruning\Models\Contracts\CustomerRequest;

class ChargeRequest implements ChargeRequestContract
{
    private const OPTIONAL_FIELDS = [
        'comment', 'identifier', 'expiresIn', 'additionalInfo'
    ];

    private array $optionalFields;

    public function __construct(
        private string $correlationId, 
        private int $value, 
        private ?string $comment,
        private ?string $identifier,
        private ?int $expiresIn,
        private ?CustomerRequest $customer,
        private ?array $additionalInfo
    ){
        $this->setOptionalFields();
    }

    public function getFields(): array
    {    
        $result = [
            'correlationId' => $this->correlationId,
            'value' => $this->value,
        ];

        return array_merge($result, $this->optionalFields);    
    }

    private function setOptionalFields(): array
    {   
        if (!empty($this->customer->getFields())) {
            $this->optionalFields['customer'] = $this->customer->getFields();
        }

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