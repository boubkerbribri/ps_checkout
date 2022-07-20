<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

namespace Tests\Unit\StateMachine;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PayPal\Order\State\CompletedState;
use PrestaShop\Module\PayPal\Order\State\CreatedState;
use PrestaShop\Module\PayPal\Order\State\DraftState;
use PrestaShop\Module\PayPal\Order\State\SavedState;
use PrestaShop\Module\PayPal\Order\Transition\CreatedToSavedTransition;
use PrestaShop\Module\PayPal\Order\Transition\DraftToCreatedTransition;
use PrestaShop\Module\PayPal\Order\Transition\SavedToCompletedTransition;
use PrestaShop\Module\StateMachine\StateMachine;
use PrestaShop\Module\StateMachine\StateMachineInterface;

class StateMachineTest extends TestCase
{
    /** @var StateMachineInterface */
    protected $object;

    public function setUp()
    {
        $this->object = new StateMachine();
    }

    public function statesProvider()
    {
        return array(
            new DraftState,
            new CreatedState,
            new SavedState,
            new CompletedState,
        );
    }

    public function transitionsProvider()
    {
        return array(
            new DraftToCreatedTransition,
            new CreatedToSavedTransition,
            new SavedToCompletedTransition,
        );
    }

    protected function addStates()
    {
        $states = $this->statesProvider();
        foreach ($states as $state) {
            $this->object->addState($state);
        }
    }

    protected function addTransitions()
    {
        $transitions = $this->transitionsProvider();
        foreach ($transitions as $transition) {
            $this->object->addTransition($transition);
        }
    }

    protected function initialize()
    {
        $this->addStates();
        $this->addTransitions();
        $this->object->setObject($this->createMock('PrestaShop\Module\StateMachine\StatefullInterface'));
        $this->object->initialize();
    }
}