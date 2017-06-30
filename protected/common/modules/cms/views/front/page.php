<?php
use usni\library\utils\Html;

/* @var $this \frontend\web\View */
$this->title = $page['name'];
$this->params['breadcrumbs'][] = ['label' => $page['name']];
echo Html::tag('h1', $page['name']) . $page['content'];