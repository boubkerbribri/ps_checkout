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
use PrestaShop\Module\StateMachine\Exception;
use PrestaShop\Module\StateMachine\State\State;

/**
 * Based on package yohang/Finite
 */
class StateMachine implements StateMachineInterface
{
    /** @var StatefullInterface */
    protected $object;

    /** @var array */
    protected $states = [];

    /** @var array */
    protected $transitions = [];

    /** @var StateInterface */
    protected $currentState;

    /** @var string */
    protected $graph;

    public function __construct($object = null)
    {
        $this->object = $object;
    }

    public function initialize()
    {
        if (null === $this->object) {
            throw new \Exception('No object bound to the State Machine');
        }

        $initialState = $this->object->getState();

        if (empty($initialState)) {
            $initialState = $this->findInitialState();
            $this->object->setState($initialState);
        }

        $this->currentState = $initialState;
    }

    /**
     * {@inheritdoc}
     */
    public function apply($transitionName, $parameters = [])
    {
        $transition = $this->getTransition($transitionName);
        if (!$this->can($transition, $parameters)) {
            throw new Exception\StateException("The " . $transition->getName() . " transition can not be applied to the state.");
        }

        $returnValue = $transition->process($this);
        $this->currentState = $transition->getState();

        $this->object->setState($this->currentState);

        return $returnValue;
    }

    /**
     * {@inheritdoc}
     */
    public function can($transition, $parameters = [])
    {
        if (null !== $transition->getGuard() && !call_user_func($transition->getGuard(), $this)) {
            return false;
        }

        if (!in_array($transition->getName(), $this->getCurrentState()->getTransitions())) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function addState($state)
    {
        $this->states[$state->getName()] = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function addTransition($transition)
    {
        $this->transitions[$transition->getName()] = $transition;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransition($name)
    {
        if (!isset($this->transitions[$name])) {
            throw new Exception\StateException("Unable to find a transition called $name.");
        }

        return $this->transitions[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function getState($name)
    {
        if (!isset($this->states[$name])) {
            throw new Exception\StateException("Unable to find a state called $name.");
        }

        return $this->states[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function getTransitions()
    {
        return array_keys($this->transitions);
    }

    /**
     * {@inheritdoc}
     */
    public function getStates()
    {
        return array_keys($this->states);
    }

    /**
     * {@inheritdoc}
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * @return StateInterface|null
     */
    protected function findInitialState()
    {
        foreach ($this->states as $state) {
            if (State::TYPE_INITIAL === $state->getType()) {
                return $state;
            }
        }

        throw new Exception\StateException('No initial state found');
    }

    /**
     * {@inheritdoc}
     */
    public function setGraph($graph)
    {
        $this->graph = $graph;
    }

    /**
     * {@inheritdoc}
     */
    public function getGraph()
    {
        return $this->graph;
    }
}