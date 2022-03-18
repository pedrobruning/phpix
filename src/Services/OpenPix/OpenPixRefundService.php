<?php

namespace PedroBruning\PhPix\Services\OpenPix;

use PedroBruning\PhPix\Models\Contracts\Request;
use PedroBruning\PhPix\Services\Contracts\RefundService;
use PedroBruning\PhPix\Services\Traits\ReturnsError;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenPixRefundService implements RefundService
{
    use ReturnsError;

    public function __construct(private HttpClientInterface $client)
    {
    }

    public function getById(string $id): array
    {
        try {
            $response = $this->client->request('GET', "refund/$id");
            return $response->toArray();
        } catch (ClientException $exception) {
            return $this->returnError($exception);
        }
    }

    public function getAll(): array
    {
        try {
            $response = $this->client->request('GET', "refund");
            return $response->toArray();
        } catch (ClientException $exception) {
            return $this->returnError($exception);
        }
    }

    public function create(Request $refundRequest): array
    {
        try {
            $payload = [
                'json' => $refundRequest->getPayload()
            ];
            $response = $this->client
                ->request('POST', 'refund', $payload);
            return $response->toArray();
        }  catch (ClientException $exception) {
            return $this->returnError($exception);
        }
    }
}