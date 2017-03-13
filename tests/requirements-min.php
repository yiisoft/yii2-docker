<?php
/**
 * These are the requirements for the yii2-php:*-min docker image.
 * Note: You don't need to inlcude yii2's core requirements again here.
 */

/* @var $this YiiRequirementChecker */
return array(
    array(
        'name' => 'APC extension',
        'mandatory' => true,
        'condition' => extension_loaded('apcu'),
    ),
    array(
        'name' => 'Fileinfo extension',
        'mandatory' => true,
        'condition' => extension_loaded('fileinfo'),
    ),
    array(
        'name' => 'Intl extension',
        'mandatory' => true,
        'condition' => $this->checkPhpExtensionVersion('intl', '1.0.2', '>='),
    ),
    array(
        'name' => 'ICU version',
        'mandatory' => true,
        'condition' => defined('INTL_ICU_VERSION') && version_compare(INTL_ICU_VERSION, '49', '>='),
    ),
    array(
        'name' => 'ICU Data version',
        'mandatory' => true,
        'condition' => defined('INTL_ICU_DATA_VERSION') && version_compare(INTL_ICU_DATA_VERSION, '49.1', '>='),
    ),
    array(
        'name' => 'Opcache extension',
        'mandatory' => true,
        'condition' => extension_loaded('Zend OPcache'),
    ),
);
