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
$sql = array();

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'payorc_transaction` (`id_payorc` int(11) NOT NULL AUTO_INCREMENT,
            `type` enum("payment","refund") NOT NULL DEFAULT "payment",
            `source_type` varchar(16) NOT NULL DEFAULT "card",
            `p_request_id` VARCHAR(100), 
            `m_payment_token` varchar(120),
            `p_order_id` VARCHAR(100),
            `id_customer` int(10), 
            `id_cart` int(10), 
            `id_order` int(10), 
            `transaction_id` varchar(32), 
            `amount` float(20,6), 
            `status` varchar(32) NOT NULL DEFAULT "pending",
            `response` TEXT NULL, 
            `currency` varchar(3), 
            `cc_schema` varchar(16),
            `cc_type` varchar(16), 
            `cc_mask` varchar(30), 
            `mode` enum("live","test"), 
            `date_add` datetime, 
            PRIMARY KEY (`id_payorc`)) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';

foreach ($sql as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
