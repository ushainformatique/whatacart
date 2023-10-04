<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\install\components;

use usni\UsniAdaptor;
use usni\library\utils\FileUtil;

require_once(YII2_PATH . '/requirements/YiiRequirementChecker.php');
/**
 * ApplicationRequirementChecker class file.
 * 
 * @package usni\library\modules\install\components
 */
class ApplicationRequirementChecker extends \YiiRequirementChecker
{
    /**
     * Performs the check for the Yii core requirements.
     * @return ApplicationRequirementChecker self instance.
     */
    function checkYii()
    {
        $path = FileUtil::normalizePath(UsniAdaptor::app()->getModule('install')->basePath . DIRECTORY_SEPARATOR . 'requirements.php');
        return $this->check($path);
    }
    
    /**
     * Get application requirements
     * @return array
     */
    public function getRequirements()
    {
        $gdMemo = $imagickMemo = UsniAdaptor::t('install', 'Either GD PHP extension with FreeType support or ImageMagick PHP extension with PNG support is required for image CAPTCHA.');
        $gdOK   = $imagickOK = false;

        if (extension_loaded('imagick')) 
        {
            $imagick = new \Imagick();
            $imagickFormats = $imagick->queryFormats('PNG');
            if (in_array('PNG', $imagickFormats))
            {
                $imagickOK = true;
            } 
            else 
            {
                $imagickMemo = UsniAdaptor::t('install', 'Imagick extension should be installed with PNG support in order to be used for image CAPTCHA.');
            }
        }

        if (extension_loaded('gd')) 
        {
            $gdInfo = gd_info();
            if (!empty($gdInfo['FreeType Support'])) 
            {
                $gdOK = true;
            } 
            else 
            {
                $gdMemo = UsniAdaptor::t('install', 'GD extension should be installed with FreeType support in order to be used for image CAPTCHA.');
            }
        }
        /**
         * Adjust requirements according to your application specifics.
         */
        $requirements = array(
            // Database :
            array(
               'name' => 'PDO extension',
               'mandatory' => true,
               'condition' => extension_loaded('pdo'),
               'by' => 'All DB-related classes',
            ),
            array(
               'name' => 'PDO MySQL extension',
               'mandatory' => false,
               'condition' => extension_loaded('pdo_mysql'),
               'by' => 'All DB-related classes',
               'memo' => UsniAdaptor::t('install', 'Required for MySQL database.'),
            ),
            // CAPTCHA:
            array(
               'name' => 'GD PHP extension with FreeType support',
               'mandatory' => false,
               'condition' => $gdOK,
               'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
               'memo' => $gdMemo,
           ),
            array(
               'name' => 'ImageMagick PHP extension with PNG support',
               'mandatory' => false,
               'condition' => $imagickOK,
               'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
               'memo' => $imagickMemo,
            ),
           // PHP ini :
           'phpSafeMode' => array(
               'name' => 'PHP safe mode',
               'mandatory' => false,
               'condition' => $this->checkPhpIniOff("safe_mode"),
               'by' => 'File uploading and console command execution',
               'memo' => UsniAdaptor::t('install', '"safe_mode" should be disabled at php.ini'),
            ),
           'phpExposePhp' => array(
               'name' => 'Expose PHP',
               'mandatory' => false,
               'condition' => $this->checkPhpIniOff("expose_php"),
               'by' => 'Security reasons',
               'memo' => UsniAdaptor::t('install', '"expose_php" should be disabled at php.ini'),
            ),
           'phpAllowUrlInclude' => array(
               'name' => 'PHP allow url include',
               'mandatory' => false,
               'condition' => $this->checkPhpIniOff("allow_url_include"),
               'by' => 'Security reasons',
               'memo' => UsniAdaptor::t('install', '"allow_url_include" should be disabled at php.ini'),
            ),
           'phpSmtp' => array(
               'name' => 'PHP mail SMTP',
               'mandatory' => false,
               'condition' => strlen(ini_get('SMTP'))>0,
               'by' => 'Email sending',
               'memo' => UsniAdaptor::t('install', 'PHP mail SMTP server required'),
            ),
            'phpCurl' => array(
                'name' => 'PHP Curl',
                'mandatory' => true,
                'condition' => extension_loaded('curl'),
                'by' => 'Payment Gateways',
                'memo' => 'Curl is required',
            ),
            array(
                'name'      => UsniAdaptor::t('install', 'Mcrypt extension'),
                'mandatory' => false,
                'condition' => extension_loaded("mcrypt"),
                'by'        => '<a href="https://github.com/yiisoft/yii2/blob/master/docs/guide/security-authorization.md">SecurityManager</a>',
                'memo'      => \Yii::t('yii', 'This is required by encrypt and decrypt methods.')
            )
        );
        return $requirements;
    }
}
