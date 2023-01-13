<?php

namespace BluePayment\Service\Itn\Result;

use BlueMedia\OnlinePayments\Model\ItnIn;

final class Failure extends Result
{
    public function canProcess($transactionStatus, $orderStatusId)
    {
        return $transactionStatus === ItnIn::PAYMENT_STATUS_FAILURE &&
            $orderStatusId === $this->registry->get('ConfigProvider')->getStatusPending();
    }

    public function process($orderId)
    {
        $this->model_checkout_order->addOrderHistory(
            $orderId,
            $this->registry->get('ConfigProvider')->getStatusFailure(),
            $this->language->get('bluepayment_transaction_status_failed')
        );
    }
}
