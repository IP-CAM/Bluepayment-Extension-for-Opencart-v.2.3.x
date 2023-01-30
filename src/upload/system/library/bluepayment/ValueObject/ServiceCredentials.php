<?php

namespace BluePayment\ValueObject;

final class ServiceCredentials
{
    private $service_id;
    private $shared_key;

    public function __construct($service_id, $shared_key)
    {
        $this->service_id = $service_id;
        $this->shared_key = $shared_key;
    }

    public function getServiceId()
    {
        return $this->service_id;
    }

    public function getSharedKey()
    {
        return $this->shared_key;
    }
}
