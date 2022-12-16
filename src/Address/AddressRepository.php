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

use Db;

class AddressRepository
{
    /**
     * @var Db
     */
    protected $db;

    /**
     * @param Db $db
     */
    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    /**
     * @param AddressInterface $address
     *
     * @return bool
     */
    public function update(AddressInterface $address)
    {
        return (bool) $address->update();
    }

    /**
     * @param AddressInterface $address
     *
     * @return bool
     */
    public function insert(AddressInterface $address)
    {
        return (bool) $address->add();
    }

    /**
     * @param string $checksum
     *
     * @return AddressInterface|null
     */
    public function findByChecksum($checksum)
    {
        $addressId = $this->db->getValue('
            SELECT a.`id_address`
            FROM ' . _DB_PREFIX_ . 'address AS a
            INNER JOIN' . _DB_PREFIX_ . 'pscheckout_address AS ca ON (ca.alias = a.alias)
            WHERE ca.`checksum` = ' . (int) $checksum
        );

        if (!$addressId) {
            return null;
        }

        return new AddressAdapter($addressId);
    }

    /**
     * @param int $id
     *
     * @return AddressInterface|null
     */
    public function findById($id)
    {
        $address = new AddressAdapter($id);

        if (!$address->getId()) {
            return null;
        }

        return $address;
    }
}
