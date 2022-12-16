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

namespace PrestaShop\Module\PrestashopCheckout\Address;

use Address;

class AddressAdapter implements AddressInterface
{
    /**
     * @var Address
     */
    private $address;

    /**
     * {@inheritDoc}
     */
    public function __construct($id = null)
    {
        $this->address = new Address($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return (int) $this->address->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->address->id = $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return $this->address->alias;
    }

    /**
     * {@inheritDoc}
     */
    public function setAlias($alias)
    {
        $this->address->alias = $alias;
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress1()
    {
        return $this->address->address1;
    }

    /**
     * {@inheritDoc}
     */
    public function setAddress1($address1)
    {
        $this->address->address1 = $address1;
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress2()
    {
        return $this->address->address2;
    }

    /**
     * {@inheritDoc}
     */
    public function setAddress2($address2)
    {
        $this->address->address2 = $address2;
    }

    /**
     * {@inheritDoc}
     */
    public function getStateId()
    {
        return (int) $this->address->id_state;
    }

    /**
     * {@inheritDoc}
     */
    public function setStateId($stateId)
    {
        $this->address->id_state = $stateId;
    }

    /**
     * {@inheritDoc}
     */
    public function getCity()
    {
        return $this->address->city;
    }

    /**
     * {@inheritDoc}
     */
    public function setCity($city)
    {
        $this->address->city = $city;
    }

    /**
     * {@inheritDoc}
     */
    public function getPostalCode()
    {
        return $this->address->postcode;
    }

    /**
     * {@inheritDoc}
     */
    public function setPostalCode($postal_code)
    {
        $this->address->postcode = $postal_code;
    }

    /**
     * {@inheritDoc}
     */
    public function getCountryId()
    {
        return (int) $this->address->id_country;
    }

    /**
     * {@inheritDoc}
     */
    public function setCountryId($countryId)
    {
        $this->address->id_country = $countryId;
    }

    /**
     * {@inheritDoc}
     */
    public function getFirstname()
    {
        return $this->address->firstname;
    }

    /**
     * {@inheritDoc}
     */
    public function setFirstname($firstname)
    {
        $this->address->firstname = $firstname;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastname()
    {
        return $this->address->lastname;
    }

    /**
     * {@inheritDoc}
     */
    public function setLastname($lastname)
    {
        $this->address->lastname = $lastname;
    }

    /**
     * {@inheritDoc}
     */
    public function getPhone()
    {
        return $this->address->phone;
    }

    /**
     * {@inheritDoc}
     */
    public function setPhone($phone)
    {
        $this->address->phone = $phone;
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomerId()
    {
        return $this->address->id_customer;
    }

    /**
     * {@inheritDoc}
     */
    public function setCustomerId($customerId)
    {
        $this->address->id_customer = $customerId;
    }

    /**
     * {@inheritDoc}
     */
    public function add()
    {
        return (bool) $this->address->add();
    }

    /**
     * {@inheritDoc}
     */
    public function update()
    {
        return (bool) $this->address->update();
    }

    /**
     * {@inheritDoc}
     */
    public function isUsed()
    {
        return $this->address->isUsed();
    }

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        return true === $this->address->validateFields(false, false)
            && true === $this->address->validateFieldsLang(false, false);
    }
}
