<?php

namespace PrestaShop\Module\PrestashopCheckout\Validator;

use PrestaShop\Module\PrestashopCheckout\PayPal\PayPalConfiguration;

class HostedFieldsValidator
{
    /**
     * @var PayPalConfiguration
     */
    private $payPalConfiguration;

    public function __construct(PayPalConfiguration $payPalConfiguration)
    {
        $this->payPalConfiguration = $payPalConfiguration;
    }

    /**
     * returns true if Hosted Fields are disabled or if Hosted Fields are enabled and Cart sum is less than 500
     *
     * @param \Cart $cart
     * @return bool
     * @throws \Exception
     */
    public function validateHostedFieldsAvailableForCart(\Cart $cart)
    {
        return !$this->payPalConfiguration->isCardPaymentEnabled()
            || $this->payPalConfiguration->isCardPaymentEnabled() && $cart->getOrderTotal() < 500;
    }
}
