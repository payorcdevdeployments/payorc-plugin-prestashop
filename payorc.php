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

if (!defined('_PS_VERSION_')) {
    exit;
}

class Payorc extends PaymentModule
{
    protected $config_form = false;

    public $url = "https://nodeserver.payorc.com/api/v1";

    protected $countries=["AW"=>"297","AF"=>"93","AO"=>"244","AI"=>"1-264","AX"=>"358-18","AL"=>"355","AD"=>"376","AR"=>"54","AM"=>"374","AS"=>"1-684","AQ"=>"672","TF"=>"262","AG"=>"1-268","AU"=>"61","AT"=>"43","AZ"=>"994","BI"=>"257","BE"=>"32","BJ"=>"229","BQ"=>"599","BF"=>"226","BD"=>"880","BG"=>"359","BH"=>"973","BS"=>"1-242","BA"=>"387","BL"=>"590","BY"=>"375","BZ"=>"501","BM"=>"1-441","BO"=>"591","BR"=>"55","BB"=>"1-246","BN"=>"673","BT"=>"975","BV"=>"47","BW"=>"267","CF"=>"236","CA"=>"1","CC"=>"61","CH"=>"41","CL"=>"56","CN"=>"86","CI"=>"225","CM"=>"237","CD"=>"243","CG"=>"242","CK"=>"682","CO"=>"57","KM"=>"269","CV"=>"238","CR"=>"506","CU"=>"53","CW"=>"599","CX"=>"61","KY"=>"1-345","CY"=>"357","CZ"=>"420","DE"=>"49","DJ"=>"253","DM"=>"1-767","DK"=>"45","DO"=>"1-809","DZ"=>"213","EC"=>"593","EG"=>"20","ER"=>"291","EH"=>"212","ES"=>"34","EE"=>"372","ET"=>"251","FI"=>"358","FJ"=>"679","FK"=>"500","FR"=>"33","FO"=>"298","FM"=>"691","GA"=>"241","GB"=>"44","GE"=>"995","GG"=>"44","GH"=>"233","GI"=>"350","GN"=>"224","GP"=>"590","GM"=>"220","GW"=>"245","GQ"=>"240","GR"=>"30","GD"=>"1-473","GL"=>"299","GT"=>"502","GF"=>"594","GU"=>"1-671","GY"=>"592","HK"=>"852","HM"=>"61","HN"=>"504","HR"=>"385","HT"=>"509","HU"=>"36","ID"=>"62","IM"=>"44","IN"=>"91","IO"=>"246","IE"=>"353","IR"=>"98","IQ"=>"964","IS"=>"354","IL"=>"972","IT"=>"39","JM"=>"1-876","JE"=>"44","JO"=>"962","JP"=>"81","KZ"=>"7","KE"=>"254","KG"=>"996","KH"=>"855","KI"=>"686","KN"=>"1-869","KR"=>"82","KW"=>"965","LA"=>"856","LB"=>"961","LR"=>"231","LY"=>"218","LC"=>"1-758","LI"=>"423","LK"=>"94","LS"=>"266","LT"=>"370","LU"=>"352","LV"=>"371","MO"=>"853","MF"=>"590","MA"=>"212","MC"=>"377","MD"=>"373","MG"=>"261","MV"=>"960","MX"=>"52","MH"=>"692","MK"=>"389","ML"=>"223","MT"=>"356","MM"=>"95","ME"=>"382","MN"=>"976","MP"=>"1-670","MZ"=>"258","MR"=>"222","MS"=>"1-664","MQ"=>"596","MU"=>"230","MW"=>"265","MY"=>"60","YT"=>"262","NA"=>"264","NC"=>"687","NE"=>"227","NF"=>"672","NG"=>"234","NI"=>"505","NU"=>"683","NL"=>"31","NO"=>"47","NP"=>"977","NR"=>"674","NZ"=>"64","OM"=>"968","PK"=>"92","PA"=>"507","PN"=>"64","PE"=>"51","PH"=>"63","PW"=>"680","PG"=>"675","PL"=>"48","PR"=>"1-787","KP"=>"850","PT"=>"351","PY"=>"595","PS"=>"970","PF"=>"689","QA"=>"974","RE"=>"262","RO"=>"40","RU"=>"7","RW"=>"250","SA"=>"966","SD"=>"249","SN"=>"221","SG"=>"65","GS"=>"500","SH"=>"290","SJ"=>"47","SB"=>"677","SL"=>"232","SV"=>"503","SM"=>"378","SO"=>"252","PM"=>"508","RS"=>"381","SS"=>"211","ST"=>"239","SR"=>"597","SK"=>"421","SI"=>"386","SE"=>"46","SZ"=>"268","SX"=>"1-721","SC"=>"248","SY"=>"963","TC"=>"1-649","TD"=>"235","TG"=>"228","TH"=>"66","TJ"=>"992","TK"=>"690","TM"=>"993","TL"=>"670","TO"=>"676","TT"=>"1-868","TN"=>"216","TR"=>"90","TV"=>"688","TW"=>"886","TZ"=>"255","UG"=>"256","UA"=>"380","UM"=>"1","UY"=>"598","US"=>"1","UZ"=>"998","VA"=>"379","VC"=>"1-784","VE"=>"58","VG"=>"1-284","VI"=>"1-340","VN"=>"84","VU"=>"678","WF"=>"681","WS"=>"685","YE"=>"967","ZA"=>"27","ZM"=>"260","ZW"=>"263",];

