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

class payorcPaymentModuleFrontController extends ModuleFrontController
{
  public $ssl = true;
  public function __construct()
  {
    parent::__construct();
    $this->context = Context::getContext();
    $this->payorc = Module::getInstanceByName('payorc');
  }

  /**
   * @see FrontController::initContent()
   */
  public function initContent()
  {

    parent::initContent();

    if ($this->payorc && $this->payorc->active) {
      $this->context = Context::getContext();

      if (Tools::getIsset('cart_id')) {
        $order_exists = (int) Order::getOrderByCartId(Tools::getValue('cart_id'));
        if ($order_exists > 0)
          die(json_encode(array('code' => 1)));
      }

      $response = $this->create();
      if ($response['status'] === true) {
        $payorc_gate = json_decode($response['response'], 1);
        if ($payorc_gate['status'] == "SUCCESS") {
          die(json_encode(array('code' => 2, 'payorc_gate' => $payorc_gate)));
        } else {
          die(json_encode(array('code' => 1)));
        }
      } else {
        die(json_encode(array('code' => 1, 'error' => $response['response'])));
      }
    }
  }

  public function create()
  {
    $order_details = Tools::getValue("order_details");
    $customer_details = Tools::getValue("customer_details");
    $billing_details = Tools::getValue("billing_details");
    $shipping_details = Tools::getValue("shipping_details");
    $success_url = "";
    $cancel_url = "";
    if (Configuration::get('PAYORC_ALLOW_CARDS') == 2) {
      $success_url = Tools::getValue("success_url");
      $cancel_url = Tools::getValue("order_cancel_url");
    }
    $action = "AUTH";
    if (Configuration::get('PAYORC_ACTION') == 2) {
      $action = "SALE";
    }
    $capture_method = Tools::getValue("capture_method");
    $method = "MANUAL";
    if ($capture_method == 2) {
      $method = "AUTOMATIC";
    }
    $platform = [
      "platform" => Tools::getValue('platform'),
      "browser" => Tools::getValue('browserName'),
      "browser-version" => Tools::getValue('browserVersion'),
    ];
    $po_order = [
      "data" => [
        "class" => "ECOM",
        "action" => $action,
        "capture_method" => $method,
        "payment_token" => "",
        "order_details" => $order_details,
        "customer_details" => $customer_details,
        "billing_details" => $billing_details,
        "shipping_details" => $shipping_details,
        "urls" => [
          "success" => $success_url,
          "cancel" => $cancel_url,
          "failure" => $success_url
        ],
        "parameters" => [
          ["alpha" => ""],
          ["beta" => ""],
          ["gamma" => ""],
          ["delta" => ""],
          ["epsilon" => ""]
        ],
        "custom_data" => [
          ["alpha" => ""],
          ["beta" => ""],
          ["gamma" => ""],
          ["delta" => ""],
          ["epsilon" => ""]
        ]
      ]
    ];
    return $this->payorc->makeCurlRequest($this->payorc->url . "/sdk/orders/create", "POST", $po_order, 0 , $platform);
  }
}