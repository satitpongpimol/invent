<?php

/*
application framework for AISIN H/T
develope by iWoon 20190209
update by new 24082019 COCO----
*/

/*
 * routing page
 *
 */
session_start();
include_once './common/config.php';
include_once './common/function.php';
include_once './common/api.php';

$time = $_SERVER['REQUEST_TIME'];

/**
 * for a 30 minute timeout, specified in seconds.
 */
$timeout_duration = SESSION_TIMEOUT;

/**
 * Here we look for the user's LAST_ACTIVITY timestamp. If
 * it's set and indicates our $timeout_duration has passed,
 * blow away any previous $_SESSION data and start a new one.
 */
if (isset($_SESSION['LAST_ACTIVITY']) &&
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}

/*
 * Finally, update LAST_ACTIVITY so that our timeout
 * is based on it and not the user's login time.
 */
$_SESSION['LAST_ACTIVITY'] = $time;

/* set device id */
if (isset($_GET['DeviceId'])) {
    $_SESSION['DeviceId'] = $_GET['DeviceId'];
}
if (!isset($_SESSION['DeviceId'])) {
    $client_name = $_SERVER['REMOTE_ADDR'];
    if (empty($client_name)) {
        $_SESSION['DeviceId'] = 'dummy-'.rand(10000, 99999);
    } else {
        $_SESSION['DeviceId'] = $client_name;
    }
}

/* web api */

if (isset($_REQUEST['api'])) {
    include_once APP_DIR."/{$_GET['app']}/webapi.php";
    exit;
}

//REDIRECT IF HAVE NO SESSION
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = 0;
}

if ($_SESSION['loggedIn'] == 0) {
    if (!isset($_GET['app'])) {
        goto_app('login');
    } elseif (strtolower($_GET['app']) !== 'login') {
        set_callback_url($_SERVER['REQUEST_URI']);
        goto_app('login');
        exit;
    }
}

// show app
if (isset($_GET['app']) && file_exists(APP_DIR."/{$_GET['app']}/index.php")) {
    include_once APP_DIR."/{$_GET['app']}/index.php";
    exit;
}

// show page
if (isset($_GET['page'])) {
    include_once $_GET['page'].'.php';
} elseif (!isset($_GET['page'])) {
    goto_page('menu');
} else {
    redirect_url(BASE_URL.'error.php?code=404');
}
