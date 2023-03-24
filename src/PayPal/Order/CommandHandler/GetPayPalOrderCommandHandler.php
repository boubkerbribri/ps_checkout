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

namespace PrestaShop\Module\PrestashopCheckout\PayPal\Order\CommandHandler;

use PrestaShop\Module\PrestashopCheckout\Event\EventDispatcherInterface;
use PrestaShop\Module\PrestashopCheckout\PayPal\Order\Command\GetPayPalOrderCommand;
use PrestaShop\Module\PrestashopCheckout\PayPal\Order\Event\PayPalOrderFetchedEvent;
use PrestaShop\Module\PrestashopCheckout\PayPal\Order\PayPalOrderException;
use PrestaShop\Module\PrestashopCheckout\PaypalOrder;

class GetPayPalOrderCommandHandler
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(GetPayPalOrderCommand $getPayPalOrderCommand)
    {
        $paypalOrderId = $getPayPalOrderCommand->getPayPalOrderId()->getValue();
        $paypalOrder = new PaypalOrder($paypalOrderId);
        $order = $paypalOrder->getOrder();

        if (empty($order)) {
            throw new PayPalOrderException(sprintf('Unable to retrieve Paypal Order for %s', $paypalOrderId), PayPalOrderException::CANNOT_RETRIEVE_ORDER);
        }

        $this->eventDispatcher->dispatch(
            new PayPalOrderFetchedEvent($order)
        );
    }
}
