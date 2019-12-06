<?php

require_once APP_DIR.'/login/function.php';

switch (strtolower($_REQUEST['operation'])) {
    case 'unlock':
    $username = isset($_REQUEST['txtusername']) ? $_REQUEST['txtusername'] : '';
    $password = isset($_REQUEST['txtpassword']) ? $_REQUEST['txtpassword'] : '';
    $json = array('message_type' => 'error', 'status' => 'N', 'message' => 'ERROR : Invalid username or password!');
        $apiresult = check_login($username, $password);
        if ($apiresult) {
            $json = array('message_type' => 'success', 'status' => 'Y', 'message' => 'good luck!');
        }
        allow_cors_header();
        header('Content-type: application/json');
        //header('Content-type: text/x-json');
        echo json_encode($json);
        exit;
    break;
}
