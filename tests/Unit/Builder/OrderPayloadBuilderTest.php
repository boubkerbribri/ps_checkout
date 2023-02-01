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

namespace Tests\Unit\Builder;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PrestashopCheckout\Temp\Builder\CreateOrderPayloadBuilder;
use PrestaShop\Module\PrestashopCheckout\Temp\Helper\OrderDataHelper;
use PrestaShop\Module\PrestashopCheckout\Temp\Provider\OrderDataProvider;

class OrderPayloadBuilderTest extends TestCase
{
    public function testPayloadCreation()
    {
        $orderDataHelperMock = $this->createMock(OrderDataHelper::class);
        $orderDataHelperMock->method('getPayPalIsoCode')->willReturn('FR');
        $orderDataHelperMock->method('getStateNameById')->willReturn('France');

        $orderPayloadBuilder = new CreateOrderPayloadBuilder(new OrderDataProvider($this->getCartData(), $orderDataHelperMock));
        $payload = $orderPayloadBuilder->buildPayload();

        $this->checkPayloadApplicationContext($payload);
        $this->checkPayloadPayer($payload);
        $this->checkPayloadPurchaseUnits($payload);
    }

    /**
     * @return array
     */
    private function getCartData()
    {
        return [
            'shop' => [
                'name' => 'PrestaTest'
            ],
            'ps_checkout' => [
                'isExpressCheckout' => true
            ],
            'cart' => [
                'addresses' => [
                    'invoice' => [
                        'address1' => '4 rue Jules Lefebvre',
                        'address2' => '6eme etage',
                        'city' => 'Paris',
                        'firstname' => 'John',
                        'id_country' => '1',
                        'id_state' => '1',
                        'lastname' => 'Doe',
                        'phone' => '',
                        'phone_mobile' => '0612345678',
                        'postcode' => '75000'
                    ]
                ],
                'cart' => [
                    'totals' => [
                        'total_including_tax' => [
                            'amount' => 299.99
                        ]
                    ]
                ],
                'currency' => [
                    'iso_code' => 'EUR'
                ],
                'customer' => [
                    'birthday' => '1990-01-01',
                    'email' => 'john.doe@prestashop.com'
                ]
            ]
        ];
    }

    /**
     * @param array $payload
     */
    private function checkPayloadPayer($payload)
    {
        print 'Payer : ' . json_encode($payload['payer']) . PHP_EOL;
    }

    /**
     * @param array $payload
     */
    private function checkPayloadApplicationContext($payload)
    {
        print 'ApplicationContext : ' . json_encode($payload['application_context']) . PHP_EOL;
    }

    /**
     * @param array $payload
     */
    private function checkPayloadPurchaseUnits($payload)
    {
        print 'PurchaseUnits : ' . json_encode($payload['purchase_units']) . PHP_EOL;
    }
}
