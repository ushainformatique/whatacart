/*----Address table----*/
ALTER TABLE `tbl_address` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_address` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_address` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_address` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_address` MODIFY `relatedmodel_id` int(11) DEFAULT NULL;
ALTER TABLE `tbl_address` MODIFY `relatedmodel` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_address` MODIFY `status` smallint(1) DEFAULT NULL;
ALTER TABLE `tbl_address` MODIFY `type` smallint(1) DEFAULT NULL;

/*-----Auth assignment table------------*/
ALTER TABLE `tbl_auth_assignment` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_auth_assignment` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_auth_assignment` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_auth_assignment` MODIFY `modified_datetime` datetime DEFAULT NULL;

/*-----Auth permission table------------*/
ALTER TABLE `tbl_auth_permission` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_auth_permission` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_auth_permission` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_auth_permission` MODIFY `modified_datetime` datetime DEFAULT NULL;

/*-----Cash on delivery transaction table------------*/
ALTER TABLE `tbl_cash_on_delivery_transaction` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_cash_on_delivery_transaction` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_cash_on_delivery_transaction` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_cash_on_delivery_transaction` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_cash_on_delivery_transaction` ADD CONSTRAINT `fk_tbl_cash_on_delivery_transaction_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
/*---------City table -------------*/
ALTER TABLE `tbl_city` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_city` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_city` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_city` MODIFY `modified_datetime` datetime DEFAULT NULL;
/*---------City translated-----------*/
ALTER TABLE `tbl_city_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_city_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_city_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_city_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_city_translated` MODIFY `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_city_translated` ADD CONSTRAINT `fk_tbl_city_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*----------Configuration table------------*/
ALTER TABLE `tbl_configuration` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_configuration` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_configuration` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_configuration` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_configuration` MODIFY `value` text COLLATE utf8_unicode_ci;

/*-----------Country table--------------*/
ALTER TABLE `tbl_country` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_country` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_country` MODIFY `iso_code_2` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_country` MODIFY `iso_code_3` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_country` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_country` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_country` MODIFY `postcode_required` smallint(1) DEFAULT NULL;
ALTER TABLE `tbl_country` MODIFY `status` smallint(1) DEFAULT NULL;

/*---------Country translated-----------*/
ALTER TABLE `tbl_country_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_country_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_country_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_country_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_country_translated` MODIFY `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_country_translated` ADD CONSTRAINT `fk_tbl_country_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*-----------Currency table--------------*/
ALTER TABLE `tbl_currency` MODIFY `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_currency` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_currency` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_currency` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_currency` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_currency_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_currency_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_currency_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_currency_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_currency_translated` ADD CONSTRAINT `fk_tbl_currency_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_currency` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*------------Customer table----*/
ALTER TABLE `tbl_customer` MODIFY `auth_key` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_customer` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_customer` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_customer` MODIFY `last_login` datetime DEFAULT NULL;
ALTER TABLE `tbl_customer` MODIFY `login_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_customer` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_customer` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_customer` MODIFY `password_hash` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_customer` MODIFY `password_reset_token` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_customer` MODIFY `person_id` int(11) DEFAULT NULL;
ALTER TABLE `tbl_customer` MODIFY `status` smallint(6) DEFAULT NULL;

/*Table structure for table `tbl_customer_activity` */

CREATE TABLE `tbl_customer_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `key` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(164) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `tbl_customer_download_mapping` */

CREATE TABLE `tbl_customer_download_mapping` (
  `customer_id` int(11) DEFAULT NULL,
  `download_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_download_id` (`download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*--------------Customer metadata-------*/
ALTER TABLE `tbl_customer_metadata` MODIFY `compareproducts` text COLLATE utf8_unicode_ci;
ALTER TABLE `tbl_customer_metadata` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_customer_metadata` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_customer_metadata` MODIFY `customer_id` int(11) DEFAULT NULL;
ALTER TABLE `tbl_customer_metadata` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_customer_metadata` MODIFY `modified_datetime` datetime DEFAULT NULL;

/*Table structure for table `tbl_customer_online` */

CREATE TABLE `tbl_customer_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `url` varchar(164) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referer` varchar(164) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ip` (`ip`),
  KEY `idx_customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*-----------Data Category table----*/
ALTER TABLE `tbl_data_category` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_data_category` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_data_category` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_data_category` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_data_category_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_data_category_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_data_category_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_data_category_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_data_category_translated` ADD CONSTRAINT `fk_tbl_data_category_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_data_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*-----Extension table----*/
ALTER TABLE `tbl_extension` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_extension` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_extension` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_extension` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_extension_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_extension_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_extension_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_extension_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_extension_translated` ADD CONSTRAINT `fk_tbl_extension_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_extension` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `tbl_extension_translated` ADD INDEX `idx_name` (`name`);

