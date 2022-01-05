<?php

namespace PrestaShop\Module\PrestashopCheckout\Validator;

use PrestaShop\Module\PrestashopCheckout\Builder\Payload\Payload;
use PrestaShop\Module\PrestashopCheckout\Exception\PayPalException;

class OrderPayloadValidator
{
    /**
     * @param Payload $payload
     * @return void
     * @throws PayPalException
     */
    public function validate(Payload $payload)
    {
        $this->validateShippingInformation($payload->getArray()['shipping']);
    }

    private function validateShippingInformation(array $shipping)
    {
        if (!preg_match('/^([A-Z]{2}|C2)$/', $shipping['address']['country_code'])) {
            throw new PayPalException('COUNTRY CODE IS INVALID');
        }

        if ("" === $shipping['address']['postal_code']) {
            throw new PayPalException('POSTAL CODE IS REQUIRED');
        }

        if (!\Validate::isPostCode($shipping['address']['address_line_1'])) {
            throw new PayPalException('POSTAL CODE IS REQUIRED');
        }

        if (!\Validate::isPostCode($shipping['address']['address_line_2'])) {
            throw new PayPalException('POSTAL CODE IS REQUIRED');
        }

        if (!\Validate::isPostCode($shipping['address']['admin_area_2'])) {
            throw new PayPalException('CITY IS REQUIRED');
        }
    }
}
