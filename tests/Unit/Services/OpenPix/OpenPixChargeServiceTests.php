<?php

namespace Tests\Unit\Services\OpenPix;

use PedroBruning\PhPix\Models\OpenPix\ChargeRequest;
use PedroBruning\PhPix\Services\OpenPix\OpenPixChargeService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class OpenPixChargeServiceTests extends TestCase
{
    private function makeSut(array $return): OpenPixChargeService
    {
        $responseInterfaceStub = $this->createStub(ResponseInterface::class);
        $responseInterfaceStub->method('toArray')->willReturn($return);
        $clientStub = $this->createStub(HttpClientInterface::class);
        $clientStub->method('request')->willReturn($responseInterfaceStub);
        return new OpenPixChargeService($clientStub);
    }

    private function makeSutWithClientThrowing(): OpenPixChargeService
    {
        $clientStub = $this->createStub(HttpClientInterface::class);
        $responseInterfaceStub = $this->createMock(ResponseInterface::class);
        $responseInterfaceStub
            ->method('getInfo')
            ->withConsecutive(['http_code'], ['url'], ['response_headers'])
            ->willReturnOnConsecutiveCalls('400', 'some_url', []);
        $clientStub->method('request')
            ->willThrowException(new ClientException($responseInterfaceStub));
        return new OpenPixChargeService($clientStub);
    }

    public function test_getById_returns_valid_charge()
    {
        //Arrange
        $return = $this->validGetByIdResponse();
        $sut = $this->makeSut($return);
        //Act
        $result = $sut->getById('fakeId');

        //Assert
        $this->assertEquals($return, $result);
    }

    public function test_getById_returns_error_body_if_client_exception_is_thrown()
    {
        //Arrange
        $sut = $this->makeSutWithClientThrowing();
        //Act
        $result = $sut->getById('fakeId');
        //Assert
        $this->assertEquals($result, $this->validExceptionResponse());
    }

    public function test_getByFilter_returns_valid_charges()
    {
        //Arrange
        $return = $this->validGetByFilterResponse();
        $sut = $this->makeSut($return);

        $filter = [
            'start' => '2021-03-01T17:28:51.882Z',
            'end' => '2021-03-05T17:28:51.882Z',
            'status' => 'ACTIVE',
        ];

        //Act
        $result = $sut->getByFilter($filter);

        //Assert
        $this->assertEquals($return, $result);
    }

    public function test_getByFilter_returns_error_body_if_client_exception_is_thrown()
    {
        //Arrange
        $sut = $this->makeSutWithClientThrowing();
        $filter = [
            'start' => '2021-03-01T17:28:51.882Z',
            'end' => '2021-03-05T17:28:51.882Z',
            'status' => 'ACTIVE',
        ];

        //Act
        $result = $sut->getByFilter($filter);
        //Assert
        $this->assertEquals($result, $this->validExceptionResponse());
    }

    public function test_create_returns_valid_charge()
    {
        //Arrange
        $return = $this->validCreateResponse();
        $sut = $this->makeSut($return);
        $charge = $this->fakeCharge();
        //Act
        $response = $sut->create($charge);
        $this->assertEquals($return, $response);
    }

    public function test_create_returns_error_body_if_client_exception_is_thrown()
    {
        //Arrange
        $sut = $this->makeSutWithClientThrowing();
        $charge = $this->fakeCharge();
        //Act
        $result = $sut->create($charge);
        //Assert
        $this->assertEquals($result, $this->validExceptionResponse());
    }

    private function validGetByIdResponse(): array
    {
        return [
            "charge" => [
                "status" => "ACTIVE",
                "customer" => [
                    "name" => "Dan",
                    "email" => "email0@entria.com.br",
                    "phone" => "119912345670",
                    "taxID" => [
                        "taxID" => "31324227036",
                        "type"=> "BR:CPF"
                    ]
                ],
                "value" => 100,
                "comment" => "good",
                "correlationID" => "9134e286-6f71-427a-bf00-241681624586",
                "paymentLinkID" => "7777-6f71-427a-bf00-241681624586",
                "paymentLinkUrl" => "https://openpix.com.br/pay/9134e286-6f71-427a-bf00-241681624586",
                "globalID" => "Q2hhcmdlOjcxOTFmMWIwMjA0NmJmNWY1M2RjZmEwYg==",
                "qrCodeImage" => "https://api.openpix.dev/openpix/charge/brcode/image/9134e286-6f71-427a-bf00-241681624586.png",
                "brCode" => "000201010212261060014br.gov.bcb.pix2584http://localhost:5001/openpix/testing?transactionID=867ba5173c734202ac659721306b38c952040000530398654040.015802BR5909LOCALHOST6009Sao Paulo62360532867ba5173c734202ac659721306b38c963044BCA",
                "createdAt" => "2021-03-02T17:28:51.882Z",
                "updatedAt" => "2021-03-02T17:28:51.882Z"
            ]
        ];
    }

    private function validGetByFilterResponse(): array
    {
        return [
            "pageInfo" => [
                "skip" => 0,
                "limit" => 10,
                "totalCount" => 25,
                "hasPreviousPage" => false,
                "hasNextPage" => true
            ],
            "charges" => [
                [
                    "status" => "ACTIVE",
                    "customer" => [
                        "name" => "Dan",
                        "email" => "email0@entria.com.br",
                        "phone" => "119912345670",
                        "taxID" => [
                            "taxID" => "31324227036",
                            "type" => "BR:CPF"
                        ]
                    ],
                    "value" => 100,
                    "comment" => "good",
                    "correlationID" => "9134e286-6f71-427a-bf00-241681624586",
                    "paymentLinkID" => "7777a23s-6f71-427a-bf00-241681624586",
                    "paymentLinkUrl" => "https://openpix.com.br/pay/9134e286-6f71-427a-bf00-241681624586",
                    "qrCodeImage" => "https://api.openpix.dev/openpix/charge/brcode/image/9134e286-6f71-427a-bf00-241681624586.png",
                    "brCode" => "000201010212261060014br.gov.bcb.pix2584http://localhost:5001/openpix/testing?transactionID=867ba5173c734202ac659721306b38c952040000530398654040.015802BR5909LOCALHOST6009Sao Paulo62360532867ba5173c734202ac659721306b38c963044BCA",
                    "additionalInfo" => [
                        [
                            "key" => "Product",
                            "value" => "Pencil"
                        ],
                        [
                            "key" => "Invoice",
                            "value" => "18476"
                        ],
                        [
                            "key" => "Order",
                            "value" => "302"
                        ]
                    ],
                    "createdAt" => "2021-03-02T17:28:51.882Z",
                    "updatedAt" => "2021-03-02T17:28:51.882Z"
                ],
                [
                    "status" => "ACTIVE",
                    "customer" => [
                        "name" => "Test",
                        "email" => "test@test.com.br",
                        "phone" => "119912345670",
                        "taxID" => [
                            "taxID" => "31324227036",
                            "type" => "BR:CPF"
                        ]
                    ],
                    "value" => 10000,
                    "comment" => "bad",
                    "correlationID" => "9134e286-6f71-427a-bf00-241681624586",
                    "paymentLinkID" => "7777a23s-6f71-427a-bf00-241681624586",
                    "paymentLinkUrl" => "https://openpix.com.br/pay/9134e286-6f71-427a-bf00-241681624586",
                    "qrCodeImage" => "https://api.openpix.dev/openpix/charge/brcode/image/9134e286-6f71-427a-bf00-241681624586.png",
                    "brCode" => "000201010212261060014br.gov.bcb.pix2584http://localhost:5001/openpix/testing?transactionID=867ba5173c734202ac659721306b38c952040000530398654040.015802BR5909LOCALHOST6009Sao Paulo62360532867ba5173c734202ac659721306b38c963044BCA",
                    "additionalInfo" => [
                        [
                            "key" => "Product",
                            "value" => "Card"
                        ],
                        [
                            "key" => "Invoice",
                            "value" => "232323"
                        ],
                        [
                            "key" => "Order",
                            "value" => "22"
                        ]
                    ],
                    "createdAt" => "2021-03-02T17:28:51.882Z",
                    "updatedAt" => "2021-03-02T17:28:51.882Z"
                ]
            ]
        ];
    }

    private function validCreateResponse(): array
    {
        return [
            "charge" => [
                "status" => "ACTIVE",
                "customer" => [
                    'name' => 'Test Customer',
                    'email' => 'email@test.com',
                    'phone' => '(00) 00000-0000',
                    "taxID" => [
                        "taxID" => "000000000000",
                        "type" => "BR:CPF"
                    ]
                ],
                "value" => 100,
                "comment" => "validComment",
                "correlationID" => "9134e286-6f71-427a-bf00-241681624586",
                "paymentLinkID" => "7777a23s-6f71-427a-bf00-241681624586",
                "paymentLinkUrl" => "https://openpix.com.br/pay/9134e286-6f71-427a-bf00-241681624586",
                "qrCodeImage" => "https://api.openpix.dev/openpix/charge/brcode/image/9134e286-6f71-427a-bf00-241681624586.png",
                "createdAt" => "2021-03-02T17:28:51.882Z",
                "updatedAt" => "2021-03-02T17:28:51.882Z",
                "brCode" => "000201010212261060014br.gov.bcb.pix2584http://localhost:5001/openpix/testing?transactionID=867ba5173c734202ac659721306b38c952040000530398654040.015802BR5909LOCALHOST6009Sao Paulo62360532867ba5173c734202ac659721306b38c963044BCA",
            ]
        ];
    }

    private function validExceptionResponse(): array
    {
        return [
            'error' => 'HTTP 400 returned for "some_url".'
        ];
    }

    private function fakeCharge(): ChargeRequest
    {
        return new ChargeRequest(
            correlationId: 'validCorrelation',
            value: 100,
            comment: 'validComment',
            identifier: 'validIdentifier',
            customer: [
                'name' => 'Test Customer',
                'email' => 'email@test.com',
                'phone' => '(00) 00000-0000',
                'taxID' => '000000000000'
            ]
        );
    }
}