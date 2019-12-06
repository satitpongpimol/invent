<?php

/*
application framework for AISIN H/T
develope by iWoon 20190209
http://119.59.115.141:8081/FAST_API/fast/fast/HelloYear?_Year=9999
*/

/*
* global configuration
*/
define('ENV', 'PRD');
define('BASE_URL', 'https://www.now-devops.com/good/');
define('APP_DIR', './app');
define('ASSETS_DIR', './assets');
define('SOUND_DIR', ASSETS_DIR.'/sound');
define('SOUND_URL', BASE_URL.'/assets/sound/');
define('SESSION_TIMEOUT', 21600); //seconds 3600 = 1 Hr
/*
*
* API ENDPOINT
*/
define('WEBAPI', 'http://atac-agv.wbt-dev.com/');
define('ENDPOINT', 'api');
define('APP_VERSION', '0.1.0');
define('APP_RELEASE_STATUS', 'Demo');

/* POPUP WINDOW */
define('OK_TIMEOUT', 3000);
define('NG_TIMEOUT', 0);
define('COMPLETE_TIMEOUT', 3000);

define('ALLOW_REG_AJAX_CORS', true); // register site in file :register.site.php
define('ALLOW_ALL_AJAX_CORS', false); // except ALLOW_AJAX_CORS, and allow ajax from any server

/* registered assets */

require_once __DIR__.'/register.php';

// MESSAGE
// type = ERROR,WARNING,INFO,SUCESS
// msg = 'message'
// $message = array('type'=>'ERROR','msg'=>'Invalid');
$message = array();
