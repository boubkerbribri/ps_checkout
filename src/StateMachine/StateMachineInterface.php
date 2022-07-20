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

namespace PrestaShop\Module\StateMachine;

use PrestaShop\Module\StateMachine\State\StateInterface;
use PrestaShop\Module\StateMachine\Transition\TransitionInterface;

/**
 * Based on package yohang/Finite
 */
interface StateMachineInterface
{
    public function initialize();

    /**
     * @param string $transitionName
     * @param array $parameters
     * 
     * @return mixed
     */
    public function apply($transitionName, $parameters = []);

    /**
     * @param TransitionInterface $transition
     * @param array $parameters
     * 
     * @return boolean
     */
    public function can($transition, $parameters = []);

    /**
     * @return StateInterface
     */
    public function getCurrentState();

    /**
     * @param StateInterface $state
     */
    public function addState($state);

    /**
     * @param string $name
     * 
     * @return StateInterface
     */
    public function getState($name);

    /**
     * @return StateInterface[]
     */
    public function getStates();

    /**
     * @param TransitionInterface $transition
     */
    public function addTransition($transition);

    /**
     * @param string $name
     * 
     * @return TransitionInterface
     */
    public function getTransition($name);

    /**
     * @return TransitionInterface[]
     */
    public function getTransitions();

    /**
     * @param StatefullInterface $object
     */
    public function setObject($object);

    /**
     * @return StatefullInterface
     */
    public function getObject();

    /**
     * @param string $graph
     */
    public function setGraph($graph);

    /**
     * @return string
     */
    public function getGraph();
}