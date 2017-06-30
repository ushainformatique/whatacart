<?php
/*
 * @var $this \frontend\web\View
 */

echo $this->render('/_cartitem', ['item' => $item, 'currencyCode' => $currencyCode, 'isConfirm' => $isConfirm]);