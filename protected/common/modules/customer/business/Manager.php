<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\business;

use usni\library\modules\auth\models\Group;
use customer\models\Customer;
use usni\library\modules\users\models\Person;
use usni\library\modules\users\models\Address;
use usni\library\utils\ArrayUtil;
use customer\services\NotificationService;
use customer\utils\CustomerUtil;
use customer\dto\FormDTO;
use usni\library\utils\TimezoneUtil;
use usni\library\modules\users\models\User;
use taxes\db\ZoneDataManager;
use customer\models\CustomerOnline;
use usni\UsniAdaptor;
use cart\models\Cart;
use wishlist\models\Wishlist;
use products\models\CompareProducts;
use customer\models\CustomerActivity;
use products\dao\ProductDAO;
use products\behaviors\ProductBehavior;
use customer\models\LatestCustomerSearch;
use usni\library\modules\users\events\UpdateUserEvent;
use usni\library\modules\users\events\CreateUserEvent;
use customer\dao\CustomerDAO;
/**
 * Manager class file.
 *
 * @package customer\business
 */
class Manager extends \common\business\Manager
{
    use \usni\library\modules\users\traits\UserManagerTrait;
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    
    /**
     * inheritdoc
     */
    public $memberType = 'customer';
    
    /**
     * inheritdoc
     */
    public $groupCategory = 'customer';
    
