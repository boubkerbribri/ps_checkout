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

namespace PrestaShop\Module\PrestashopCheckout\Temp\Builder;

use PrestaShop\Module\PrestashopCheckout\Temp\Entities\Address;
use PrestaShop\Module\PrestashopCheckout\Temp\Entities\Amount;
use PrestaShop\Module\PrestashopCheckout\Temp\Entities\AmountBreakdown;
use PrestaShop\Module\PrestashopCheckout\Temp\Entities\ApplicationContext;
use PrestaShop\Module\PrestashopCheckout\Temp\Entities\Money;
use PrestaShop\Module\PrestashopCheckout\Temp\Entities\Payer;
use PrestaShop\Module\PrestashopCheckout\Temp\Entities\PayerName;
use PrestaShop\Module\PrestashopCheckout\Temp\Entities\Phone;
use PrestaShop\Module\PrestashopCheckout\Temp\Entities\PhoneWithType;
use PrestaShop\Module\PrestashopCheckout\Temp\Entities\PurchaseUnit;
use PrestaShop\Module\PrestashopCheckout\Temp\Provider\OrderDataProvider;

class CreateOrderPayloadBuilder
{
    /** @var OrderDataProvider */
    private $orderDataProvider;

    /**
     * @param OrderDataProvider $orderDataProvider
     */
    public function __construct($orderDataProvider)
    {
        $this->orderDataProvider = $orderDataProvider;
    }

    /**
     * @return array
     */
    public function buildPayload()
    {
        return [
            'application_context' => $this->buildApplicationContextNode(),
            'intent' => 'CAPTURE',
            'payer' => $this->buildPayerNode(),
            'purchase_units' => $this->buildPurchaseUnitsNode()
        ];
    }

    /**
     * @return array
     */
    private function buildApplicationContextNode()
    {
        $applicationContext = new ApplicationContext(
            $this->orderDataProvider->getBrandName(),
            $this->orderDataProvider->getShippingPreference()
        );

        return $applicationContext->toArray();
    }

    /**
     * @return array
     */
    private function buildPayerNode()
    {
        $payerName = new PayerName($this->orderDataProvider->getPayerGivenName(), $this->orderDataProvider->getPayerSurname());
        $address = new Address(
            $this->orderDataProvider->getPayerCountryCode(),
            $this->orderDataProvider->getPayerAddressLine1(),
            $this->orderDataProvider->getPayerAddressLine2(),
            $this->orderDataProvider->getPayerAdminArea1(),
            $this->orderDataProvider->getPayerAdminArea2(),
            $this->orderDataProvider->getPayerPostalCode()
        );
        $phone = new PhoneWithType(
            new Phone($this->orderDataProvider->getPayerPhone()),
            $this->orderDataProvider->getPayerPhoneType()
        );

        $payer = new Payer(
            $this->orderDataProvider->getPayerEmailAddress(),
            $this->orderDataProvider->getPayerId(),
            $payerName,
            $address,
            $this->orderDataProvider->getPayerBirthdate(),
            $phone,
            null
        );

        return $payer->toArray();
    }

    /**
     * @return array
     */
    private function buildPurchaseUnitsNode()
    {
        $amount = $this->buildAmountNode();
        $purchaseUnit = new PurchaseUnit();

        return [$purchaseUnit->toArray()];
    }

    /**
     * @return Amount
     */
    private function buildAmountNode()
    {
        $money = new Money($this->orderDataProvider->getCurrencyCode(), $this->orderDataProvider->getCartTotalAmount());
        $breakdown = new AmountBreakdown();

        return new Amount($money, $breakdown);
    }
}
