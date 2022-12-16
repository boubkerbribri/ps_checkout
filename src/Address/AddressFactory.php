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

namespace PrestaShop\Module\PrestashopCheckout\Address;

use Context;
use Country;
use State;
use Validate;

class AddressFactory
{
    /**
     * @var AddressLineFormatter
     */
    private $addressLineFormatter;

    /**
     * @param AddressLineFormatter $addressLineFormatter
     */
    public function __construct(AddressLineFormatter $addressLineFormatter)
    {
        $this->addressLineFormatter = $addressLineFormatter;
    }

    /**
     * @param array $response
     *
     * @return AddressInterface|null
     */
    public function createFromOrderResponse(array $response)
    {
        $context = Context::getContext();
        $customerId = (int) $context->customer->id;
        $languageId = (int) $context->language->id;
        $shopId = (int) $context->shop->id;
        $countryCode = isset($response['shipping']['address']['country_code']) ? $response['shipping']['address']['country_code'] : '';
        $countryId = (int) Country::getByIso($countryCode);
        $country = new Country($countryId, $languageId, $shopId);
        $stateCode = isset($response['shipping']['address']['admin_area_1']) ? $response['shipping']['address']['admin_area_1'] : '';
        $stateId = 0;

        if (!Validate::isLoadedObject($country)
            || !$country->active
            || !$country->isAssociatedToShop($shopId)
            || Country::isNeedDniByCountryId($countryId)
        ) {
            return null;
        }

        if ($stateCode && $country->contains_states) {
            $stateId = (int) State::getIdByIso($stateCode, $countryId);
        }

        $address = new AddressAdapter();
        $address->setAlias(isset($response['id']) ? $this->addressLineFormatter->format($response['id']) : '');
        $address->setCustomerId($customerId);
        $address->setCountryId($countryId);
        $address->setStateId($stateId);
        $address->setAddress1(isset($response['shipping']['address']['address_line_1']) ? $this->addressLineFormatter->format($response['shipping']['address']['address_line_1']) : '');
        $address->setAddress2(isset($response['shipping']['address']['address_line_2']) ? $this->addressLineFormatter->format($response['shipping']['address']['address_line_2']) : '');
        $address->setCity(isset($response['shipping']['address']['admin_area_2']) ? $this->addressLineFormatter->format($response['shipping']['address']['admin_area_2']) : '');
        $address->setPostalCode(isset($response['shipping']['address']['postal_code']) ? $this->addressLineFormatter->format($response['shipping']['address']['postal_code']) : '');
        $address->setFirstname(isset($response['payer']['name']['given_name']) ? $this->addressLineFormatter->format($response['payer']['name']['given_name']) : '');
        $address->setLastname(isset($response['payer']['name']['surname']) ? $this->addressLineFormatter->format($response['payer']['name']['surname']) : '');
        $address->setPhone(isset($response['payer']['phone']['phone_number']['national_number']) ? $this->addressLineFormatter->format($response['payer']['phone']['phone_number']['national_number']) : '');

        if (!$address->isValid()) {
            return null;
        }

        return $address;
    }
}