    /**
     * @var int selected store id 
     */
    public $selectedStoreId;
    /**
     * @var string 
     */
    public $selectedCurrency;
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                    'notifyService' => NotificationService::className(),
                    'productBehavior' => ProductBehavior::className()
               ];
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return Customer::find()->orderBy(['id' => SORT_ASC])->asArray()->all();
    }
    
    /**
     * Create customer.
     * @param string $username
     * @param Group $group
     * @param mixed $password
     * @param string $email
     * @return Customer model
     */
    public function createCustomer($username, $group, $password, $email = null)
    {
        $customerData   = [
                            'username'        => $username,
                            'password'        => $password,
                            'confirmPassword' => $password,
                            'timezone'        => TimezoneUtil::getCountryTimezone('IN'),
                            'status'          => User::STATUS_ACTIVE,
                            'groups'          => [$group['id']]
                          ];
        $personData = ['email'           => CustomerUtil::getEmail($username, $email),
                       'firstname'       => ucfirst($username),
                       'lastname'        => $username . 'last'];
        $addressData = ['address1'        => 'address', 
                        'address2'        => 'address2', 
                        'city'            => 'Delhi', 
                        'country'         => 'IN',
                        'state'           => '',
                        'postal_code'     => ZoneDataManager::PIN_CODE_DELHI];
        $customer    = new Customer(['scenario' => 'create']);
        $person      = new Person(['scenario' => 'create']);
        $address     = new Address(['scenario' => 'create']);
        $customer->attributes    = $customerData;
        $person->attributes      = $personData;
        $address->attributes     = $addressData;
        $formDTO = new FormDTO();
        $formDTO->setPerson($person);
        $formDTO->setAddress($address);
        $formDTO->setModel($customer);
        if($this->processInputData($formDTO))
        {
           return $customer; 
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Get metadata items for the customer.
     * @param string $key
     * @return array
     */
    public function getMetadataItems($key)
    {
        $metadata         = UsniAdaptor::app()->guest->$key;
        $guestItemCollection   = $metadata->itemsList;
        $itemsList        = [];
        if(count($guestItemCollection) > 0)
        {
            foreach($guestItemCollection as $itemCode => $item)
            {
                //it is Item in case of cart
                if($item instanceof \cart\models\Item)
                {
                    $record = $item->toArray();
                    $product            = ProductDAO::getById($record['productId'], $this->language);
                    $priceExcludingTax  = $this->getFinalPrice($product, $record['qty']);
                    $tax                = $this->getTaxAppliedOnProduct($product, $priceExcludingTax);
                    $record['tax'] = $tax;
                    $record['totalPrice'] = $record['price'];
                }
                else
                {
                    $record = $item;
                }
    
                $itemsList[$itemCode] = $record;
            }
        }
        return $this->mergeCustomerMetadata($itemsList, $key);
    }
    
    /**
     * Merge customer metadata
     * @param array $itemsList
     * @param string $key
     * @return array
     */
    public function mergeCustomerMetadata($itemsList, $key)
    {
        $customer         = UsniAdaptor::app()->user->getIdentity();
        $customerMetadata = $customer->metadata;
        //Populate cart info
        if($customerMetadata != null)
        {
            if(!empty($customerMetadata->$key))
            {
                $customerItemsList = unserialize($customerMetadata->$key);
            }
            if($key == 'cart')
            {
                if(!empty($itemsList))
                {
                    foreach($itemsList as $itemCode => $record)
                    {
                        if(array_key_exists($itemCode, $customerItemsList))
                        {
                            $custItemRecord = $customerItemsList[$itemCode];
                            $record['qty'] += $custItemRecord['qty'];
                            $itemsList[$itemCode] = $record;
                        }
                    }
                }
                else
                {
                    $itemsList = $customerItemsList;
                }
            }
            else
            {
                $itemsList = array_unique(ArrayUtil::merge($customerItemsList, $itemsList));
            }
        }
        return $itemsList;
    }
    
    /**
     * Get customer group dropdown data.
     * @return array
     */
    public function getCustomerGroupDropdownData()
    {       
        $records    = Group::find()->where('category = :type', [':type' => 'customer'])->asArray()->all();
        return ArrayUtil::map($records, 'id', 'name');
    }
    
    /**
     * Gets customer and guest drop down data.
     * @return array
     */
    public function getCustomerAndGuestDropdownData()
    {
        $data       = ArrayUtil::map(Customer::find()->asArray()->indexBy('username')->all(), 'id', 'username');
        $data[0]    = 'guest';
        return $data;
    }
    
    /**
     * Get customer group. 
     * @param int $groupId
     * @return string
     */
    public function getGroupName($groupId)
    {
        $group  = Group::find()->where('id = :id',  [':id' => $groupId])->asArray()->one();
        return $group['name'];
    }
    
    /**
     * Update online users
     * @param string $ip
     * @param string $url
     * @param string $referer
     */
    public function updateOnlineUsers($ip, $url, $referer)
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'customer_online';
        $sql        = "DELETE FROM `$tableName` WHERE created_datetime < '" . date('Y-m-d H:i:s', strtotime('-1 hour')) . "'";
        UsniAdaptor::app()->db->createCommand($sql)->execute();
        $customerOnline                 = new CustomerOnline(['scenario' => 'create']);
        $customerOnline->ip             = $ip;
        $customerOnline->customer_id    = $this->userId;
        $customerOnline->url            = $url;
        $customerOnline->referer        = $referer;
        if($customerOnline->validate())
        {
            $customerOnline->save(false);
        }
    }
    
    /**
     * Updates metadata in db
     * @param Cart $cart
     * @param Wishlist $wishlist
     * @param CompareProducts $compareproducts
     * @return void
     */
    public function updateMetadata($cart, $wishlist, $compareproducts)
    {
        $customer           = Customer::findOne($this->userId);
        $metadata           = $customer->metadata;
        $cartInfo           = serialize($cart->itemsList->asArray());
        $metadata->customer_id = $this->userId;
        $metadata->cart     = $cartInfo;
        $metadata->wishlist = serialize($wishlist->itemsList);
        $metadata->compareproducts = serialize($compareproducts->itemsList);
        $metadata->save();
    }
    
    /**
     * inheritdoc
     */
    public function afterModelSave($model)
    {
        $this->on(Customer::EVENT_AFTER_UPDATE, [$this, 'processAfterUpdate']);
        if(parent::afterModelSave($model))
        {
            if($this->isNewRecord)
            {
                $event      = new CreateUserEvent(['user' => $model]);
                $this->trigger(Customer::EVENT_AFTER_INSERT, $event);
            }
            else
            {
                $event = new UpdateUserEvent(['model' => $model]);
                $this->trigger(Customer::EVENT_AFTER_UPDATE, $event);
            }
        }
        return true;
    }
    
    /**
     * Process user edit.
     * @param object $formDTO
     */
    public function processEdit($formDTO)
    {
        $this->populateFormDTO($formDTO);
        if (!empty($formDTO->getPostData()))
        {
            $result = $this->processInputData($formDTO);
            $formDTO->setIsTransactionSuccess($result);
        }
    }
    
    /**
     * Add customer activity.
     * @param string $key
     * @param array $activityData
     */
    public function addActivity($key, $activityData)
    {
        $customerId = Customer::GUEST_CUSTOMER_ID;
        if(isset($activityData['customer_id']))
        {
            $customerId = $activityData['customer_id'];
        }
        $model = new CustomerActivity(['scenario' => 'create']);
        $model->customer_id = $customerId;
        $model->key         = $key;
        $model->data        = serialize($activityData);
        $model->ip          = $_SERVER['REMOTE_ADDR'];
        $model->save();
        return $model;
    }
    
    /**
     * Process latest customers
     * @param \usni\library\dto\GridViewDTO $gridViewDTO
     */
    public function processLatestCustomers($gridViewDTO)
    {
        $customerSearch = new LatestCustomerSearch();
        $gridViewDTO->setDataProvider($customerSearch->search());
    }
    
    /**
     * Get customer
     * @param integer $customerId
     * @return string
     */
    public function getCustomer($customerId)
    {
        if($customerId != Customer::GUEST_CUSTOMER_ID)
        {
            $customer = CustomerDAO::getById($customerId);
            return $customer['username'];
        }
        return UsniAdaptor::t('customer', 'guest');
    }
}