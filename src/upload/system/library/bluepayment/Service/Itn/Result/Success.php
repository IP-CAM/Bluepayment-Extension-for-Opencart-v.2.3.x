<?php

namespace bluepayment\Service\Itn\Result;

use BlueMedia\OnlinePayments\Model\ItnIn;

final class Success extends Result
{
    public function canProcess($transactionStatus, $orderStatusId)
    {
        $config = $this->registry->get('ConfigProvider');

        return $transactionStatus === ItnIn::PAYMENT_STATUS_SUCCESS &&
            in_array($orderStatusId, [
                $config->getStatusPending(),
                $config->getStatusFailure()
            ]);
    }

    public function process($orderId)
    {
        $this->model_checkout_order->addOrderHistory(
            $orderId,
            $this->registry->get('ConfigProvider')->getStatusSuccess(),
            $this->language->get('bluepayment_transaction_status_success')
        );
    }
}
