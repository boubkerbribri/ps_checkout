<?php

namespace PrestaShop\Module\PrestashopCheckout\Temp\Helper;

use libphonenumber\PhoneNumberUtil;
use PrestaShop\Module\PrestashopCheckout\PaypalCountryCodeMatrice;

class OrderDataHelper
{
    /** @var PaypalCountryCodeMatrice */
    private $paypalCountryCodeMatrice;

    /**
     * @param PaypalCountryCodeMatrice $paypalCountryCodeMatrice
     */
    public function __construct($paypalCountryCodeMatrice)
    {
        $this->paypalCountryCodeMatrice = $paypalCountryCodeMatrice;
    }

    public function getStateNameById($stateId)
    {
        return \State::getNameById($stateId);
    }

    /**
     * @param string $idCountry
     *
     * @return false|string
     */
    public function getPayPalIsoCode($idCountry)
    {
        return $this->paypalCountryCodeMatrice->getPaypalIsoCode($this->getCountryIsoCodeById($idCountry));
    }

    /**
     * Use the core to retrieve a country ISO code from its ID
     *
     * @param int $countryId Country ID
     *
     * @return string Country ISO code
     */
    private function getCountryIsoCodeById($countryId)
    {
        return strtoupper(\Country::getIsoById($countryId));
    }

    /**
     * @param string $phone
     * @param string $countryCode
     *
     * @return int
     */
    public function getPhoneNumberUtilPhoneType($phone, $countryCode)
    {
        try {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $parsedPhone = $phoneUtil->parse($phone, $countryCode);
            if ($phoneUtil->isValidNumber($parsedPhone)) {
                return $phoneUtil->getNumberType($parsedPhone);
            }
            return 0;
        } catch (\Exception $exception) {
            $module = \Module::getInstanceByName('ps_checkout');
            $module->getLogger()->warning(
                'Unable to format phone number on PayPal Order payload',
                [
                    'phone' => $phone,
                    'exception' => $exception,
                ]
            );
        }
    }
}
