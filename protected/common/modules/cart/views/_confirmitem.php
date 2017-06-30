<?php
/*
 * @var $this \frontend\web\View
 */

echo $this->render('/_item', ['item' => $item, 'currencyCode' => $currencyCode, 'isConfirm' => $isConfirm]);