<?php

namespace PedroBruning\PhPix\Services\OpenPix;

use PedroBruning\PhPix\Models\Contracts\Request;
use PedroBruning\PhPix\Services\Contracts\ChargeService;
use PedroBruning\PhPix\Services\Traits\ReturnsError;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenPixChargeService implements ChargeService
{
    use ReturnsError;

    public function __construct(private HttpClientInterface $client)
    {}

    public function getById(string $id): array
    {
        try {
            $response = $this->client
                ->request('GET', "charge/$id");
            return $response->toArray();
        }  catch (ClientException $exception) {
            return $this->returnError($exception);
        }
    }

    public function getByFilter(array $filter): array
    {
        try {
            $response = $this->client
                ->request('GET', "charge", ['query' => $filter]);
            return $response->toArray();
        }  catch (ClientException $exception) {
            return $this->returnError($exception);
        }
    }

    public function create(Request $chargeRequest): array
    {
        try {
            $payload = [
                'json' => $chargeRequest->getPayload()
            ];
            $response = $this->client
                ->request('POST', 'charge', $payload);
            return $response->toArray();
        }  catch (ClientException $exception) {
            return $this->returnError($exception);
        }
    }
}
