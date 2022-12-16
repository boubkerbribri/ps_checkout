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

namespace Tests\Unit\Address;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PrestashopCheckout\Address\AddressChecksum;
use PrestaShop\Module\PrestashopCheckout\Address\AddressFactory;
use PrestaShop\Module\PrestashopCheckout\Address\AddressInterface;
use PrestaShop\Module\PrestashopCheckout\Address\AddressManager;
use PrestaShop\Module\PrestashopCheckout\Address\AddressRepository;
use TypeError;

class AddressManagerTest extends TestCase
{
    protected $orderResponse;
    protected $mockAddress;
    protected $addressManager;
    protected $mockRepository;
    protected $mockChecksum;

    public function setUp()
    {
        $this->orderResponse = [
            'id' => '56G00018N7683532G',
            'purchase_units' => [
                [
                    'shipping' => [
                        'name' => '***',
                        'address' => [
                            'address_line_1' => '***',
                            'address_line_2' => '***',
                            'admin_area_1' => 'Paris ',
                            'admin_area_2' => 'Paris ',
                            'postal_code' => '75002',
                            'country_code' => 'FR',
                        ],
                    ],
                ],
            ],
            'payer' => [
                'name' => [
                    'given_name' => 'Jacques',
                    'surname' => 'Martin',
                ],
                'phone_number' => [
                    'national_number' => '0456241045',
                ],
                'address' => [
                    'country_code' => 'FR',
                ],
            ],
        ];
        $this->mockAddress = $this->createMock(AddressInterface::class);
        $this->mockFactory = $this->createMock(AddressFactory::class);
        $this->mockRepository = $this->createMock(AddressRepository::class);
        $this->mockChecksum = $this->createMock(AddressChecksum::class);

        $this->addressManager = new AddressManager(
            $this->mockFactory,
            $this->mockChecksum,
            $this->mockRepository
        );
    }

    /**
     * A test to ensure that the save() method correctly updates the AddressAdapter object's address_id property with the value of the existing address's address_id when an existing address with the same checksum is found.
     */
    public function testSaveUpdatesAddressId()
    {
        $existingAddress = $this->mockAddress;
        $existingAddress->setId(123);

        $newAddress = $this->mockAddress;
        $newAddress->method('getAlias')->willReturn($this->orderResponse['id']);
        $newAddress->method('getAddress1')->willReturn($this->orderResponse['purchase_units'][0]['shipping']['address']['address_line_1']);
        $newAddress->method('getAddress2')->willReturn($this->orderResponse['purchase_units'][0]['shipping']['address']['address_line_2']);
        //$newAddress->method('getStateId')->willReturn($this->orderResponse['purchase_units'][0]['shipping']['address']['admin_area_1']);
        $newAddress->method('getStateId')->willReturn(1);
        $newAddress->method('getCity')->willReturn($this->orderResponse['purchase_units'][0]['shipping']['address']['admin_area_2']);
        $newAddress->method('getPostalCode')->willReturn($this->orderResponse['purchase_units'][0]['shipping']['address']['postal_code']);
        //$newAddress->method('getCountryId')->willReturn($this->orderResponse['purchase_units'][0]['shipping']['address']['country_code']);
        $newAddress->method('getCountryId')->willReturn(1);
        $newAddress->method('getFirstname')->willReturn($this->orderResponse['payer']['name']['given_name']);
        $newAddress->method('getLastname')->willReturn($this->orderResponse['payer']['name']['surname']);
        $newAddress->method('getPhone')->willReturn($this->orderResponse['payer']['phone_number']['national_number']);
        $newAddress->method('getCustomerId')->willReturn(1);

        $this->mockFactory->expects($this->once())
            ->method('createFromOrderResponse')
            ->with($this->orderResponse)
            ->willReturn($newAddress);

        $this->mockChecksum->expects($this->once())
            ->method('generate')
            ->with($newAddress)
            ->willReturn('abc123');

        $this->mockRepository->expects($this->once())
            ->method('findByChecksum')
            ->with('abc123')
            ->willReturn($existingAddress);

        $this->mockRepository->expects($this->once())
            ->method('update')
            ->with($newAddress);

        $this->addressManager->save($this->orderResponse);
    }

