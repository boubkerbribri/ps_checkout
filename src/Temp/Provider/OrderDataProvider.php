<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PrestashopCheckout\Temp\Provider;

use libphonenumber\PhoneNumberType;
use PrestaShop\Module\PrestashopCheckout\Temp\Helper\OrderDataHelper;

/**
 * Configuration
 * Context
 * Shop
 * Customer
 * Address (Invoice & Shipping)
 * PsCheckoutCart
 * Currency
 * Country
 * State
 * Language
 * Formatter (PhoneFormatter, LocaleFormatter, CountryFormatter, CurrencyFormatter....)
 */
class OrderDataProvider
{
    /** @var array */
    private $data;

    /** @var OrderDataHelper */
    private $orderDataHelper;

    public function __construct($data, $orderDataHelper)
    {
        $this->data = $data;
        $this->orderDataHelper = $orderDataHelper;
    }

    /**
     * @return string
     */
    public function getBrandName()
    {
        return \Context::getContext()->shop->name;
    }

    /**
     * @return string
     */
    public function getShippingPreference()
    {
        return $this->isExpressCheckout() ? 'SET_PROVIDED_ADDRESS' : 'GET_FROM_FILE';
    }

    /**
     * @return bool
     */
    public function isExpressCheckout()
    {
        return $this->data['ps_checkout']['isExpressCheckout'];
    }

    /**
     * @return string
     */
    public function getPayerGivenName()
    {
        return $this->data['cart']['addresses']['invoice']['firstname'];
    }

    /**
     * @return string
     */
    public function getPayerSurname()
    {
        return $this->data['cart']['addresses']['invoice']['lastname'];
    }

    /**
     * @return false|string
     */
    public function getPayerCountryCode()
    {
        return $this->orderDataHelper->getPayPalIsoCode($this->data['cart']['addresses']['invoice']['id_country']);
    }

    /**
     * @return string
     */
    public function getPayerAddressLine1()
    {
        return $this->data['cart']['addresses']['invoice']['address1'];
    }

    /**
     * @return string
     */
    public function getPayerAddressLine2()
    {
        return $this->data['cart']['addresses']['invoice']['address2'];
    }

    /**
     * @return string
     */
    public function getPayerAdminArea1()
    {
        return $this->orderDataHelper->getStateNameById($this->data['cart']['addresses']['invoice']['id_state']);
    }

    /**
     * @return string
     */
    public function getPayerAdminArea2()
    {
        return $this->data['cart']['addresses']['invoice']['city'];
    }

    /**
     * @return string
     */
    public function getPayerPostalCode()
    {
        return $this->data['cart']['addresses']['invoice']['postcode'];
    }

    /**
     * @return string
     */
    public function getPayerBirthdate()
    {
        return (!empty($this->data['cart']['customer']['birthday']) && $this->data['cart']['customer']['birthday'] !== '0000-00-00') ? $this->data['cart']['customer']['birthday'] : '';
    }

    /**
     * @return string
     */
    public function getPayerEmailAddress()
    {
        return $this->data['cart']['customer']['email'];
    }

    /**
     * TODO
     * @return string
     */
    public function getPayerId()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getPayerPhone()
    {
        $phone = !empty($this->data['cart']['addresses']['invoice']['phone']) ? $this->data['cart']['addresses']['invoice']['phone'] : '';

        return (empty($phone) && !empty($this->data['cart']['addresses']['invoice']['phone_mobile'])) ? $this->data['cart']['addresses']['invoice']['phone_mobile'] : $phone;
    }

    /**
     * @return string
     */
    public function getPayerPhoneType()
    {
        $utilPhoneType = $this->orderDataHelper->getPhoneNumberUtilPhoneType(
            $this->getPayerPhone(),
            $this->getPayerCountryCode()
        );

        switch ($utilPhoneType) {
            case PhoneNumberType::MOBILE:
                return 'MOBILE';
            case PhoneNumberType::PAGER:
                return 'PAGER';
            default:
                return 'OTHER';
        }
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->data['cart']['currency']['iso_code'];
    }

    /**
     * @return float
     */
    public function getCartTotalAmount()
    {
        return $this->data['cart']['cart']['totals']['total_including_tax']['amount'];
    }
}
