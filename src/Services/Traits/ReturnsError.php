<?php

namespace PedroBruning\PhPix\Services\Traits;

trait ReturnsError
{
    public function returnError(\Exception $exception)
    {
        return [
            'error' => $exception->getMessage()
        ];
    }
}