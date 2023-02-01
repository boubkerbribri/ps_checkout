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

namespace PrestaShop\Module\PrestashopCheckout\Api\Gateway;

use PrestaShop\Module\PrestashopCheckout\Api\Factory\RequestFactory;
use PrestaShop\Module\PrestashopCheckout\Temp\Builder\OrderDataFactory;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\ClientExceptionInterface;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;

class OrderGateway
{
    /** @var HttpClientInterface */
    public $client;

    /** @var OrderDataFactory */
    public $orderDataFactory;

    /** @var RequestFactory */
    public $requestFactory;

    /**
     * @param HttpClientInterface $client
     * @param OrderDataFactory $orderDataFactory
     * @param RequestFactory $requestFactory
     */
    public function __construct(HttpClientInterface $client, OrderDataFactory $orderDataFactory, RequestFactory $requestFactory)
    {
        $this->client = $client;
        $this->orderDataFactory = $orderDataFactory;
        $this->requestFactory = $requestFactory;
    }

    public function createOrder(array $order)
    {
        try {
            $request = $this->requestFactory->createRequest(
                'POST',
                '/payments/order/create',
                [],
                json_encode($this->orderDataFactory->buildFromContext())
            );
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            // TODO : handle error
        }

        // TODO : handle response
        return $response;
    }

    public function updateOrder()
    {
        try {
            $request = $this->requestFactory->createRequest(
                'POST',
                '/payments/order/update',
                [],
                json_encode($this->orderDataFactory->buildFromContext())
            );
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            // TODO : handle error
        }

        // TODO : handle response
        return $response;
    }

    public function captureOrder()
    {

    }
}
