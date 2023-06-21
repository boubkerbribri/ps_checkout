<?php

namespace PrestaShop\Module\PrestashopCheckout\Validator;

use PrestaShop\Module\PrestashopCheckout\PayPal\PayPalConfiguration;
use PrestaShop\PrestaShop\Core\Foundation\IoC\Exception;

class BatchConfigurationValidator
{
    const NON_UPDATABLE_CONFIGURATION_KEYS = [
        PayPalConfiguration::PS_CHECKOUT_PAYPAL_ID_MERCHANT,
        PayPalConfiguration::PS_CHECKOUT_PAYPAL_COUNTRY_MERCHANT,
        PayPalConfiguration::PS_CHECKOUT_PAYPAL_EMAIL_STATUS,
        PayPalConfiguration::PS_CHECKOUT_PAYPAL_PAYMENT_STATUS,
    ];

    /**
     * @param array $configuration
     *
     * @throws Exception
     */
    public function validateAjaxBatchConfiguration($configuration)
    {
        if (empty($configuration) || !is_array($configuration)) {
            throw new Exception("Config can't be empty");
        }

        foreach ($configuration as $configurationItem) {
            if (empty($configurationItem['name']) || 0 !== strpos($configurationItem['name'], 'PS_CHECKOUT_')) {
                throw new Exception('Received invalid configuration key');
            }

            if (array_search($configurationItem['name'], self::NON_UPDATABLE_CONFIGURATION_KEYS)) {
                throw new Exception('Received forbidden configuration key');
            }
        }
    }
}
