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

namespace PrestaShop\Module\PrestashopCheckout\OnBoarding\Helper;

use PrestaShop\Module\PrestashopCheckout\Configuration\PrestaShopConfiguration;
use PrestaShop\Module\PrestashopCheckout\Entity\PsAccount;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

class OnBoardingStatusHelper
{
    /** @var PrestaShopConfiguration */
    private $configuration;
    /**
     * @var PsAccounts
     */
    private $psAccountsFacade;

    /**
     * @param PrestaShopConfiguration $configuration
     */
    public function __construct(PrestaShopConfiguration $configuration, PsAccounts $psAccountsFacade)
    {
        $this->configuration = $configuration;
        $this->psAccountsFacade = $psAccountsFacade;
    }

    /**
     * @return bool
     *
     * Did not use (new Token)->getToken() because it would create a circular dependency
     */
    public function isPsCheckoutOnboarded()
    {
        return !empty($this->configuration->get(PsAccount::PS_PSX_FIREBASE_ID_TOKEN));
    }

    /**
     * @return bool
     */
    public function isPsAccountsOnboarded()
    {
        try {
            $psAccountsService = $this->psAccountsFacade->getPsAccountsService();

            return $psAccountsService->isAccountLinked();
        } catch (\Exception $exception) {
            return false;
        }
    }
}