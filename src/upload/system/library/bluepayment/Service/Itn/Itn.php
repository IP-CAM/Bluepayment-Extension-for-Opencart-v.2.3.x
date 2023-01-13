<?php

namespace BluePayment\Service\Itn;

use bluepayment\Service\Itn\Result\ITNResponseType;

final class Itn
{
    private $itn_result = [];

    public function addResult(ITNResponseType $itn_result)
    {
        $this->itn_result[] = $itn_result;
    }

    public function handle($transactionStatus, $orderId, $orderStatusId)
    {
        foreach ($this->itn_result as $itn) {
            if ($itn->canProcess($transactionStatus, $orderStatusId)) {
                 $itn->process($orderId);
            }
        }
    }
}
