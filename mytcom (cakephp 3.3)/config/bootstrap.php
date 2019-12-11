<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/*
 * You can remove this if you are confident that your PHP version is sufficient.
 */
if (version_compare(PHP_VERSION, '5.5.9') < 0) {
    trigger_error('Your PHP version must be equal or higher than 5.5.9 to use CakePHP.', E_USER_ERROR);
}

/*
 *  You can remove this if you are confident you have intl installed.
 */
if (!extension_loaded('intl')) {
    trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}

/*
 * You can remove this if you are confident you have mbstring installed.
 */
if (!extension_loaded('mbstring')) {
    trigger_error('You must enable the mbstring extension to use CakePHP.', E_USER_ERROR);
}

/**
 * 環境情報ファイルの読み込み
 */
$envPath = dirname(__FILE__) . '/env_setting.php';
if (file_exists($envPath)) {
    require $envPath;
}

/*
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\Utility\Security;

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */

// 環境情報の取得
$NOPT_ISP = $_SERVER['NOPT_ISP'];
$NOPT_ENV = $_SERVER['NOPT_ENVIRONMENT'];
try {
    Configure::config('default', new PhpConfig());
    // Configure::loadで設定ファイルを読み込むときの注意。第3引数は、falseを指定すると、
    // 先に読み込んでいる設定ファイルに同じキーがある場合に上書きしてしまう。
    // 例、common_setthingでCommonというキーがあるとき、その後の設定ファイルにもCommonがあると
    // common_setthingのCommonが上書きされてしまう。
    // 共通設定ファイルの読み込み
    Configure::load('/common_setting', 'default', false);
    Configure::load('/import_template', 'default', true);
    if (isset($NOPT_ISP) && isset($NOPT_ENV)) {
        // ISPおよび動作環境ごとの設定ファイルの読み込み
        Configure::load($NOPT_ISP . '/' . $NOPT_ENV . '/app', 'default', true);
        Configure::load($NOPT_ISP . '/' . $NOPT_ENV . '/environment_setting', 'default', true);
        Configure::load($NOPT_ISP . '/ispdiff_setting', 'default', true);
    } else {
        throw new \Cake\Network\Exception\InternalErrorException("Configuration file area not found. ISP=" . $NOPT_ISP . " ENV=" . $NOPT_ENV);
    }
    // NOPT_ENVIRONMENTが開発者端末（local-dev）のときのみ、開発者端末で必要な設定を読み込む
    if ($NOPT_ENV == 'local-dev') {
        Configure::load($NOPT_ISP . '/' . $NOPT_ENV . '/local_setting', 'default', true);
    }
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * Load an environment local configuration file.
 * You can use a file like app_local.php to provide local overrides to your
 * shared configuration.
 */
//Configure::load('app_local', 'default');

/*
 * When debug = false the metadata cache should last
 * for a very very long time, as we don't want
 * to refresh the cache while users are doing requests.
 */
if (!Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+1 years');
    Configure::write('Cache._cake_core_.duration', '+1 years');
}

/*
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
date_default_timezone_set('Asia/Tokyo');

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::config(Configure::consume('Cache'));
ConnectionManager::config(Configure::consume('Datasources'));
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));
Log::config(Configure::consume('Log'));
Security::salt(Configure::consume('Security.salt'));

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
Request::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
Request::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build('time')
        ->useImmutable();
Type::build('date')
        ->useImmutable();
Type::build('datetime')
        ->useImmutable();

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', x['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['Group']);
//Inflector::rules('transliteration', ['/å/' => 'aa']);

/*
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('Migrations'); //Loads a single plugin named Migrations
 *
 */
// iPhone向け画面表示用の領域をロード
Plugin::load('Iphone');
// Android向け画面表示用の領域をロード
Plugin::load('Android');

/*
 * Only try to load DebugKit in development mode
 * Debug Kit should not be installed on a production system
 */
if (Configure::read('debug')) {
    Plugin::load('DebugKit', ['bootstrap' => true]);
}

Plugin::load('Migrations');

/*
 * In order to run unit test related to download file procress
 * change this constant's value to 1
 */
define('PHPUNIT_RUNNING', 0);
