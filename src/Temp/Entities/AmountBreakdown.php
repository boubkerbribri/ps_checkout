<?php

namespace PrestaShop\Module\PrestashopCheckout\Temp\Entities;

class AmountBreakdown
{
    /** @var Money */
    private $discount;

    /** @var Money */
    private $handling;

    /** @var Money */
    private $insurance;

    /** @var Money */
    private $itemTotal;

    /** @var Money */
    private $shipping;

    /** @var Money */
    private $shippingDiscount;

    /** @var Money */
    private $taxTotal;

    public function __construct(
        $discount = null,
        $handling = null,
        $insurance = null,
        $itemTotal = null,
        $shipping = null,
        $shippingDiscount = null,
        $taxTotal = null
    ) {
        $this->discount = $discount;
        $this->handling = $handling;
        $this->insurance = $insurance;
        $this->itemTotal = $itemTotal;
        $this->shipping = $shipping;
        $this->shippingDiscount = $shippingDiscount;
        $this->taxTotal = $taxTotal;
    }

    /**
     * @return Money
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @return Money
     */
    public function getHandling()
    {
        return $this->handling;
    }

    /**
     * @return Money
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * @return Money
     */
    public function getItemTotal()
    {
        return $this->itemTotal;
    }

    /**
     * @return Money
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @return Money
     */
    public function getShippingDiscount()
    {
        return $this->shippingDiscount;
    }

    /**
     * @return Money
     */
    public function getTaxTotal()
    {
        return $this->taxTotal;
    }

    public function toArray()
    {
        $data = [];

        if (!empty($this->getDiscount())) {
            $data['discount'] = $this->getDiscount()->toArray();
        }

        if (!empty($this->getHandling())) {
            $data['handling'] = $this->getHandling()->toArray();
        }

        if (!empty($this->getInsurance())) {
            $data['insurance'] = $this->getInsurance()->toArray();
        }

        if (!empty($this->getItemTotal())) {
            $data['item_total'] = $this->getItemTotal()->toArray();
        }

        if (!empty($this->getShipping())) {
            $data['shipping'] = $this->getShipping()->toArray();
        }

        if (!empty($this->getShippingDiscount())) {
            $data['shipping_discount'] = $this->getShippingDiscount()->toArray();
        }

        if (!empty($this->getTaxTotal())) {
            $data['tax_total'] = $this->getTaxTotal()->toArray();
        }

        return array_filter($data);
    }
}
