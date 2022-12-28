<?php
namespace bluepayment\Provider;

final class ConfigProvider
{
    private $registry;

    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    public function getStatusPending()
    {
        return (int) $this->registry->get('config')->get('bluepayment_status_pending');
    }

    public function getStatusFailure()
    {
        return (int) $this->registry->get('config')->get('bluepayment_status_failed');
    }

    public function getStatusSuccess()
    {
        return (int) $this->registry->get('config')->get('bluepayment_status_success');
    }
}
