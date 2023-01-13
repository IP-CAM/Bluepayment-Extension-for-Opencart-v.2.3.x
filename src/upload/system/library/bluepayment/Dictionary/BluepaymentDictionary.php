<?php

namespace BluePayment\Dictionary;

final class BluepaymentDictionary
{
    const EXTENSION_NAME = 'bluepayment';
    const START_TRANSACTION_URI = 'index.php?route=extension/payment/bluepayment/processCheckout';

    public function getExtensionName()
    {
        return self::EXTENSION_NAME;
    }

    public function getExtensionPath()
    {
        return 'extension/payment/' . self::EXTENSION_NAME;
    }

    public function getStartTransactionUri()
    {
        return self::START_TRANSACTION_URI;
    }
}
