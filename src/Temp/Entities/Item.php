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

class Item
{
    /** @var string */
    private $name;

    /** @var string */
    private $quantity;

    /** @var Money */
    private $unitAmount;

    /** @var string */
    private $category;

    /** @var string */
    private $description;

    /** @var string */
    private $sku;

    /** @var Money */
    private $tax;

    /**
     * @param string $name
     * @param string $quantity
     * @param Money $unitAmount
     * @param string $category
     * @param string $description
     * @param string $sku
     * @param Money $tax
     */
    public function __construct($name, $quantity, $unitAmount, $category = '', $description = '', $sku = '', $tax = null)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->unitAmount = $unitAmount;
        $this->category = $category;
        $this->description = $description;
        $this->sku = $sku;
        $this->tax = $tax;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return Money
     */
    public function getUnitAmount()
    {
        return $this->unitAmount;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
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
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return Money
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'name' => $this->getName(),
            'quantity' => $this->getQuantity(),
            'unit_amount' => $this->getUnitAmount()->toArray()
        ];

        if (!empty($this->getCategory())) {
            $data['category'] = $this->getCategory();
        }

        if (!empty($this->getDescription())) {
            $data['description'] = $this->getDescription();
        }

        if (!empty($this->getSku())) {
            $data['sku'] = $this->getSku();
        }

        if (!empty($this->getTax())) {
            $data['tax'] = $this->getTax()->toArray();
        }

        return $data;
    }
}
