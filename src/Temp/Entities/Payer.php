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

class Payer
{
    /** @var Address */
    private $address;

    /** @var string */
    private $birthDate;

    /** @var string */
    private $emailAddress;

    /** @var PayerName */
    private $name;

    /** @var string */
    private $payerId;

    /** @var PhoneWithType */
    private $phone;

    /** @var PayerTaxInfo */
    private $taxInfo;

    /**
     * @link https://developer.paypal.com/docs/api/orders/v2/#definition-payer
     *
     * @param string $emailAddress
     * @param string $payerId
     * @param PayerName $name
     * @param Address $address
     * @param string $birthDate
     * @param PhoneWithType $phone
     * @param PayerTaxInfo $taxInfo
     */
    public function __construct($emailAddress, $payerId, $name = null, $address = null, $birthDate = '', $phone = null, $taxInfo = null)
    {
        $this->emailAddress = $emailAddress;
        $this->payerId = $payerId;
        $this->name = $name;
        $this->address = $address;
        $this->birthDate = $birthDate;
        $this->phone = $phone;
        $this->taxInfo = $taxInfo;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @return PayerName
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPayerId()
    {
        return $this->payerId;
    }

    /**
     * @return PhoneWithType
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return PayerTaxInfo
     */
    public function getTaxInfo()
    {
        return $this->taxInfo;
    }

    /** return sha1 of the object */
    private function generateChecksum()
    {
        return sha1(serialize($this));
    }

    public function toArray()
    {
        $data = [
            'email_address' => $this->getEmailAddress()
        ];

        if (!empty($this->getPayerId())) {
            $data['payer_id'] = $this->getPayerId();
        }

        if (!empty($this->getName())) {
            $data['name'] = $this->getName()->toArray();
        }

        if (!empty($this->getAddress())) {
            $data['address'] = $this->getAddress()->toArray();
        }

        if (!empty($this->getBirthDate())) {
            $data['birth_date'] = $this->getBirthDate();
        }

        if (!empty($this->getPhone())) {
            $data['phone'] = $this->getPhone()->toArray();
        }

        if (!empty($this->getTaxInfo())) {
            $data['tax_info'] = $this->getTaxInfo()->toArray();
        }

        return array_filter($data);
    }
}
