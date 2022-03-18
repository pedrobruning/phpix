<?php

namespace Tests\Unit\Services\OpenPix;

use PedroBruning\PhPix\Models\OpenPix\RefundRequest;
use PedroBruning\PhPix\Services\OpenPix\OpenPixRefundService;
use PedroBruning\PhPix\Services\Contracts\RefundService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class OpenPixRefundServiceTests extends TestCase
{
    private function makeSut(array $return): RefundService
    {
        $responseInterfaceStub = $this->createStub(ResponseInterface::class);
        $responseInterfaceStub->method('toArray')->willReturn($return);
        $clientStub = $this->createStub(HttpClientInterface::class);
        $clientStub->method('request')->willReturn($responseInterfaceStub);
        return new OpenPixRefundService($clientStub);
    }

    private function makeSutWithClientThrowing(): RefundService
    {
        $clientStub = $this->createStub(HttpClientInterface::class);
        $responseInterfaceStub = $this->createMock(ResponseInterface::class);
        $responseInterfaceStub
            ->method('getInfo')
            ->withConsecutive(['http_code'], ['url'], ['response_headers'])
            ->willReturnOnConsecutiveCalls('400', 'some_url', []);
        $clientStub->method('request')
            ->willThrowException(new ClientException($responseInterfaceStub));
        return new OpenPixRefundService($clientStub);
    }

    public function test_getById_returns_valid_refund()
    {
        $return = $this->validGetByIdResponse();
        $sut = $this->makeSut($return);
        $id = 'validId';

        $result = $sut->getById($id);

        $this->assertEquals($return, $result);
    }

    public function test_getById_returns_error_body_if_client_exception_is_thrown()
    {
        $return = $this->validExceptionResponse();
        $sut = $this->makeSutWithClientThrowing();
        $id = 'validId';

        $result = $sut->getById($id);

        $this->assertEquals($return, $result);
    }

    public function test_getAll_returns_valid_refunds()
    {
        $return = $this->validGetAllResponse();
        $sut = $this->makeSut($return);

        $response = $sut->getAll();

        $this->assertEquals($return, $response);
    }

    public function test_getByAll_returns_error_body_if_client_exception_is_thrown()
    {
        $return = $this->validExceptionResponse();
        $sut = $this->makeSutWithClientThrowing();

        $result = $sut->getAll();

        $this->assertEquals($return, $result);
    }

    public function test_create_returns_valid_charge()
    {
        //Arrange
        $return = $this->validCreateResponse();
        $sut = $this->makeSut($return);
        $charge = $this->fakeRefund();
        //Act
        $response = $sut->create($charge);
        $this->assertEquals($return, $response);
    }

    public function test_create_returns_error_body_if_client_exception_is_thrown()
    {
        //Arrange
        $sut = $this->makeSutWithClientThrowing();
        $charge = $this->fakeRefund();
        //Act
        $result = $sut->create($charge);
        //Assert
        $this->assertEquals($result, $this->validExceptionResponse());
    }


    private function validGetByIdResponse(): array
    {
        return [
            'refund' => [
                'value' => 100,
                'correlationID' => '7777-6f71-427a-bf00-241681624586',
                'refundId' => '11bf5b37e0b842e08dcfdc8c4aefc000',
                'returnIdentification' => 'D09089356202108032000a543e325902'
            ]
        ];
    }

    private function validExceptionResponse(): array
    {
        return [
            'error' => 'HTTP 400 returned for "some_url".'
        ];
    }

    private function validGetAllResponse(): array
    {
        return [
            "pageInfo" => [
                "skip" => 0,
                "limit" => 10,
                "totalCount" => 20,
                "hasPreviousPage" => false,
                "hasNextPage" => true
            ],
            "refunds" => [
                [
                    "status" => "IN_PROCESSING",
                    "value" => 100,
                    "correlationID" => "9134e286-6f71-427a-bf00-241681624586",
                    "refundId" => "9134e2866f71427abf00241681624586",
                    "time" => "2021-03-02T17:28:51.882Z"
                ]
            ]
        ];
    }

    private function validCreateResponse(): array
    {
        return [
            "refund" => [
                "status" => "IN_PROCESSING",
                "value" => 100,
                "correlationID" => "9134e286-6f71-427a-bf00-241681624586",
                "refundId" => "9134e2866f71427abf00241681624586",
                "time" => "2021-03-02T17:28:51.882Z"
            ]
        ];
    }

    private function fakeRefund(): RefundRequest
    {
        return new RefundRequest(
            value: 100,
            correlationId: '9134e286-6f71-427a-bf00-241681624586',
            transactionEndToEndId: '9134e286-6f71-427a-bf00-241681624586'
        );
    }
}