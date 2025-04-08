<?php
/**
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
 */
class PayorcValidationModuleFrontController extends ModuleFrontController
{
    /**
     * This class should be use by your Instant Payment
     * Notification system to validate the order remotely
     */

    public function postProcess()
    {
        /*
         * If the module is not active anymore, no need to process anything.
         */
        if ($this->module->active == false) {
            die;
        }

        if(!isset($this->context->customer->id)) {
            $this->restoreCustomer();
        }

        $id_cart = (int) Tools::getValue("id_cart");
        $secure_key = Context::getContext()->customer->secure_key;
        $amount = Tools::getValue("amount");

        $message = array();

        if ($this->isValidOrder() === true) {
            $payment_status = Configuration::get('PAYORC_PAYMENT_ORDER_STATUS');
        } else {
            $payment_status = Configuration::get('PAYORC_CHARGEBACKS_ORDER_STATUS');
            $message = $this->module->l('Payment is failed, please check with the merchant');
        }

        $this->storePaymentInfo();

        $module_name = $this->module->displayName;
        $currency_id = (int) Context::getContext()->currency->id;

        $order_id = $this->module->createOrder($id_cart, $payment_status, $amount, $module_name, $message, $currency_id, $secure_key);
        $order_conf_url = Context::getContext()->link->getPageLink('order-confirmation',true,null,array('id_cart' => $id_cart,'id_module' => (int)$this->module->id,'id_order' => $order_id,'key' =>$secure_key));
        
        if(Tools::getValue("ajax") == 1) {
            die(json_encode(array("order_conf_url" => $order_conf_url)));
        }
        Tools::redirect($order_conf_url);
        return true;
    }

    protected function isValidOrder()
    {
        $status_code = Tools::getValue("status_code");
        $status = Tools::getValue("status");

        if ($status_code == 0 && $status == "SUCCESS") {
            return true;
        }

        return false;
    }

    protected function restoreCustomer()
    {
        $id_cart = (int) Tools::getValue("id_cart");
        Context::getContext()->cart = new Cart((int) $id_cart);
        Context::getContext()->customer = new Customer((int) Context::getContext()->cart->id_customer);
        Context::getContext()->customer->logged = true;
        $customer = Context::getContext()->customer;
        $this->context->cookie->id_customer = (int) $customer->id;
        $this->context->cookie->customer_lastname = $customer->lastname;
        $this->context->cookie->customer_firstname = $customer->firstname;
        $this->context->cookie->logged = true;
        $this->context->cookie->check_cgv = false;
        $this->context->cookie->is_guest = $customer->isGuest();
        $this->context->cookie->passwd = $customer->passwd;
        $this->context->cookie->email = $customer->email;
        $this->context->cookie->id_guest = (int) Context::getContext()->cart->id_guest;
        $this->context->cookie->id_cart = $id_cart;
        Context::getContext()->currency = new Currency((int) Context::getContext()->cart->id_currency);
        Context::getContext()->language = new Language((int) Context::getContext()->customer->id_lang);
    }

    protected function storePaymentInfo()
    {
        $data = [
            'type' => 'payment',
            'source_type' => 'card',
            'p_request_id' => isset($_POST['p_request_id']) ? $_POST['p_request_id'] : null,
            'm_payment_token' => isset($_POST['m_payment_token']) ? $_POST['m_payment_token'] : null,
            'p_order_id' => isset($_POST['p_order_id']) ? $_POST['p_order_id'] : null,
            'id_customer' => isset($_POST['m_customer_id']) ? $_POST['m_customer_id'] : null,
            'id_cart' => $this->context->cart->id,
            'id_order' => null,
            'transaction_id' => isset($_POST['transaction_id']) ? $_POST['transaction_id'] : null,
            'amount' => isset($_POST['amount']) ? $_POST['amount'] : null,
            'status' => isset($_POST['status']) ? $_POST['status'] : 'pending',
            'response' => isset($_POST) ? json_encode($_POST) : NULL,
            'currency' => isset($_POST['currency']) ? $_POST['currency'] : null,
            'cc_schema' => isset($_POST['payment_method_data']['scheme']) ? $_POST['payment_method_data']['scheme'] : null,
            'cc_type' => isset($_POST['payment_method_data']['card_type']) ? $_POST['payment_method_data']['card_type'] : null,
            'cc_mask' => isset($_POST['payment_method_data']['mask_card_number']) ? $_POST['payment_method_data']['mask_card_number'] : null,
            'mode' => isset($_POST['mode']) ? $_POST['mode'] : 'test',
            'date_add' => date('Y-m-d H:i:s'),
        ];
        $this->module->processPayment($data, $this->context->cart->id);
    }
}