/*---------Group table----*/
ALTER TABLE `tbl_group` ADD `category` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'system';
ALTER TABLE `tbl_group` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_group` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_group` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_group` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_group` ADD `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_group` ADD `path` text COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_group` MODIFY `status` int(1) NOT NULL;

DROP TABLE `tbl_group_translated`;

ALTER TABLE `tbl_group_member` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_group_member` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_group_member` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_group_member` MODIFY `modified_datetime` datetime DEFAULT NULL;

/*---------Invoice table----*/
ALTER TABLE `tbl_invoice` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_invoice` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_invoice` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_invoice` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_invoice` ADD CONSTRAINT `fk_tbl_invoice_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tbl_invoice_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_invoice_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_invoice_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_invoice_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_invoice_translated` ADD CONSTRAINT `fk_tbl_invoice_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*-------Language table----*/
ALTER TABLE `tbl_language` MODIFY `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_language` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_language` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_language` MODIFY `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_language` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_language` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_language` MODIFY `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_language` MODIFY `sort_order` int(3) DEFAULT NULL;
ALTER TABLE `tbl_language` MODIFY `status` smallint(1) NOT NULL;

/*--------------Length class -------------*/
ALTER TABLE `tbl_length_class` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_length_class` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_length_class` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_length_class` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_length_class_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_length_class_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_length_class_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_length_class_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_length_class_translated` MODIFY `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_length_class_translated` ADD CONSTRAINT `fk_tbl_length_class_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_length_class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `tbl_length_class_translated` ADD INDEX `idx_language` (`language`);
ALTER TABLE `tbl_length_class_translated` ADD INDEX `idx_name` (`name`);
ALTER TABLE `tbl_length_class_translated` ADD INDEX `idx_owner_id` (`owner_id`);

/*----------Manufacturer table----*/
ALTER TABLE `tbl_manufacturer` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_manufacturer` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_manufacturer` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_manufacturer` MODIFY `modified_datetime` datetime DEFAULT NULL;

/*--------Newsletter table----*/
ALTER TABLE `tbl_newsletter` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_newsletter` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_newsletter` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_newsletter` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_newsletter` MODIFY `store_id` int(11) NOT NULL;
ALTER TABLE `tbl_newsletter` MODIFY `to` int(11) NOT NULL;

ALTER TABLE `tbl_newsletter_customers` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_newsletter_customers` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_newsletter_customers` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_newsletter_customers` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_newsletter_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_newsletter_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_newsletter_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_newsletter_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_newsletter_translated` ADD CONSTRAINT `fk_tbl_newsletter_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_newsletter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*----------Notification tables-------*/
ALTER TABLE `tbl_notification` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification` MODIFY `priority` smallint(1) NOT NULL DEFAULT '1';
ALTER TABLE `tbl_notification` MODIFY `status` smallint(1) NOT NULL DEFAULT '1';

ALTER TABLE `tbl_notification_layout` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification_layout` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification_layout` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification_layout` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification_layout` MODIFY `status` smallint(1) NOT NULL DEFAULT '1';

ALTER TABLE `tbl_notification_layout_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification_layout_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification_layout_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification_layout_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification_layout_translated` ADD CONSTRAINT `fk_tbl_notification_layout_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_notification_layout` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DROP TABLE `tbl_notification_logs`;

ALTER TABLE `tbl_notification_template` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification_template` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification_template` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification_template` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification_template` MODIFY `status` smallint(1) NOT NULL DEFAULT '1';

ALTER TABLE `tbl_notification_template_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification_template_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification_template_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_notification_template_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_notification_template_translated` ADD CONSTRAINT `fk_tbl_notification_template_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_notification_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*--------------Order table----*/
ALTER TABLE `tbl_order` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_order_address_details` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_address_details` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_address_details` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_address_details` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_address_details` ADD CONSTRAINT `fk_tbl_order_address_details_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_order_history` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_history` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_history` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_history` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_history` ADD CONSTRAINT `fk_tbl_order_history_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_order_history_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_history_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_history_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_history_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_history_translated` ADD CONSTRAINT `fk_tbl_order_history_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_order_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_order_payment_details` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_payment_details` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_payment_details` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_payment_details` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_payment_details` ADD CONSTRAINT `fk_tbl_order_payment_details_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_order_payment_details_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_payment_details_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_payment_details_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_payment_details_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_payment_details_translated` ADD CONSTRAINT `fk_tbl_order_payment_details_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_order_payment_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_order_payment_transaction_map` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_payment_transaction_map` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_payment_transaction_map` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_payment_transaction_map` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_payment_transaction_map` ADD CONSTRAINT `fk_tbl_order_payment_transaction_map_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tbl_order_product` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_product` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_product` MODIFY `item_code` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_order_product` MODIFY `model` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_order_product` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_product` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_product` MODIFY `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_order_product` MODIFY `options_price` decimal(10,2) DEFAULT '0.00';
ALTER TABLE `tbl_order_product` MODIFY `price` decimal(10,2) DEFAULT '0.00';
ALTER TABLE `tbl_order_product` DROP `reward`;
ALTER TABLE `tbl_order_product` MODIFY `tax` decimal(10,2) DEFAULT '0.00';
ALTER TABLE `tbl_order_product` MODIFY `total` decimal(10,2) DEFAULT '0.00';
ALTER TABLE `tbl_order_product` ADD CONSTRAINT `fk_tbl_order_product_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_order_status` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_status` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_status` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_status` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_order_status_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_status_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_status_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_status_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_status_translated` ADD CONSTRAINT `fk_tbl_order_status_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_order_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `tbl_order_status_translated` ADD INDEX `idx_language` (`language`);

