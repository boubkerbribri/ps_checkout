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

namespace PrestaShop\Module\PayPal\Order;

use PrestaShop\Module\StateMachine\State\State;
use PrestaShop\Module\StateMachine\StateMachine;
use PrestaShop\Module\StateMachine\Transition\Transition;

/**
 * Based on package yohang/Finite
 */
class PayPalOrderStateMachineBuilder
{
    /**
     * @return StateMachine
     */
    public function build()
    {
        $stateMachine = new StateMachine(new PayPalOrder());

        $draftState = new State('DRAFT', State::TYPE_INITIAL);
        $createdState = new State('CREATED');
        $savedState = new State('SAVED');
        $pendingApprovalState = new State('PENDING_APPROVAL');
        $payerActionRequiredState = new State('PAYER_ACTION_REQUIRED');
        $approvedState = new State('APPROVED');
        $partiallyCompletedState = new State('PARTIALLY_COMPLETED');
        $voidedState = new State('VOIDED', State::TYPE_FINAL);
        $completedState = new State('COMPLETED', State::TYPE_FINAL);

        $stateMachine->addState($draftState);
        $stateMachine->addState($createdState);
        $stateMachine->addState($savedState);
        $stateMachine->addState($pendingApprovalState);
        $stateMachine->addState($payerActionRequiredState);
        $stateMachine->addState($approvedState);
        $stateMachine->addState($partiallyCompletedState);
        $stateMachine->addState($voidedState);
        $stateMachine->addState($completedState);

        $stateMachine->addTransition(new Transition('TO_CREATED', [$draftState], $createdState));
        $stateMachine->addTransition(new Transition('TO_COMPLETED', [$createdState, $savedState, $approvedState, $partiallyCompletedState], $completedState));
        $stateMachine->addTransition(new Transition('TO_PAYER_ACTION_REQUIRED', [$createdState], $payerActionRequiredState));
        $stateMachine->addTransition(new Transition('TO_PENDING_APPROVAL', [$createdState], $pendingApprovalState));
        $stateMachine->addTransition(new Transition('TO_SAVED', [$createdState], $savedState));
        $stateMachine->addTransition(new Transition('TO_VOIDED', [$savedState, $pendingApprovalState, $payerActionRequiredState, $approvedState], $voidedState));
        $stateMachine->addTransition(new Transition('TO_APPROVED', [$savedState, $pendingApprovalState, $payerActionRequiredState], $approvedState));
        $stateMachine->addTransition(new Transition('TO_PARTIALLY_COMPLETED', [$approvedState], $partiallyCompletedState));

        return $stateMachine;
    }
}