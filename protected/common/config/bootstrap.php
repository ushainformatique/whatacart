<?php
define('DS', DIRECTORY_SEPARATOR);
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('taxes', dirname(__DIR__). '/modules/localization/modules/tax');
Yii::setAlias('productCategories', dirname(__DIR__). '/modules/catalog/modules/productCategories');
Yii::setAlias('products', dirname(__DIR__). '/modules/catalog/modules/products');
Yii::setAlias('customer', dirname(__DIR__). '/modules/customer');
Yii::setAlias('cart', dirname(dirname(__DIR__)). '/common/modules/cart');
Yii::setAlias('wishlist', dirname(dirname(__DIR__)). '/frontend/modules/wishlist');
Yii::setAlias('tests', dirname(dirname(dirname(__DIR__))). '/tests');
Yii::setAlias('newsletter', dirname(__DIR__). '/modules/marketing/modules/newsletter');

