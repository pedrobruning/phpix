<?php

namespace PedroBruning\PhPix\Services\OpenPix;

use PedroBruning\PhPix\Services\Contracts\ChargeService as ChargeServiceContract;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChargeService implements ChargeServiceContract
{
    public function __construct(HttpClientInterface $client)
    {}

    public function getById(string $id);

    public function getByFilter(array $filter);

    public function create(ChargeRequest $chargeRequest);

    public function getQrCodeById(string $id);
}
