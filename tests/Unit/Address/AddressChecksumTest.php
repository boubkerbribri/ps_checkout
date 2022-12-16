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
use PrestaShop\Module\PrestashopCheckout\Address\AddressInterface;

class AddressChecksumTest extends TestCase
{
    /**
     * @dataProvider generateDataProvider
     */
    public function testGenerate($addressData, $expectedChecksum)
    {
        $address = $this->createMock(AddressInterface::class);

        // Set up the mock to return the provided address data when the corresponding methods are called
        foreach ($addressData as $method => $returnValue) {
            $address->method($method)->willReturn($returnValue);
        }

        $checksum = new AddressChecksum();
        $result = $checksum->generate($address);

        $this->assertEquals($expectedChecksum, $result);
    }

    public function generateDataProvider()
    {
        return [
            [
                [
                    'getAddress1' => '123 Main St',
                    'getAddress2' => '',
                    'getStateId' => 'NY',
                    'getCity' => 'New York',
                    'getPostalCode' => '10001',
                    'getCountryId' => 'US',
                    'getFirstname' => 'John',
                    'getLastname' => 'Doe',
                    'getPhone' => '123-456-7890',
                ],
                'ed06d45813733dbcaaf2a4c19bee9b792879fb97',
            ],
            [
                [
                    'getAddress1' => '456 Market St',
                    'getAddress2' => 'Suite 100',
                    'getStateId' => 'CA',
                    'getCity' => 'San Francisco',
                    'getPostalCode' => '94111',
                    'getCountryId' => 'US',
                    'getFirstname' => 'Jane',
                    'getLastname' => 'Smith',
                    'getPhone' => '234-567-8901',
                ],
                'a4579f3c6eac04a5eb9b177a693a20e1b3045617',
            ],
            [
                [
                    'getAddress1' => '123 Boulevard St Michel',
                    'getAddress2' => '',
                    'getStateId' => '75',
                    'getCity' => 'Paris',
                    'getPostalCode' => '75005',
                    'getCountryId' => 'FR',
                    'getFirstname' => 'Jean',
                    'getLastname' => 'Dupont',
                    'getPhone' => '123-456-7890',
                ],
                '47794639b6718a7f4bbd12d6e5f163f183d7f696',
            ],
            [
                [
                    'getAddress1' => '123 Calle Mayor',
                    'getAddress2' => '',
                    'getStateId' => '28',
                    'getCity' => 'Madrid',
                    'getPostalCode' => '28013',
                    'getCountryId' => 'ES',
                    'getFirstname' => 'Juan',
                    'getLastname' => 'Pérez',
                    'getPhone' => '123-456-7890',
                ],
                'fea01da206f5995195b92fc1188a07155272c293',
            ],
            [
                [
                    'getAddress1' => '123 Via del Corso',
                    'getAddress2' => '',
                    'getStateId' => 'RM',
                    'getCity' => 'Roma',
                    'getPostalCode' => '00186',
                    'getCountryId' => 'IT',
                    'getFirstname' => 'Mario',
                    'getLastname' => 'Rossi',
                    'getPhone' => '123-456-7890',
                ],
                '22880ba197ddc8892488f73b4281dfbb85ba5681',
            ],
            [
                [
                    'getAddress1' => '123 Rue de la Loi',
                    'getAddress2' => '',
                    'getStateId' => 'BRU',
                    'getCity' => 'Bruxelles',
                    'getPostalCode' => '1040',
                    'getCountryId' => 'BE',
                    'getFirstname' => 'Jean',
                    'getLastname' => 'Dupont',
                    'getPhone' => '123-456-7890',
                ],
                '0a267a99a7c830f323bcc8f6c05e9c5437f18c32',
            ],
            [
                [
                    'getAddress1' => '123 Kurfürstendamm',
                    'getAddress2' => '',
                    'getStateId' => 'BE',
                    'getCity' => 'Berlin',
                    'getPostalCode' => '10719',
                    'getCountryId' => 'DE',
                    'getFirstname' => 'Hans',
                    'getLastname' => 'Müller',
                    'getPhone' => '123-456-7890',
                ],
                'ad8ebac07966a28c2950b2ea43e3e0b4b65b8332',
            ],
        ];
    }
}
