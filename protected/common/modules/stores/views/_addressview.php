<?php
use usni\library\widgets\DetailView;
use usni\library\utils\CountryUtil;
use usni\library\widgets\StatusLabel;
/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */

$model          = $detailViewDTO->getModel();
if($addressType == 'billing')
{
    $address = $model['billingAddress'];
}
else
{
    $address = $model['shippingAddress'];
}
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'decoratorView' => false,
                    'model'         => $address,
                    'attributes'    => [
                                            'address1',
                                            'address2',
                                            'city',
                                            'state',
                                            [
                                               'attribute'  => 'country',
                                               'value'      => CountryUtil::getCountryName($address['country'])
                                            ],
                                            'postal_code',
                                            [
                                                'attribute' => 'status',   
                                                'value'     => StatusLabel::widget(['model' => $address]), 
                                                'format'    => 'html'
                                            ],
                                       ]
                  ];
echo DetailView::widget($widgetParams);