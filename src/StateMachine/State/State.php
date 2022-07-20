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

use PrestaShop\Module\StateMachine\Transition\TransitionInterface;

/**
 * Based on package yohang/Finite
 */
class State implements StateInterface
{
    /** @var int */
    protected $type;

    /** @var array */
    protected $transitions;

    /** @var string */
    protected $name;

    /**
     * @param string $name
     * @param int $type
     * @param array $transitions
     */
    public function __construct($name, $type = self::TYPE_NORMAL, $transitions = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->transitions = $transitions;
    }

    /**
     * {@inheritdoc}
     */
    public function isInitial()
    {
        return self::TYPE_INITIAL === $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function isFinal()
    {
        return self::TYPE_FINAL === $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function isNormal()
    {
        return self::TYPE_NORMAL === $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TransitionInterface $transition
     */
    public function addTransition($transition)
    {
        $this->transitions[] = $transition;
    }

    /**
     * @param array $transitions
     */
    public function setTransitions($transitions)
    {
        foreach ($transitions as $transition) {
            $this->addTransition($transition);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTransitions()
    {
        return $this->transitions;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}