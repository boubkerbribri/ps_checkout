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

namespace PrestaShop\Module\PrestashopCheckout\Temp\Entities;

class PurchaseUnit
{
    /** @var Amount */
    private $amount;

    /** @var string */
    private $customId;

    /** @var string */
    private $description;

    /** @var string */
    private $invoiceId;

    /** @var Item[] */
    private $items;

    /** @var Payee */
    private $payee;

    /** @var string */
    private $referenceId;

    /** @var Shipping */
    private $shipping;

    /** @var string */
    private $softDescriptor;

    /**
     * @link https://developer.paypal.com/docs/api/orders/v2/#definition-purchase_unit_request
     *
     * @param Amount $amount
     * @param string $customId
     * @param string $description
     * @param string $invoiceId
     * @param Item[] $items
     * @param Payee $payee
     * @param string $referenceId
     * @param Shipping $shipping
     * @param string $softDescriptor
     */
    public function __construct(
        $amount,
        $customId = '',
        $description = '',
        $invoiceId = '',
        $items = null,
        $payee = null,
        $referenceId = '',
        $shipping = null,
        $softDescriptor = ''
    ) {
        $this->amount = $amount;
        $this->customId = $customId;
        $this->description = $description;
        $this->invoiceId = $invoiceId;
        $this->items = $items;
        $this->payee = $payee;
        $this->referenceId = $referenceId;
        $this->shipping = $shipping;
        $this->softDescriptor = $softDescriptor;
    }

    /**
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCustomId()
    {
        return $this->customId;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return Payee
     */
    public function getPayee()
    {
        return $this->payee;
    }

    /**
     * @return string
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }

    /**
     * @return Shipping
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @return string
     */
    public function getSoftDescriptor()
    {
        return $this->softDescriptor;
    }

    public function toArray()
    {
        $data = [
            'amount' => $this->getAmount()->toArray()
        ];

        if (!empty($this->getCustomId())) {
            $data['custom_id'] = $this->getCustomId();
        }

        if (!empty($this->getDescription())) {
            $data['description'] = $this->getDescription();
        }

        if (!empty($this->getInvoiceId())) {
            $data['invoice_id'] = $this->getInvoiceId();
        }

        if (!empty($this->getItems())) {
            foreach ($this->getItems() as $item) {
                $data['items'][] = $item->toArray();
            }
        }

        if (!empty($this->getPayee())) {
            $data['payee'] = $this->getPayee()->toArray();
        }

        if (!empty($this->getReferenceId())) {
            $data['reference_id'] = $this->getReferenceId();
        }

        if (!empty($this->getShipping())) {
            $data['shipping'] = $this->getShipping()->toArray();
        }

        if (!empty($this->getSoftDescriptor())) {
            $data['soft_descriptor'] = $this->getSoftDescriptor();
        }

        return array_filter($data);
    }
}