ALTER TABLE `tbl_order_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_order_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_order_translated` ADD CONSTRAINT `fk_tbl_order_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*-------Page table----*/
ALTER TABLE `tbl_page` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_page` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_page` ADD `level` smallint(1) NOT NULL;
ALTER TABLE `tbl_page` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_page` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_page` MODIFY `parent_id` int(11) DEFAULT NULL;
ALTER TABLE `tbl_page` ADD `path` text COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_page` DROP `theme`;
ALTER TABLE `tbl_page` DROP INDEX `idx_theme`;

ALTER TABLE `tbl_page_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_page_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_page_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_page_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_page_translated` ADD CONSTRAINT `fk_tbl_page_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*-------Paypal table----*/
ALTER TABLE `tbl_paypal_standard_transaction` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_paypal_standard_transaction` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_paypal_standard_transaction` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_paypal_standard_transaction` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_paypal_standard_transaction` MODIFY `payment_status` varchar(32) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_paypal_standard_transaction` ADD CONSTRAINT `fk_tbl_paypal_standard_transaction_order_id` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*-------Person table----*/
ALTER TABLE `tbl_person` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_person` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_person` MODIFY `firstname` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_person` MODIFY `lastname` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_person` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_person` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_person` DROP `officefax`;
ALTER TABLE `tbl_person` DROP `officephone`;

