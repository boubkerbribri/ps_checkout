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

interface AddressInterface
{
    /**
     * @param int|null $id
     */
    public function __construct($id = null);

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getAlias();

    /**
     * @param string $alias
     */
    public function setAlias($alias);

    /**
     * @return string
     */
    public function getAddress1();

    /**
     * @param string $address1
     */
    public function setAddress1($address1);

    /**
     * @return string
     */
    public function getAddress2();

    /**
     * @param string $address2
     */
    public function setAddress2($address2);

    /**
     * @return int
     */
    public function getStateId();

    /**
     * @param int $stateId
     */
    public function setStateId($stateId);

    /**
     * @return string
     */
    public function getCity();

    /**
     * @param string $city
     */
    public function setCity($city);

    /**
     * @return string
     */
    public function getPostalCode();

    /**
     * @param string $postal_code
     */
    public function setPostalCode($postal_code);

    /**
     * @return int
     */
    public function getCountryId();

    /**
     * @param int $countryId
     */
    public function setCountryId($countryId);

    /**
     * @return string
     */
    public function getFirstname();

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname);

    /**
     * @return string
     */
    public function getLastname();

    /**
     * @param string $lastname
     */
    public function setLastname($lastname);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $phone
     */
    public function setPhone($phone);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     */
    public function setCustomerId($customerId);

    /**
     * @return bool
     */
    public function add();

    /**
     * @return bool
     */
    public function update();

    /**
     * @return bool
     */
    public function isUsed();

    /**
     * @return bool
     */
    public function isValid();
}
