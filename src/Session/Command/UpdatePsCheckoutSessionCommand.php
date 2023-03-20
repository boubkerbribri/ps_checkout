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

namespace PrestaShop\Module\PrestashopCheckout\Session\Command;

use PrestaShop\Module\PrestashopCheckout\Cart\Exception\CartException;
use PrestaShop\Module\PrestashopCheckout\Cart\ValueObject\CartId;
use PrestaShop\Module\PrestashopCheckout\PayPal\Order\Exception\PayPalOrderException;
use PrestaShop\Module\PrestashopCheckout\PayPal\Order\ValueObject\PayPalOrderId;

class UpdatePsCheckoutSessionCommand
{
    /**
     * @var PayPalOrderId
     */
    private $orderId;

    /**
     * @var CartId
     */
    private $cartId;

    /**
     * @var string
     */
    private $fundingSource;

    /**
     * @var string
     */
    private $paypalIntent;

    /**
     * @var string
     */
    private $paypalStatus;

    /**
     * @var string
     */
    private $paypalToken;

    /**
     * @var string;
     */
    private $paypalTokenExpire;

    /**
     * @var string;
     */
    private $paypalAuthorizationExpire;

    /**
     * @var bool;
     */
    private $isExpressCheckout;

    /**
     * @var bool;
     */
    private $isHostedFields;

    /**
     * @param string $orderId
     * @param int $id_cart
     * @param string $fundingSource
     * @param string $paypalIntent
     * @param string $paypalStatus
     * @param string $paypalToken
     * @param string $paypalTokenExpire
     * @param string $paypalAuthorizationExpire
     * @param bool $isHostedFields
     * @param bool $isExpressCheckout
     *
     * @throws PayPalOrderException
     * @throws CartException
     */
    public function __construct(
        $orderId,
        $id_cart,
        $fundingSource,
        $paypalIntent,
        $paypalStatus,
        $paypalToken,
        $paypalTokenExpire,
        $paypalAuthorizationExpire,
        $isHostedFields,
        $isExpressCheckout
    ) {
        $this->orderId = new PayPalOrderId($orderId);
        $this->cartId = new CartId($id_cart);
        $this->fundingSource = $fundingSource;
        $this->paypalIntent = $paypalIntent;
        $this->paypalStatus = $paypalStatus;
        $this->paypalToken = $paypalToken;
        $this->paypalTokenExpire = $paypalTokenExpire;
        $this->paypalAuthorizationExpire = $paypalAuthorizationExpire;
        $this->isHostedFields = $isHostedFields;
        $this->isExpressCheckout = $isExpressCheckout;
    }

    /**
     * @return CartId
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @return string
     */
    public function getPaypalIntent()
    {
        return $this->paypalIntent;
    }

    /**
     * @return string
     */
    public function getPaypalStatus()
    {
        return $this->paypalStatus;
    }

    /**
     * @return string
     */
    public function getPaypalToken()
    {
        return $this->paypalToken;
    }

    /**
     * @return string
     */
    public function getPaypalAuthorizationExpire()
    {
        return $this->paypalAuthorizationExpire;
    }

    /**
     * @return string
     */
    public function getPaypalTokenExpire()
    {
        return $this->paypalTokenExpire;
    }

    /**
     * @return bool
     */
    public function isExpressCheckout()
    {
        return $this->isExpressCheckout;
    }

    /**
     * @return bool
     */
    public function isHostedFields()
    {
        return $this->isHostedFields;
    }

    /**
     * @return PayPalOrderId
     */
    public function getPayPalOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getFundingSource()
    {
        return $this->fundingSource;
    }
}
