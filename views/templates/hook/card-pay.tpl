{*
* 2007-2025 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2025 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="payment_module payorc-payment-17" {if Configuration::get('PAYORC_MODES')} style="display: none;" {/if}>
{if !Configuration::get('PAYORC_MODES')}
    <div class="alert alert-info">Please use below test card info in test mode:<br> 
    <strong>4012 0010 3714 1112</strong> (for success payment)<br>
    <strong>4012 0010 3716 7778</strong> (3D Secure authentication) <br>
    You can use any expiry date as 01/30 and CVC code as 123 for card.</div>
{/if}
<div id="payment-success" class="success alert alert-success" style="display:none">{l s='Payment successful! Creating your order now...' mod='payorc'}</div>
<div id="checkout-success" class="success alert alert-success" style="display:none">{l s='Payment token created, redirecting to PayOrc Checkout...' mod='payorc'}</div>
<div id="payorc-ajax-loader"><div class="spinner-border"></div> {l s='Do not press BACK or REFRESH while processing...' mod='payorc'}</div>

<form action="" method="post" id="payorc-payment-form" style="display: none;">
    <input type="hidden" name="selected_pm" id="selected_pm" value="1" />
    <div id="card-errors" role="alert"></div>
</form>

</div>