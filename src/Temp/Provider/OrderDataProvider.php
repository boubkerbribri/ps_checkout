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

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use PrestaShop\Module\PrestashopCheckout\PaypalCountryCodeMatrice;
use PrestaShop\Module\PrestashopCheckout\Repository\PaypalAccountRepository;

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
    /** @var \CartCore */
    private $cart;

    /** @var \ContextCore */
    private $context;

    /** @var \CurrencyCore */
    private $currency;

    /** @var \CustomerCore */
    private $customer;

    /** @var \AddressCore */
    private $deliveryAddress;

    /** @var \AddressCore */
    private $invoiceAddress;

    /** @var \ShopCore */
    private $shop;

    /** @var PaypalAccountRepository */
    private $paypalAccountRepository;

    /** @var \PsCheckoutCart */
    private $psCheckout;

    /**
     * @param PaypalAccountRepository $accountRepository
     */
    public function __construct($accountRepository)
    {
        $this->context = \Context::getContext();
        $this->cart = $this->context->cart;
        $this->currency = new \CurrencyCore(
            $this->cart->id_currency,
            $this->cart->id_lang,
            $this->cart->id_shop
        );
        $this->customer = new \CustomerCore($this->cart->id_customer);
        $this->deliveryAddress = new \AddressCore(
            $this->cart->id_address_delivery,
            $this->cart->id_lang
        );
        $this->invoiceAddress = new \AddressCore(
            $this->cart->id_address_invoice,
            $this->cart->id_lang
        );
        $this->shop = $this->context->shop;
        $this->paypalAccountRepository = $accountRepository;
        $this->psCheckout = new \PsCheckoutCart();
    }

    /**
     * @return string
     */
    public function getBrandName()
    {
        return $this->shop->name;
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
        return $this->psCheckout->isExpressCheckout();
    }

    /**
     * @return string
     */
    public function getPayerGivenName()
    {
        return $this->invoiceAddress->firstname;
    }

    /**
     * @return string
     */
    public function getPayerSurname()
    {
        return $this->invoiceAddress->lastname;
    }

    /**
     * @return false|string
     */
    public function getPayerCountryCode()
    {
        $paypalCountryCodeMatrice = new PaypalCountryCodeMatrice();
        $isoCode = strtoupper(\CountryCore::getIsoById($this->invoiceAddress->id_country));

        return $paypalCountryCodeMatrice->getPaypalIsoCode($isoCode);
    }

    /**
     * @return string
     */
    public function getPayerAddressLine1()
    {
        return $this->invoiceAddress->address1;
    }

    /**
     * @return string
     */
    public function getPayerAddressLine2()
    {
        return $this->invoiceAddress->address2;
    }

    /**
     * @return string
     */
    public function getPayerAdminArea1()
    {
        return \StateCore::getNameById($this->invoiceAddress->id_state);
    }

    /**
     * @return string
     */
    public function getPayerAdminArea2()
    {
        return $this->invoiceAddress->city;
    }

    /**
     * @return string
     */
    public function getPayerPostalCode()
    {
        return $this->invoiceAddress->postcode;
    }

    /**
     * @return string
     */
    public function getPayerBirthdate()
    {
        return (!empty($this->customer->birthday) && $this->customer->birthday !== '0000-00-00') ? $this->customer->birthday : '';
    }

    /**
     * @return string
     */
    public function getPayerEmailAddress()
    {
        return $this->customer->email;
    }

    /**
     * TODO
     *
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
        $phone = !empty($this->invoiceAddress->phone) ? $this->invoiceAddress->phone : '';

        return (empty($phone) && !empty($this->invoiceAddress->phone_mobile)) ? $this->invoiceAddress->phone_mobile : $phone;
    }

    /**
     * @return string
     */
    public function getPayerPhoneType()
    {
        $utilPhoneType = '';
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $parsedPhone = $phoneUtil->parse($this->getPayerPhone(), $this->getPayerCountryCode());
            if ($phoneUtil->isValidNumber($parsedPhone)) {
                $utilPhoneType = $phoneUtil->getNumberType($parsedPhone);
            }

            switch ($utilPhoneType) {
                case PhoneNumberType::MOBILE:
                    return 'MOBILE';
                case PhoneNumberType::PAGER:
                    return 'PAGER';
                default:
                    return 'OTHER';
            }
        } catch (NumberParseException $exception) {
            $module = \Module::getInstanceByName('ps_checkout');
            $module->getLogger()->warning(
                'Unable to format phone number on PayPal Order payload',
                [
                    'phone' => $this->getPayerPhone(),
                    'exception' => $exception,
                ]
            );
        }

        return '';
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currency->iso_code;
    }

    /**
     * @return float
     */
    public function getCartTotalAmount()
    {
        try {
            return $this->cart->getOrderTotal();
        } catch (\Exception $e) {}

        return 0;
    }

    /**
     * @return string
     */
    public function getPurchaseUnitCustomId()
    {
        return $this->cart->id;
    }

    /**
     * @return string
     */
    public function getPurchaseUnitDescription()
    {
        return mb_substr('Checking out with your cart #' . $this->cart->id . ' from ' . $this->getBrandName(), 0, 127);
    }

    /**
     * @return string
     */
    public function getPurchaseUnitInvoiceId()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getPurchaseUnitReferenceId()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getPurchaseUnitSoftDescriptor()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getPayeeEmailAddress()
    {
        return $this->paypalAccountRepository->getMerchantEmail();
    }

    /**
     * @return string
     */
    public function getPayeeMerchantId()
    {
        return $this->paypalAccountRepository->getMerchantId();
    }

    /**
     * @return array|false|mixed[]|null
     */
    public function getCartItems()
    {
        return $this->cart->getProducts();
    }

    /**
     * @return string
     */
    public function getShippingCountryCode()
    {
        $paypalCountryCodeMatrice = new PaypalCountryCodeMatrice();
        $isoCode = strtoupper(\CountryCore::getIsoById($this->deliveryAddress->id_country));

        return $paypalCountryCodeMatrice->getPaypalIsoCode($isoCode);
    }

    /**
     * @return string
     */
    public function getShippingAddressLine1()
    {
        return $this->deliveryAddress->address1;
    }

    /**
     * @return string
     */
    public function getShippingAddressLine2()
    {
        return $this->deliveryAddress->address2;
    }

    /**
     * @return string
     */
    public function getShippingAdminArea1()
    {
        return \StateCore::getNameById($this->deliveryAddress->id_state);
    }

    /**
     * @return string
     */
    public function getShippingAdminArea2()
    {
        return $this->deliveryAddress->city;
    }

    /**
     * @return string
     */
    public function getShippingPostalCode()
    {
        return $this->deliveryAddress->postcode;
    }

    /**
     * @return string
     */
    public function getShippingFullName()
    {
        $gender = new \GenderCore($this->customer->id_gender, $this->cart->id_lang);

        return $gender->name . ' ' . $this->deliveryAddress->lastname . ' ' . $this->deliveryAddress->firstname;
    }

    /**
     * @TODO
     *
     * @return string
     */
    public function getShippingType()
    {
        return true ? 'SHIPPING' : 'PICKUP_IN_PERSON';
    }
}
