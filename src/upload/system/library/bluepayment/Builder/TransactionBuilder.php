<?php
namespace bluepayment\Builder;

require_once DIR_SYSTEM . '/library/bluemedia-sdk-php/index.php';

use Registry;
use BlueMedia\OnlinePayments\Model\TransactionStandard;

final class TransactionBuilder
{
    private $registry;
    private $currency;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
        $this->registry->get('load')->library('bluepayment/Helper/ParamSuffixer');
        $this->currency = $registry->get('currency');
    }

    public function build(array $order_info, $service_id, $gateway_id = null)
    {
        $order_id = $this->registry->get('ParamSuffixer')->addSuffix($order_info['order_id']);

        return (new TransactionStandard())->setServiceId($service_id)
            ->setOrderId($order_id)
            ->setAmount($this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false))
            ->setCurrency($order_info['currency_code'])
            ->setCustomerEmail($order_info['email'])
            ->setGatewayId($gateway_id);
    }
}
