<!--**
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
 *-->
<template>
  <b-card no-body class="mt-2">
    <template v-slot:header>
      <i class="material-icons">construction</i>
      {{ $t('panel.payment-mode.title') }}
    </template>
    <b-card-body>
      <b-button
        id="qa-onboard"
        :href="getPayPalOnboardingMockLink"
        variant="link"
        class="px-0"
      >
        Mock PayPal onboarding
      </b-button>
    </b-card-body>
  </b-card>
</template>

<script>
  export default {
    computed: {
      getPayPalOnboardingMockLink() {
        return this.$store.state.paypal.mockOnboardURL;
      }
    }
  };
</script>
