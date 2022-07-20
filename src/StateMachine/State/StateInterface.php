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

namespace PrestaShop\Module\StateMachine\State;

/**
 * Based on package yohang/Finite
 */
interface StateInterface
{
    const TYPE_INITIAL = 'initial';

    const TYPE_NORMAL = 'normal';
    
    const TYPE_FINAL = 'final';

    /**
     * @return string
     */
    public function getName();

    /**
     * @return bool
     */
    public function isInitial();

    /**
     * @return mixed
     */
    public function isFinal();

    /**
     * @return mixed
     */
    public function isNormal();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return array
     */
    public function getTransitions();
}