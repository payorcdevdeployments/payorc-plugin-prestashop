{*
* 2007-2021 PrestaShop
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
*	@author PrestaShop SA <contact@prestashop.com>
*	@copyright	2007-2021 PrestaShop SA
*	@license		http://opensource.org/licenses/afl-3.0.php	Academic Free License (AFL 3.0)
*	International Registered Trademark & Property of PrestaShop SA
*}

<div id="payorc-translations">
    <span id="payorc-missing">{l s='There is no card on a customer that is being charged.' mod='payorc'}</span>
    <span id="payorc-processing_error">{l s='An error occurred while processing the card.' mod='payorc'}</span>
    <span id="payorc-payment_method_not_available">{l s='The payment method is currently not available. Please use another payment method to proceed.' mod='payorc'}</span>
    <span id="payorc-rate_limit">{l s='An error occurred due to requests hitting the API too quickly. Please let us know if you\'re consistently running into this error.' mod='payorc'}</span>
    <span id="payorc-3d_declined">{l s='The card doesn\'t support 3DS.' mod='payorc'}</span>
    <span id="payorc-3d_required">{l s='3D Secure is required to process the payment.' mod='payorc'}</span>
    <span id="payorc-no_api_key">{l s='There\'s an error with your API keys. If you\'re the administrator of this website, please go on the "Connection" tab of your plugin.' mod='payorc'}</span>
    <span id="payorc-timeout">{l s='Request timed out, please try again..' mod='payorc'}</span>
    <span id="payorc-please-fix">{l s='Please fix it and submit your payment again.' mod='payorc'}</span>
</div>
<div id="payorc-ajax-loader-redirect"><div class="spinner-border"></div> {l s='Do not press BACK or REFRESH while processing...' mod='payorc'}</div>      
<div id="modal-payorc-error" class="modal" style="display: none">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <p class="payorc-payment-europe-errors"></p>
</div>
<div id="payorc-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div id="payorc-loader"><img src="{$baseDir}modules/payorc/views/img/spinner-loader.gif" width="60px" height="60px"></div>
    <iframe id="pay_link" src="" style="height:85vh;width: 100%;border: none;border-radius: 10px;"></iframe> 
  </div>
</div>
<script type="text/javascript">
  var mode = {$PAYORC_MODES|escape:'htmlall':'UTF-8'};
  var ps_cart_id = "{$ps_cart_id|escape:'htmlall':'UTF-8'}";
  var logo_url = "{$logo_url|escape:'htmlall':'UTF-8'}";
  var shop_name = "{Configuration::get('PS_SHOP_NAME')|escape:'htmlall':'UTF-8'}";
  var lang_iso_code = "{$lang_iso_code|escape:'htmlall':'UTF-8'}";
  var amount_ttl = {$amount_ttl|escape:'htmlall':'UTF-8'};
  var order_items = {$order_items|escape nofilter};
  var baseDir = "{$baseDir|escape:'htmlall':'UTF-8'}";
  var customer_details = "{$customer_details}";
  var billing_address = {$billing_address|escape nofilter};
  var ship_address = {$ship_address|escape nofilter};
  var module_dir = "{$module_dir|escape:'htmlall':'UTF-8'}";
  var payorc_allow_cards = {$payorc_allow_cards|escape:'htmlall':'UTF-8'};
  var payorc_action = {$payorc_action|escape:'htmlall':'UTF-8'};
  var payorc_capture_method = {$payorc_capture_method|escape:'htmlall':'UTF-8'};
  var validation_url = "{$order_validation_url|escape:'htmlall':'UTF-8'}";
  var cancel_url = "{$order_cancel_url|escape:'htmlall':'UTF-8'}";
  var payorc_error = "{$payorc_error|escape:'htmlall':'UTF-8'}";
  var payorc_error_msg = "{l s='An error occured during transaction. Please try again or contact us' mod='payorc'}";
  var ajax_payment = "{$ajax_payment|escape nofilter}";
  var confirm_unload_msg = "{l s='If you leave now, the transaction may not finalize. Are you sure?' mod='payorc'}";
</script>