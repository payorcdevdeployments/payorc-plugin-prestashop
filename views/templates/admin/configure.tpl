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
<script type="text/javascript">
	$(document).ready(function() {
		$("input[name='PAYORC_MODES']").change(function(e) {
			$('#payorc_test_keys,#payorc_live_keys').toggle();
		});
		$("input[name='PAYORC_ALLOW_CARDS']").change(function(e) {
			if (this.value == 2)
				$('#payorcCheckoutOrder').fadeIn();
			else
				$('#payorcCheckoutOrder').hide();
		});
		$(".payorc-module-wrapper .list-group .list-group-item").click(function() {
			$(".list-group .list-group-item").removeClass("active");
			$(this).addClass("active");
			var ID = $(this).attr("id");
			$(".payorc-module-wrapper fieldset").removeClass("show");
			$(".payorc-module-wrapper fieldset." + ID).addClass("show");
		});
	});
</script>
{if $success}
	<div class="conf confirmation alert alert-success">{l s='Settings successfully saved' mod='payorc'}</div>
{/if}
<div class="tabs payorc-module-wrapper">
	<div class="sidebar navigation col-md-3 col-lg-3">
		<nav class="list-group categorieList">
			<a class="list-group-item active" id="payorc_post_order" href="javascript:void();"><i
				class="icon-filter tabcbpfw-icon"></i>{l s='Transactions' mod='payorc'}</a>
			<a class="list-group-item" id="payorc_settings" href="javascript:void();"><i
					class="icon-power-off tabcbpfw-icon"></i>{l s='PayOrc Configuration' mod='payorc'}
				<a class="list-group-item" id="order_statuses" href="javascript:void();"><i
						class="icon-filter tabcbpfw-icon"></i>{l s='Order Statuses' mod='payorc'}</a>
				<a class="list-group-item" id="payorc_webhooks" href="javascript:void();"><i
						class="icon-question tabcbpfw-icon"></i>{l s='Test Cards' mod='payorc'}</a>
				<br />
				<br />
		</nav>
	</div>
	<div class="panel content-wrap form-horizontal col-md-9 col-lg-9">
		<form method="post" action="">
			<div class="clear"></div>
			<fieldset class="payorc_post_order show">
				<h3 class="tab">&nbsp;&nbsp;<i class="icon-money"></i>&nbsp;
					{l s='Order Transactions' mod='payorc'}
				</h3>
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead class="payorc-table-header">
							<tr>
								<th>Sno</th>
								<th>Payorc Order ID</th>
								<th>Customer Email</th>
								<th>ID Order</th>
								<th>Transaction ID</th>
								<th>Paid Amount</th>
								<th>Status</th>
								<th>Response</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody class="payorc-table-body">
							{if $transactions['transactions']}
								{foreach from=$transactions['transactions'] item=transaction}
									<tr>
										<td>{$transaction['id_payorc']}</td>
										<td>{$transaction['p_order_id']}</td>
										<td>{$transaction['customer_email']}</td>
										<td>{$transaction['id_order']}</td>
										<td>{$transaction['transaction_id']}</td>
										<td>{$transaction['paid_amount']}</td>
										<td>{$transaction['status']}</td>
										<td>{$transaction['response']}</td>
										<td>{$transaction['date_add']}</td>
									</tr>
								{/foreach}
							{else}
								<tr>
									<td colspan="9">{l s='No transactions found' mod='payorc'}</td>
								</tr>
							{/if}
						</tbody>
					</table>
				</div>
				{*<div id="ordeer_transaction">
					<div class="form-group">
						<label class="control-label col-lg-4" for="order_id">
							{l s='Order ID' mod='payorc'}:</label>
						<div class="col-lg-6">
							<input type="text" name="order_id" />
						</div>
					</div>
				</div>
				{if isset($trans_message)}
					<div class="alert {if $trans_success}alert-success{else}alert-danger{/if}">
						<p> <i class="{if $trans_success}icon-check{else}icon-times{/if}"></i> {$trans_message}</p>
					</div>
				{/if}
				{if isset($transaction)}
					<div class="transaction-details panel">
						<div class="panel-heading">
							<h4>{l s='Transaction Details' mod='payorc'}</h4>
						</div>
						<div class="panel-body">
							<pre class="json-response">
								{assign var="response" value=$transaction['response']}
								{$response|replace:',':',
								'|replace:'{':'{ 
								'|replace:'}':' 
								}'|replace:'[':'[
								'|replace:']':'
								]'}
							</pre>
						</div>
					</div>
				{/if}
				<div class="panel-footer">
					<button type="submit" name="SubmitPayOrcOrderTrans" class="btn btn-default pull-right"><i
							class="process-icon-save"></i> {l s='Save' mod='payorc'}</button>
				</div>
				<br />
				<br />*}
			</fieldset>
		</form>
		<form action="" method="post">
			<fieldset class="payorc_settings">
				<h3 class="tab"> &nbsp;&nbsp;<i class="icon-power-off"></i>&nbsp;{l s='PayOrc Connection' mod='payorc'}
				</h3>
				<div class="form-group">
					<label class="control-label col-lg-4" for="simple_product">
						{l s='Mode' mod='payorc'}:</label>
					<div class="col-lg-8">
						<span class="switch prestashop-switch fixed-width-lg">
							<input type="radio" name="PAYORC_MODES" id="PAYORC_MODES_1" value="1"
								{if Configuration::get('PAYORC_MODES')}checked="checked" {/if}>
							<label for="PAYORC_MODES_1">
								{l s='LIVE' mod='payorc'}</label>
							<input type="radio" name="PAYORC_MODES" id="PAYORC_MODES_0" value="0"
								{if !Configuration::get('PAYORC_MODES')}checked="checked" {/if}>
							<label for="PAYORC_MODES_0">
								{l s='TEST' mod='payorc'}</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div {if Configuration::get('PAYORC_MODES')}style="display:none;" {/if} id="payorc_test_keys">
					<div class="form-group">
						<label class="control-label col-lg-4" for="simple_product">
							{l s='Merchant Key' mod='payorc'}:</label>
						<div class="col-lg-6">
							<input type="text" name="payorc_public_key_test"
								value="{Configuration::get('PAYORC_PUBLIC_KEY_TEST')|escape:'htmlall':'UTF-8'}" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4" for="simple_product">
							{l s='Merchant Secret' mod='payorc'}:</label>
						<div class="col-lg-6">
							<input type="password" name="payorc_private_key_test"
								value="{Configuration::get('PAYORC_PRIVATE_KEY_TEST')|escape:'htmlall':'UTF-8'}" />
						</div>
					</div>
				</div>
				<div {if !Configuration::get('PAYORC_MODES')}style="display:none;" {/if} id="payorc_live_keys">
					<div class="form-group">
						<label class="control-label col-lg-4" for="simple_product">
							{l s='Merchant Key' mod='payorc'}:</label>
						<div class="col-lg-6">
							<input type="text" name="payorc_public_key_live"
								value="{Configuration::get('PAYORC_PUBLIC_KEY_LIVE')|escape:'htmlall':'UTF-8'}" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4" for="simple_product">
							{l s='Merchant Secret' mod='payorc'}:</label>
						<div class="col-lg-6">
							<input type="password" name="payorc_private_key_live"
								value="{Configuration::get('PAYORC_PRIVATE_KEY_LIVE')|escape:'htmlall':'UTF-8'}" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-4" for="simple_product">
						{l s='Action:' mod='payorc'}</label>
					<div class="col-lg-8">
						<input type="radio" name="PAYORC_ACTION" id="ac_c" value="1"
							{if Configuration::get('PAYORC_ACTION')==1} checked="checked" {/if} /> &nbsp;
						<label class="control-label" for="ac_c"
							title="{l s='Payment payment authentication.' mod='payorc'}"><b>
								{l s='AUTH' mod='payorc'}</b></label>
						<input type="radio" name="PAYORC_ACTION" id="payorca_c" value="2"
							{if Configuration::get('PAYORC_ACTION')==2} checked="checked" {/if} /> &nbsp;
						<label class="control-label" for="payorca_c"
							title="{l s='Payment option is openend in the new standalone page.' mod='payorc'}"><b>
								{l s='SALE' mod='payorc'}</b></label>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-4" for="simple_product">
						{l s='Accept Payment via:' mod='payorc'}</label>
					<div class="col-lg-8">
						<input type="radio" name="PAYORC_ALLOW_CARDS" id="cc_c" value="1"
							{if Configuration::get('PAYORC_ALLOW_CARDS')==1} checked="checked" {/if} /> &nbsp;
						<label class="control-label" for="cc_c"
							title="{l s='Payment option is opened in the iframe.' mod='payorc'}"><b>
								{l s='PayOrc Embedded Solution' mod='payorc'}</b></label>
						<input type="radio" name="PAYORC_ALLOW_CARDS" id="payorc_c" value="2"
							{if Configuration::get('PAYORC_ALLOW_CARDS')==2} checked="checked" {/if} /> &nbsp;
						<label class="control-label" for="payorc_c"
							title="{l s='Payment option is openend in the new standalone page.' mod='payorc'}"><b>
								{l s='PayOrc Hosted Solution' mod='payorc'}</b></label>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-lg-4" for="simple_product">
						{l s='Capture method (For AUTH only):' mod='payorc'}</label>
					<div class="col-lg-8">
						<input type="radio" name="PAYORC_CAPTURE_MODE" id="payorc_cm" value="1"
							{if Configuration::get('PAYORC_CAPTURE_MODE')==1} checked="checked" {/if} /> &nbsp;
						<label class="control-label" for="payorc_cm"
							title="{l s='Capture payment manually.' mod='payorc'}"><b>
								{l s='MANUAL' mod='payorc'}</b></label>
						<input type="radio" name="PAYORC_CAPTURE_MODE" id="payorc_ccm" value="2"
							{if Configuration::get('PAYORC_CAPTURE_MODE')==2} checked="checked" {/if} /> &nbsp;
						<label class="control-label" for="payorc_ccm"
							title="{l s='Capture payment automatically.' mod='payorc'}"><b>
								{l s='AUTOMATIC' mod='payorc'}</b></label>
					</div>
				</div>
				<div class="panel-footer">
					<button type="submit" name="SubmitPayOrc" class="btn btn-default pull-right"><i
							class="process-icon-save"></i> {l s='Save' mod='payorc'}</button>
				</div>
			</fieldset>
		</form>
		<form method="post" action="">
			<fieldset class="order_statuses">
				<h3 class="tab">&nbsp;&nbsp;<i class="icon-filter"></i>&nbsp;{l s='Order Statuses' mod='payorc'}</h3>
				{foreach $statuses_options as $status_options}
					<div class="form-group">
						<label class="control-label col-lg-6"
							for="simple_product">{$status_options['label']|escape:'htmlall':'UTF-8'}</label>
						<div class="col-lg-5">
							<select name="{$status_options['name']|escape:'htmlall':'UTF-8'}" style="width:auto">
		                            {foreach $statuses as $status}
			                            <option value="{$status['id_order_state']|escape:'htmlall':'UTF-8'}" {if $status['id_order_state']==$status_options[ 'current_value']} selected="selected" {/if}>
			                                {$status['name']|escape:'htmlall':'UTF-8'}
										</option>

								{/foreach}
		                        </select>
							</div>
						</div>
					{/foreach}
					<div class="panel-footer">
						<button type="submit" name="SubmitOrderStatuses" class="btn btn-default pull-right"><i
								class="process-icon-save"></i> {l s='Save' mod='payorc'}</button>
					</div>
				</fieldset>
			</form>
			<form method="post" action="">
				<div class="clear"></div>
				<fieldset class="payorc_webhooks">
					<h3 class="tab">&nbsp;&nbsp;<i class="icon-money"></i>&nbsp;
						{l s='Card numbers for testing' mod='payorc'}
					</h3>
					<table cellspacing="0" cellpadding="0" class="payorc-cc-numbers" width="100%">
						<thead>
							<tr>
								<th>
									{l s='Number' mod='payorc'}
								</th>
								<th>
									{l s='Card type' mod='payorc'}
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="number">Cards Payment</td>
								<td><code>Expiration Date - 01/30</code> && <code>CVV - 123</code></td>
							</tr>
							<tr>
								<td class="number"><code>4012 0010 3714 1112</code></td>
								<td>Visa</td>
							</tr>
							<tr>
								<td class="number"><code>4012 0010 3716 7778</code></td>
								<td>Visa (3D-Secure authentication required)</td>
							</tr>
							<tr>
								<td class="number"><code>5168 4412 2363 0339</code></td>
								<td>MasterCard (3D-Secure authentication required)</td>
							</tr>
							<tr>
								<td class="number"><code>5457 2100 0100 0019</code></td>
								<td>MasterCard</td>
							</tr>
						</tbody>
					</table>
					<br />
					<br />
				</fieldset>
			</form>
		</div>
	</div>