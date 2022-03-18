<?php

namespace PedroBruning\PhPix\Services\OpenPix;

use PedroBruning\PhPix\Models\Contracts\Request;
use PedroBruning\PhPix\Services\Contracts\ChargeService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenPixChargeService implements ChargeService
{
    public function __construct(private HttpClientInterface $client)
    {}

    public function getById(string $id): array
    {
        try {
            $response = $this->client
                ->request('GET', "charge/$id");
            return $response->toArray();
        }  catch (ClientExceptionInterface $exception) {
            return $exception->getResponse()->toArray();
        }
    }

    public function getByFilter(array $filter): array
    {
        try {
            $response = $this->client
                ->request('GET', "charge", $filter);
            return $response->toArray();
        }  catch (ClientExceptionInterface $exception) {
            return $exception->getResponse()->toArray();
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
        }  catch (ClientExceptionInterface $exception) {
            return $exception->getResponse()->toArray();
        }
    }
}
