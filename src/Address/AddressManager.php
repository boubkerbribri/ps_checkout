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

class AddressManager
{
    /**
     * @var AddressFactory
     */
    protected $factory;

    /**
     * @var AddressChecksum
     */
    protected $checksum;

    /**
     * @var AddressRepository
     */
    protected $repository;

    /**
     * @param AddressFactory $factory
     * @param AddressChecksum $checksum
     * @param AddressRepository $repository
     */
    public function __construct(AddressFactory $factory, AddressChecksum $checksum, AddressRepository $repository)
    {
        $this->factory = $factory;
        $this->checksum = $checksum;
        $this->repository = $repository;
    }

    /**
     * @param array $orderResponse
     *
     * @return bool
     */
    public function save(array $orderResponse)
    {
        $newAddress = $this->factory->createFromOrderResponse($orderResponse);

        if (!$newAddress) {
            return false;
        }

        $checksumValue = $this->checksum->generate($newAddress);
        $existingAddress = $this->repository->findByChecksum($checksumValue);

        if ($existingAddress && !$existingAddress->isUsed()) {
            $newAddress->setId($existingAddress->getId());

            return $this->repository->update($newAddress);
        }

        return $this->repository->insert($newAddress);
    }
}