/*--------Product Table---------------*/
ALTER TABLE `tbl_product` MODIFY `buy_price` decimal(10,2) DEFAULT '0.00';
ALTER TABLE `tbl_product` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product` ADD `ean` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `height` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product` ADD `hits` int(11) NOT NULL;
ALTER TABLE `tbl_product` MODIFY `initial_quantity` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product` ADD `isbn` varchar(17) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_product` ADD `jan` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `length_class` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `length` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `manufacturer` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `model` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product` ADD `mpn` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `price` decimal(10,2) DEFAULT '0.00';
ALTER TABLE `tbl_product` MODIFY `quantity` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `requires_shipping` smallint(1) DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `stock_status` smallint(1) DEFAULT NULL;
ALTER TABLE `tbl_product` ADD `type` smallint(1) DEFAULT '1';
ALTER TABLE `tbl_product` ADD `upc` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `weight_class` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product` MODIFY `width` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product` ADD INDEX `idx_hits` (`hits`);
ALTER TABLE `tbl_product` ADD INDEX `idx_type` (`type`);

ALTER TABLE `tbl_product_attribute` MODIFY `attribute_group` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product_attribute` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_attribute` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_product_attribute_group` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute_group` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_attribute_group` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute_group` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_product_attribute_group_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute_group_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_attribute_group_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute_group_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_attribute_group_translated` ADD CONSTRAINT `fk_tbl_product_attribute_group_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_attribute_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_product_attribute_mapping` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute_mapping` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_attribute_mapping` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute_mapping` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_attribute_mapping` ADD CONSTRAINT `fk_tbl_product_attribute_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tbl_product_attribute_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_attribute_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_attribute_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_attribute_translated` ADD CONSTRAINT `fk_tbl_product_attribute_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_product_category` MODIFY `code` varchar(164) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_product_category` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_category` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_category` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_category` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_category` MODIFY `parent_id` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product_category` ADD `path` text COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_product_category` MODIFY `status` smallint(1) DEFAULT NULL;

ALTER TABLE `tbl_product_category_mapping` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_category_mapping` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_category_mapping` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_category_mapping` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_category_mapping` ADD CONSTRAINT `fk_tbl_product_category_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tbl_product_category_translated` MODIFY `alias` varchar(128) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_product_category_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_category_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_category_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_category_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_category_translated` MODIFY `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_product_category_translated` ADD CONSTRAINT `fk_tbl_product_category_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_product_discount` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_discount` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_discount` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_discount` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_discount` MODIFY `price` decimal(10,2) NOT NULL;
ALTER TABLE `tbl_product_discount` MODIFY `quantity` int(10) NOT NULL;
ALTER TABLE `tbl_product_discount` ADD CONSTRAINT `fk_tbl_product_discount_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `tbl_product_download` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `allowed_downloads` int(10) DEFAULT '0',
  `number_of_days` int(10) DEFAULT '0',
  `size` double DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `tbl_product_download_mapping` */

CREATE TABLE `tbl_product_download_mapping` (
  `product_id` int(11) DEFAULT NULL,
  `download_id` int(11) DEFAULT NULL,
  `download_option` varchar(28) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  KEY `idx_product_id` (`product_id`),
  KEY `idx_download_id` (`download_id`),
  KEY `idx_download_option` (`download_option`),
  CONSTRAINT `fk_tbl_product_download_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `tbl_product_download_translated` */

CREATE TABLE `tbl_product_download_translated` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `language` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT '0',
  `modified_by` int(11) DEFAULT '0',
  `created_datetime` datetime DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_owner_id` (`owner_id`),
  KEY `idx_language` (`language`),
  KEY `idx_name` (`name`),
  CONSTRAINT `fk_tbl_product_download_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_download` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `tbl_product_image` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_image` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_image` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_image` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_image` MODIFY `product_id` int(11) DEFAULT NULL;
ALTER TABLE `tbl_product_image` ADD CONSTRAINT `fk_tbl_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tbl_product_image_translated` MODIFY `caption` varchar(128) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_product_image_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_image_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_image_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_image_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_image_translated` ADD CONSTRAINT `fk_tbl_product_image_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_product_option` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option` DROP `sort_order`;
ALTER TABLE `tbl_product_option` DROP INDEX `idx_sort_order`;

ALTER TABLE `tbl_product_option_mapping` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_mapping` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option_mapping` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_mapping` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option_mapping` ADD CONSTRAINT `fk_tbl_product_option_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tbl_product_option_mapping_details` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_mapping_details` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option_mapping_details` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_mapping_details` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_product_option_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option_translated` ADD CONSTRAINT `fk_tbl_product_option_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_option` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_product_option_value` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_value` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option_value` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_value` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option_value` MODIFY `option_id` int(11) DEFAULT NULL;

