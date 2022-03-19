<?php

namespace Tests\Unit\Models\OpenPix;

use PedroBruning\PhPix\Models\OpenPix\ChargeRequest;
use PHPUnit\Framework\TestCase;

class ChargeRequestTests extends TestCase
{
    public function test_optional_fields_are_filled_correctly()
    {
        $comment = 'Valid Comment';
        $identifier = 'ValidIdentifier';
        $expiresIn = 1800;
        $customer = [
            'name' => 'Valid Name',
            'email' => 'Valid Email',
            'phone' => '0000000000000',
            'taxID' => '00000000000'
        ];
        $additionalInfo = [
            'Notes' => 'Valid Note'
        ];

        $sut = new ChargeRequest(
            correlationId: 'validCorrelationId',
            value: 100,
            comment: $comment,
            identifier: $identifier,
            expiresIn: $expiresIn,
            customer: $customer,
            additionalInfo: $additionalInfo
        );
        $actual = $sut->getPayload();
        $this->assertEquals($comment, $actual['comment']);
        $this->assertEquals($identifier, $actual['identifier']);
        $this->assertEquals($expiresIn, $actual['expiresIn']);
        $this->assertEquals($customer, $actual['customer']);
        $this->assertEquals($additionalInfo, $actual['additionalInfo']);
    }
    public function test_optional_fields_are_not_filled_if_not_passed()
    {
        $sut = new ChargeRequest(
            correlationId: 'validCorrelationId',
            value: 100
        );
        $array = $sut->getPayload();
        $this->assertArrayNotHasKey('comment', $array);
        $this->assertArrayNotHasKey('identifier', $array);
        $this->assertArrayNotHasKey('expiresIn', $array);
        $this->assertArrayNotHasKey('customer', $array);
        $this->assertArrayNotHasKey('additionalInfo', $array);
    }
}