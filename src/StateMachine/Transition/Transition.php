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

namespace PrestaShop\Module\StateMachine\Transition;

use PrestaShop\Module\StateMachine\State\StateInterface;
use PrestaShop\Module\StateMachine\StateMachineInterface;

/**
 * Based on package yohang/Finite
 */
class Transition implements TransitionInterface
{
    /** @var array */
    protected $initialStates;

    /** @var StateInterface */
    protected $state;

    /** @var string */
    protected $name;

    /** @var object */
    protected $guard;

    // TODO
    protected $transitionProcessHandler;

    /**
     * @param string $name
     * @param array $initialStates
     * @param StateInterface $state
     * @param object $guard
     */
    public function __construct($name, $initialStates, $state, $guard = null, $transitionProcessHandler = null)
    {
        $this->name = $name;
        $this->initialStates = $initialStates;
        $this->state = $state;
        $this->guard = $guard;
        $this->transitionProcessHandler = $transitionProcessHandler;
    }

    /**
     * @param StateInterface $state
     */
    public function addInitialState($state)
    {
        $this->initialStates[] = $state;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getInitialStates()
    {
        return $this->initialStates;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function process(StateMachineInterface $stateMachine)
    {
        // Appeler transitionProcessHandler et lui passer la state machine en argument
        // $this->transitionProcessHandler->handle($stateMachine->getObject())
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getGuard()
    {
        return $this->guard;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}