ALTER TABLE `tbl_product_option_value_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_value_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option_value_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_option_value_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_option_value_translated` ADD CONSTRAINT `fk_tbl_product_option_value_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_option_value` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_product_rating` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_rating` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_rating` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_rating` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_product_related_product_mapping` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_related_product_mapping` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_related_product_mapping` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_related_product_mapping` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_related_product_mapping` ADD CONSTRAINT `fk_tbl_product_related_product_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tbl_product_review` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_review` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_review` ADD `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_product_review` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_review` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_review` MODIFY `status` smallint(1) NOT NULL;
ALTER TABLE `tbl_product_review` ADD CONSTRAINT `fk_tbl_product_review_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tbl_product_review_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_review_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_review_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_review_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_review_translated` ADD CONSTRAINT `fk_tbl_product_review_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_review` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_product_special` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_special` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_special` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_special` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_special` ADD CONSTRAINT `fk_tbl_product_special_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_product_tag_mapping` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_tag_mapping` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_tag_mapping` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_tag_mapping` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_tag_mapping` ADD CONSTRAINT `fk_tbl_product_tag_mapping_product_id` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `tbl_product_tax_class` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_tax_class` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_tax_class` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_tax_class` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_product_tax_class_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_tax_class_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_tax_class_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_tax_class_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_tax_class_translated` ADD CONSTRAINT `fk_tbl_product_tax_class_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product_tax_class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_product_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_product_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_product_translated` ADD CONSTRAINT `fk_tbl_product_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DROP TABLE `tbl_role`;

ALTER TABLE `tbl_sequence` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_sequence` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_sequence` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_sequence` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_session` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_session` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_session` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_session` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_state` MODIFY `code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_state` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_state` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_state` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_state` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_state` MODIFY `status` smallint(1) DEFAULT NULL;

ALTER TABLE `tbl_state_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_state_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_state_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_state_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_state_translated` MODIFY `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_state_translated` ADD CONSTRAINT `fk_tbl_state_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_state` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_stock_status` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_stock_status` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_stock_status` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_stock_status` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_stock_status_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_stock_status_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_stock_status_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_stock_status_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_stock_status_translated` MODIFY `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_stock_status_translated` ADD CONSTRAINT `fk_tbl_stock_status_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_stock_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `tbl_stock_status_translated` ADD INDEX `idx_language` (`language`);
ALTER TABLE `tbl_stock_status_translated` ADD INDEX `idx_name` (`name`);
ALTER TABLE `tbl_stock_status_translated` ADD INDEX `idx_owner_id` (`owner_id`);

ALTER TABLE `tbl_store` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_store` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_store` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_store` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_store_configuration` MODIFY `category` varchar(32) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_store_configuration` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_store_configuration` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_store_configuration` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_store_configuration` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_store_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_store_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_store_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_store_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_store_translated` ADD CONSTRAINT `fk_tbl_store_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_store` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_tag` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tag` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_tag` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tag` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_tag_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tag_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_tag_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tag_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_tag_translated` MODIFY `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_tag_translated` ADD CONSTRAINT `fk_tbl_tag_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

DROP TABLE `tbl_tax_rate`;
DROP TABLE `tbl_tax_rate_translated`;

ALTER TABLE `tbl_tax_rule` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tax_rule` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_tax_rule` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tax_rule` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_tax_rule` ADD `type` varchar(64) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_tax_rule` ADD `value` varchar(64) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_tax_rule` ADD INDEX `idx_type` (`type`);

ALTER TABLE `tbl_tax_rule_details` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tax_rule_details` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_tax_rule_details` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tax_rule_details` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_tax_rule_details` DROP `tax_rate_id`;
ALTER TABLE `tbl_tax_rule_details` DROP INDEX `idx_tax_rate_id`;

ALTER TABLE `tbl_tax_rule_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tax_rule_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_tax_rule_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_tax_rule_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_tax_rule_translated` ADD CONSTRAINT `fk_tbl_tax_rule_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_tax_rule` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `tbl_user` MODIFY `auth_key` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_user` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_user` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_user` MODIFY `last_login` datetime DEFAULT NULL;
ALTER TABLE `tbl_user` MODIFY `login_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_user` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_user` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_user` MODIFY `password_reset_token` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_user` MODIFY `person_id` int(11) DEFAULT NULL;
ALTER TABLE `tbl_user` MODIFY `status` smallint(1) DEFAULT NULL;
ALTER TABLE `tbl_user` MODIFY `timezone` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `tbl_user` MODIFY `type` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL;

DROP TABLE `tbl_user_metadata`;
DROP TABLE `tbl_user_roles`;

ALTER TABLE `tbl_weight_class` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_weight_class` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_weight_class` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_weight_class` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_weight_class_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_weight_class_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_weight_class_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_weight_class_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_weight_class_translated` MODIFY `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `tbl_weight_class_translated` ADD CONSTRAINT `fk_tbl_weight_class_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_weight_class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `tbl_weight_class_translated` ADD INDEX `idx_language` (`language`);
ALTER TABLE `tbl_weight_class_translated` ADD INDEX `idx_name` (`name`);
ALTER TABLE `tbl_weight_class_translated` ADD INDEX `idx_owner_id` (`owner_id`);

ALTER TABLE `tbl_zone` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_zone` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_zone` MODIFY `is_zip_range` smallint(1) DEFAULT NULL;
ALTER TABLE `tbl_zone` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_zone` MODIFY `modified_datetime` datetime DEFAULT NULL;

ALTER TABLE `tbl_zone_translated` MODIFY `created_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_zone_translated` MODIFY `created_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_zone_translated` MODIFY `modified_by` int(11) DEFAULT '0';
ALTER TABLE `tbl_zone_translated` MODIFY `modified_datetime` datetime DEFAULT NULL;
ALTER TABLE `tbl_zone_translated` ADD CONSTRAINT `fk_tbl_zone_translated_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;