    /**
     * A test to ensure that the save() method calls the generate() method on the AddressChecksum object with the correct AddressAdapter object as its parameter.
     */
    public function testSaveCallsGenerateOnChecksum()
    {
        $newAddress = $this->mockAddress;

        $this->mockChecksum->expects($this->once())
            ->method('generate')
            ->with($newAddress);

        $this->addressManager->save($this->orderResponse);
    }

    /**
     * A test to ensure that the save() method calls the findByChecksum() method on the AddressRepository object with the correct checksum value as its parameter.
     */
    public function testSaveCallsFindByChecksumOnRepository()
    {
        $newAddress = $this->mockAddress;

        $this->mockChecksum->expects($this->once())
            ->method('generate')
            ->with($newAddress)
            ->willReturn('abc123');

        $this->mockRepository->expects($this->once())
            ->method('findByChecksum')
            ->with('abc123');

        $this->addressManager->save($this->orderResponse);
    }

    /**
     * A test to ensure that the save() method calls the update() method on the AddressRepository object with the correct AddressAdapter object as its parameter when an existing address with the same checksum is found.
     */
    public function testSaveCallsUpdateOnRepositoryWhenExistingAddressFound()
    {
        $existingAddress = $this->mockAddress;
        $existingAddress->setId(123);

        $newAddress = $this->mockAddress;

        $this->mockChecksum->expects($this->once())
            ->method('generate')
            ->with($newAddress)
            ->willReturn('abc123');

        $this->mockRepository->expects($this->once())
            ->method('findByChecksum')
            ->with('abc123')
            ->willReturn($existingAddress);

        $this->mockRepository->expects($this->once())
            ->method('update')
            ->with($newAddress);

        $this->addressManager->save($this->orderResponse);
    }

    /**
     * A test to ensure that the save() method calls the insert() method on the AddressRepository object with the correct AddressAdapter object as its parameter when no existing address with the same checksum is found.
     */
    public function testSaveCallsInsertOnRepositoryWhenNoExistingAddressFound()
    {
        $newAddress = $this->mockAddress;

        $this->mockChecksum->expects($this->once())
            ->method('generate')
            ->with($newAddress)
            ->willReturn('abc123');

        $this->mockRepository->expects($this->once())
            ->method('findByChecksum')
            ->with('abc123')
            ->willReturn(null);

        $this->mockRepository->expects($this->once())
            ->method('insert')
            ->with($newAddress);

        $this->addressManager->save($this->orderResponse);
    }

    /**
     * Add A test to ensure that the save() method throws an exception if the AddressAdapter object passed to it is null or otherwise invalid.
     */
    public function testSaveThrowsExceptionForInvalidAddress()
    {
        $this->expectException(TypeError::class);

        $this->addressManager->save(null);
    }

    public function testSaveInsertsNewAddress()
    {
        // Set up the checksumMock object to return a predetermined value when the generate() method is called
        $this->mockChecksum->expects($this->once())
            ->method('generate')
            ->willReturn('abc123');

        // Set up the repositoryMock object to return a null value when the findByChecksum() method is called
        $this->mockRepository->expects($this->once())
            ->method('findByChecksum')
            ->willReturn(null);

        // Set up the repositoryMock object to expect the insert() method to be called once with the correct AddressInterface object
        $this->mockRepository->expects($this->once())
            ->method('insert')
            ->with($this->callback(function ($address) {
                return $address instanceof AddressInterface;
            }));

        $this->addressManager->save($this->orderResponse);
    }

    public function testSaveUpdateAddress()
    {
        // Set up the checksumMock object to return a predetermined value when the generate() method is called
        $this->mockChecksum->expects($this->once())
            ->method('generate')
            ->willReturn('abc123');

        // Set up the repositoryMock object to return a predetermined AddressAdapter object when the findByChecksum() method is called
        $existingAddress = $this->mockAddress;
        $existingAddress->setId(123);

        $this->mockRepository->expects($this->once())
            ->method('findByChecksum')
            ->willReturn($existingAddress);

        // Set up the repositoryMock object to expect the update() method to be called once with the correct AddressInterface object
        $this->mockRepository->expects($this->once())
            ->method('update')
            ->with($this->callback(function (AddressInterface $address) {
                var_export($address->getId());

                return $address->getId() === 123;
            }));

        $this->addressManager->save($this->orderResponse);
    }
}