    public function __construct()
    {
        $this->name = 'payorc';
        $this->tab = 'payments_gateways';
        $this->version = '1.0.0';
        $this->author = 'PayOrc';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('PayOrc');
        $this->description = $this->l('Collecting payments online from any part of the world using universe of payment Methods and We provide high Conversion, low Drop-Offs, low transaction Cost');

        $this->confirmUninstall = $this->l('Warning: all the customers cards token and transaction details saved in your database will be deleted. Are you sure you want uninstall this module?');

        // $this->limited_countries = array('FR');

        // $this->limited_currencies = array('EUR');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        if (extension_loaded('curl') == false)
        {
            $this->_errors[] = $this->l('You have to enable the cURL extension on your server to install this module');
            return false;
        }

        $iso_code = Country::getIsoById(Configuration::get('PS_COUNTRY_DEFAULT'));

        // if (in_array($iso_code, $this->limited_countries) == false)
        // {
        //     $this->_errors[] = $this->l('This module is not available in your country');
        //     return false;
        // }

        Configuration::updateValue('PAYORC_MODES', false);
        Configuration::updateValue('PAYORC_PUBLIC_KEY_TEST', '');
        Configuration::updateValue('PAYORC_PRIVATE_KEY_TEST', '');
        Configuration::updateValue('PAYORC_PUBLIC_KEY_LIVE', '');
        Configuration::updateValue('PAYORC_PRIVATE_KEY_LIVE', '');
        Configuration::updateValue('PAYORC_ALLOW_CARDS', 1);
        Configuration::updateValue('PAYORC_ACTION', 1);
        Configuration::updateValue('PAYORC_CAPTURE_MODE', 1);
        Configuration::updateValue('PAYORC_AWAITING_OS', '1');
        Configuration::updateValue('PAYORC_PAYMENT_ORDER_STATUS', '2');
        Configuration::updateValue('PAYORC_CHARGEBACKS_ORDER_STATUS', '8');
        Configuration::updateValue('PS_COOKIE_SAMESITE', 'None');

        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('payment') &&
            $this->registerHook('paymentReturn') &&
            $this->registerHook('paymentOptions') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayCustomerAccount') &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayOrderConfirmation') &&
            $this->registerHook('displayPayment');
    }

    public function uninstall()
    {
        Configuration::deleteByName('PAYORC_MODES', false);
        Configuration::deleteByName('PAYORC_PUBLIC_KEY_TEST', '');
        Configuration::deleteByName('PAYORC_PRIVATE_KEY_TEST', '');
        Configuration::deleteByName('PAYORC_PUBLIC_KEY_LIVE', '');
        Configuration::deleteByName('PAYORC_PRIVATE_KEY_LIVE', '');
        Configuration::deleteByName('PAYORC_ALLOW_CARDS', 1);
        Configuration::deleteByName('PAYORC_ACTION', 1);
        Configuration::deleteByName('PAYORC_CAPTURE_MODE', 1);
        Configuration::deleteByName('PAYORC_AWAITING_OS', '1');
        Configuration::deleteByName('PAYORC_PAYMENT_ORDER_STATUS', '2');
        Configuration::deleteByName('PAYORC_CHARGEBACKS_ORDER_STATUS', '8');

        include(dirname(__FILE__).'/sql/uninstall.php');

        @Db::getInstance()->Execute("DROP TABLE IF EXISTS `"._DB_PREFIX_."payorcjs_transaction`");

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {

        $errors = array();

        if (((bool)Tools::isSubmit('SubmitPayOrc')) == true) {
            $this->postProcessConfig();
        }

        if (((bool)Tools::isSubmit('SubmitPayOrcOrderTrans')) == true) {
            $this->postProcessFetchOrderTransaction();
        }

        if (((bool)Tools::isSubmit('SubmitOrderStatuses')) == true) {
            $this->postProcessStatuses();
        }

        $statuses = OrderState::getOrderStates((int)$this->context->cookie->id_lang);
        $statuses_options = array(
            array(
                'name' => 'PAYORC_AWAITING_OS', 
                'label' => $this->l('Order status for pending payments:'), 
                'current_value' => Configuration::get('PAYORC_AWAITING_OS')
            ),
            array(
                'name' => 'payorc_payment_status', 
                'label' => $this->l('Order status in case of sucessfull payment:'), 
                'current_value' => Configuration::get('PAYORC_PAYMENT_ORDER_STATUS')
            ),
            array(
                'name' => 'payorc_chargebacks_status', 
                'label' => $this->l('Order status in case of a Failed/ Canceled payment:'), 
                'current_value' => Configuration::get('PAYORC_CHARGEBACKS_ORDER_STATUS')
            )
        );

        $tplVars = array(
            'errors' => $errors,
            'statuses' => $statuses,
            'statuses_options' => $statuses_options,
            'module_dir' => $this->_path,
            'ps_version' => $this->version,
            'transactions' => $this->getTransactions(),
        );

        if (Tools::isSubmit('SubmitPayOrc') || Tools::isSubmit('SubmitOrderStatuses'))
            $tplVars['success'] = true;
        else
            $tplVars['success'] = false;

        $this->context->smarty->assign($tplVars);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output;
    }


    public function getTransactions($page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT * FROM "._DB_PREFIX_."payorc_transaction GROUP BY p_order_id ORDER BY id_payorc DESC";

        $transactions = Db::getInstance()->executeS($sql);

        $totalTransactions = (int) Db::getInstance()->getValue(
            'SELECT COUNT(*) FROM ' . _DB_PREFIX_ . 'payorc_transaction GROUP BY p_order_id ORDER BY id_payorc DESC'
        );

        $all_transactions = array();

        if(!empty($transactions)) {
            foreach($transactions as $transaction) {
                $customer = new Customer($transaction['id_customer']);
                $all_transactions[$transaction["id_payorc"]] = array(
                    'id_payorc' => $transaction["id_payorc"],
                    'p_order_id' => $transaction["p_order_id"],
                    'customer_email' => $customer->email,
                    'id_order' => $transaction['id_order'],
                    'transaction_id' => $transaction['transaction_id'],
                    'paid_amount' => Tools::ps_round($transaction['amount'], 2),
                    'status' => $transaction['status'],
                    'response' => $transaction['response'],
                    'date_add' => $transaction['date_add'],
                );
            }   
        }

        return [
            'transactions' => $all_transactions,
            'total' => $totalTransactions
        ];
    }

    /**
     * Save config form data.
     */
    protected function postProcessConfig()
    {
        $configuration_values = array(
            'PAYORC_MODES' => Tools::getValue('PAYORC_MODES'),
            'PAYORC_ACTION' => Tools::getValue('PAYORC_ACTION'),
            'PAYORC_ALLOW_CARDS' => Tools::getValue('PAYORC_ALLOW_CARDS'),
            'PAYORC_CAPTURE_MODE' => Tools::getValue('PAYORC_CAPTURE_MODE'),
            'PAYORC_PUBLIC_KEY_TEST' => trim(Tools::getValue('payorc_public_key_test')),
            'PAYORC_PUBLIC_KEY_LIVE' => trim(Tools::getValue('payorc_public_key_live')), 
            'PAYORC_PRIVATE_KEY_TEST' => trim(Tools::getValue('payorc_private_key_test')),
            'PAYORC_PRIVATE_KEY_LIVE' => trim(Tools::getValue('payorc_private_key_live')), 
        );

        foreach ($configuration_values as $configuration_key => $configuration_value)
            Configuration::updateValue($configuration_key, $configuration_value);
    }

    protected function postProcessFetchOrderTransaction() 
    {
        $message = 'No order transaction found';
        $id_order = Tools::getValue('order_id');
        
        $transaction = Db::getInstance()->getRow("SELECT * FROM "._DB_PREFIX_."payorc_transaction WHERE id_order =".(int) $id_order." ORDER BY id_payorc DESC");

        if(empty($transaction)) {
            $this->context->smarty->assign(array(
                'trans_message' => $message,
            ));
        } else {
            $this->context->smarty->assign(array(
                'transaction'=> $transaction,
            ));
        }
    }

    /**
     * Save status form data.
     */
    protected function postProcessStatuses()
    {
        $configuration_values = array(
            'PAYORC_AWAITING_OS' => (int)Tools::getValue('PAYORC_AWAITING_OS'),
            'PAYORC_PAYMENT_ORDER_STATUS' => (int)Tools::getValue('payorc_payment_status'),
            'PAYORC_CHARGEBACKS_ORDER_STATUS' => (int)Tools::getValue('payorc_chargebacks_status'),
        );

        foreach ($configuration_values as $configuration_key => $configuration_value)
            Configuration::updateValue($configuration_key, $configuration_value);
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    /**
     * This method is used to render the payment button,
     * Take care if the button should be displayed or not.
     */
    public function hookPayment($params)
    {
        /* $currency_id = $params['cart']->id_currency;
        $currency = new Currency((int)$currency_id);

        if (in_array($currency->iso_code, $this->limited_currencies) == false)
            return false; */

        $this->smarty->assign('module_dir', $this->_path);

        return $this->display(__FILE__, 'views/templates/hook/payment.tpl');
    }

    /**
     * This hook is used to display the order confirmation page.
     */
    public function hookPaymentReturn($params)
    {
        if ($this->active == false)
            return;
        
        $order = $params['order'];

        if ($order->getCurrentOrderState()->id != Configuration::get('PS_OS_ERROR'))
            $this->smarty->assign('status', 'ok');

        $this->smarty->assign(array(
            'id_order' => $order->id,
            'reference' => $order->reference,
            'params' => $params,
        ));

        return;
        // return $this->display(__FILE__, 'views/templates/hook/confirmation.tpl');
    }

    /**
     * Return payment options available for PS 1.7+
     *
     * @param array Hook parameters
     *
     * @return array|null
     */
    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return;
        }
        $payment_options = array();

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }

        if(!$this->checkCredentials()) {
            return;
        }

        /* Minimum payment condition */
        $o_ttl = $this->context->cart->getOrderTotal();
        if($o_ttl < 0.5) {
            $amt_warning = '<div class="alert alert-warning">'.$this->l('Cart total amount should be greater or equal to 50 cents to pay with cards.').'</div>';    
            $embeddedOption = new \PrestaShop\PrestaShop\Core\Payment\PaymentOption();
            $embeddedOption->setModuleName($this->name)
                           ->setCallToActionText($this->l('PayOrc - Pay with Visa / MasterCard / Amex / Apple Pay'))
                           ->setAdditionalInformation($amt_warning);
                        //    ->setLogo(Media::getMediaPath(_PS_MODULE_DIR_.$this->name.'/views/img/PayOrc.svg'));
            $payment_options[] = $embeddedOption;
            return $payment_options;
        }

        if(Configuration::get('PAYORC_ALLOW_CARDS') > 0) {
            $pm_text =  (Configuration::get('PAYORC_ALLOW_CARDS') ==1 ? 'PayOrc - Pay with Visa / MasterCard / Amex / Apple Pay' : 'PayOrc - Pay with Visa / MasterCard / Amex / Apple Pay');
            
            $embeddedOption = new \PrestaShop\PrestaShop\Core\Payment\PaymentOption();
            $embeddedOption->setModuleName($this->name)
                           ->setCallToActionText($this->l($pm_text))
                           ->setForm($this->display(__FILE__,'views/templates/hook/card-pay.tpl'))
                           ->setLogo(Media::getMediaPath(_PS_MODULE_DIR_.$this->name.'/views/img/PayOrc.svg'));
            $payment_options[] = $embeddedOption;
        }
        
        /* $option = new \PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $option->setCallToActionText($this->l('Pay offline'))
            ->setAction($this->context->link->getModuleLink($this->name, 'validation', array(), true)); */

        return $payment_options;
    }

    public function checkCurrency($cart)
    {
        $currency_order = new Currency($cart->id_currency);
        $currencies_module = $this->getCurrency($cart->id_currency);
        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }
        return false;
    }

    public function checkCredentials()
    {
        $merchent_key = Configuration::get('PAYORC_PUBLIC_KEY_TEST');
        $merchent_secret = Configuration::get('PAYORC_PRIVATE_KEY_TEST');
        $env = 'test';
        if(Configuration::get('PAYORC_MODES')) {
            $merchent_key = Configuration::get('PAYORC_PUBLIC_KEY_LIVE');
            $merchent_secret = Configuration::get('PAYORC_PRIVATE_KEY_LIVE');
            $env = 'live';
        }
        $data = array(
            'merchant_key' => $merchent_key,
            'merchant_secret' => $merchent_secret,
            'env' => $env
        );

        $response = $this->makeCurlRequest($this->url."/check/keys-secret", "POST", $data, 1);
        if($response['status'] === true) {
            return true;
        }
        return false;
    }

    public function hookDisplayCustomerAccount()
    {
        /* Place your code here. */
    }

    public function hookDisplayHeader()
    {
        $controller = Tools::getValue('controller');
        if ($controller == "order" || $controller == 'paymentcard') {
            $nbProducts = $this->context->cart->nbProducts();
            if($nbProducts<=0 || !$this->context->cookie->logged)
                return;
            $this->context->controller->addJS($this->_path.'views/js/front.js');
            $this->context->controller->addCSS($this->_path.'views/css/front.css');
            $this->context->smarty->assign($this->getTemplateVars());
            return $this->display(__FILE__, './views/templates/hook/payment_vars.tpl');
        }
    }

    public function getTemplateVars($checkCartInfo = false, $pm = false)
    {
        $amount = $this->context->cart->getOrderTotal();
        $currency = $this->context->currency->iso_code;
        $domain = Tools::getShopDomainSsl(true, true);
        $base_uri = $domain.__PS_BASE_URI__;
        $logo_url = $base_uri.'img/'.Configuration::get('PS_LOGO');
        if($amount < 0.5)
            return;
        
        $or_items = $this->context->cart->getSummaryDetails();
        $carrier = new Carrier($this->context->cart->id_carrier);
        $address_billing = new Address($this->context->cart->id_address_invoice);
        $address_delivery = new Address($this->context->cart->id_address_delivery);
        $billing_phone = $address_billing->phone ? $address_billing->phone : $address_billing->phone_mobile;
        $delivery_phone = $address_delivery->phone ? $address_delivery->phone : $address_delivery->phone_mobile;
        $customer_details = array(
            'name' => $this->context->customer->firstname . " " . $this->context->customer->lastname,
            'm_customer_id' => $this->context->customer->id,
            'email' => $this->context->customer->email,
            'mobile' => $billing_phone,
            'code' => isset($this->countries[Country::getIsoById($address_delivery->id_country)]) && !empty($billing_phone) ? $this->countries[Country::getIsoById($address_delivery->id_country)] : "",
        );
        $billing_address = array(
            'address_line1' => $address_billing->address1,
            'address_line2' => $address_billing->address2,
            'city' => $address_billing->city,
            'province' => $address_billing->city,
            'pin' => $address_billing->postcode,
            'country' => Country::getIsoById($address_billing->id_country),
        );
        $address_delivery = array(
            'shipping_name' => $carrier->name,
            'shipping_email' => "",
            'shipping_code' => isset($this->countries[Country::getIsoById($address_delivery->id_country)]) && !empty($delivery_phone) ? $this->countries[Country::getIsoById($address_delivery->id_country)] : "",
            'shipping_mobile' => $delivery_phone,
            'address_line1' => $address_delivery->address1,
            'address_line2' => $address_delivery->address2,
            'city' => $address_delivery->city,
            'province' => $address_delivery->city,
            'pin' => $address_delivery->postcode,
            'country' => Country::getIsoById($address_delivery->id_country),
            "location_pin" => "https://location/somepoint",
            "shipping_currency" => $currency,
            "shipping_amount" => $or_items['total_shipping'],
        );
        $order_items = array(
            "m_order_id" => "",
            "amount" => $amount - $or_items['total_shipping'],
            "convenience_fee" => "0",
            "currency" => $currency,
            "description" => ""
        );
        $quantity = 0;
        foreach($or_items['products'] as $p) {
            $quantity += $p['quantity'];
        }
        $order_items['quantity'] = $quantity;
                   
        return array(
            'customer_details' => json_encode($customer_details),
            'amount_ttl' => $amount,
            'ps_cart_id' => $this->context->cart->id,
            'order_items' => json_encode($order_items),
            'baseDir' => $domain.__PS_BASE_URI__,
            'PAYORC_MODES' => (int)Configuration::get('PAYORC_MODES'),
            'module_dir' => $this->_path,
            'billing_address' => json_encode($billing_address),
            'ship_address' => json_encode($address_delivery),
            'payorc_ps_version' => _PS_VERSION_,
            'payorc_allow_cards'  => Configuration::get('PAYORC_ALLOW_CARDS'),
            'payorc_action'  => Configuration::get('PAYORC_ACTION'),
            'payorc_capture_method'  => Configuration::get('PAYORC_CAPTURE_MODE'),
            'payorc_error' => (string)Tools::getValue('payorc_error'),
            'order_validation_url' => $this->context->link->getModuleLink($this->name, 'validation', array('content_only'=>1, "id_cart" => $this->context->cart->id), true),
            'order_cancel_url' => $this->context->link->getPageLink('order', true),
            'lang_iso_code' => $this->context->language->iso_code,
            'logo_url' => $logo_url,
            'ajax_payment' => $this->context->link->getModuleLink($this->name, 'payment', array(), true),
        );
    }

    public function hookDisplayOrderConfirmation($params)
    {
        $order = $params['order'];
        $payment_status = Configuration::get('PAYORC_CHARGEBACKS_ORDER_STATUS');
        if($order->current_state == $payment_status) {
            $this->context->smarty->assign(['error' => $order->getFirstMessage()]);
            return $this->display(__FILE__, './views/templates/hook/error_payment.tpl');
        }
    }

    public function hookDisplayPayment()
    {
        /* Place your code here. */
    }

    /**
     * Common cURL request function
     * 
     * @param string $url - The URL to send the request to
     * @param string $method - HTTP method (GET or POST)
     * @param array|null $data - Data to send with the request (for POST only)
     * @param array|null $headers - request headers (for POST only)
     * @return array - The response from the cURL request
     */
    public function makeCurlRequest($url, $method = "GET", $data = null, $auth = 1, $platform = [])
    {
        $merchent_key = Configuration::get('PAYORC_PUBLIC_KEY_TEST');
        $merchent_secret = Configuration::get('PAYORC_PRIVATE_KEY_TEST');
        if(Configuration::get('PAYORC_MODES')) {
            $merchent_key = Configuration::get('PAYORC_PUBLIC_KEY_LIVE');
            $merchent_secret = Configuration::get('PAYORC_PRIVATE_KEY_LIVE');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        if($auth == 1) {
            $headers = [
                "Content-Type: application/json",
            ];
        } 

        if($auth == 0) {
            $headers= [
                "sdk: Prestashop",
                "sdk-version: " . _PS_VERSION_,
                "Content-Type: application/json",
                "merchant-key: " . $merchent_key,
                "merchant-secret: " . $merchent_secret,
                "platform:".$platform['platform'],
                "browser:".$platform['browser'],
                "browser-version:".$platform['browser-version'],
            ];
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method == "GET") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        }

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);

        if ($httpcode != 200) {
            return array('status' => false, 'response' => $response);
        }

        return array('status' => true, 'response' => $response);
    }

    public function processPayment($data, $id_cart)
    { 
        $columns = implode(', ', array_keys($data));
        $values = array_map(function($value) {
            return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
        }, $data);
        $values = implode(', ', $values);
        $isPresent = Db::getInstance()->getValue("SELECT id_payorc FROM "._DB_PREFIX_."payorc_transaction WHERE id_cart = ".$id_cart);
        if($isPresent) {
            return true;
        }
        $result = Db::getInstance()->execute("INSERT INTO "._DB_PREFIX_."payorc_transaction ($columns) VALUES ($values)");
        return $result;
    }

    public function createOrder($id_cart, $payment_status, $amount, $module_name, $message, $currency_id, $secure_key) 
    {
        $id_order = (int)Order::getOrderByCartId($id_cart);
        if($id_order > 0)
            return $id_order;
        try {
            ob_start();    
            parent::validateOrder($id_cart, $payment_status, $amount, $module_name, $message, array(), $currency_id, false, $secure_key);
            ob_flush();
        } catch (PrestaShopException $e) {
            Logger::addLog((string)$e->getMessage(), 4, null, 'Cart', $id_cart, true);
        }
        $id_order = (int)Order::getOrderByCartId($id_cart);
        Db::getInstance()->execute("UPDATE "._DB_PREFIX_."payorc_transaction SET id_order = ".$id_order." WHERE id_cart = ".$id_cart);
        return $id_order;
    }
}
