<?php

namespace BluePayment\Provider;

use BlueMedia\OnlinePayments\Gateway;

final class ConfigProvider
{
    private $registry;

    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    public function getGatewayMode()
    {
        return (int) $this->registry->get('config')->get('bluepayment_test_mode') === 1
            ? Gateway::MODE_SANDBOX
            : Gateway::MODE_LIVE;
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
