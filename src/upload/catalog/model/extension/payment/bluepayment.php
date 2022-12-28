<?php

class ModelExtensionPaymentBluepayment extends Model
{
    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->load->library('bluepayment/Dictionary/BluepaymentDictionary');
    }

    public function getMethod()
    {
        $this->load->library('bluepayment/Provider/ServiceCredentialsProvider');

        if (!$this->ServiceCredentialsProvider->currencyServiceExists()) {
            return [];
        }

        $this->load->language($this->BluepaymentDictionary->getExtensionPath());

        return [
            'code' => $this->BluepaymentDictionary->getExtensionName(),
            'title' => $this->language->get('text_title'),
            'sort_order' => '',
            'terms' => '',
        ];
    }
}
