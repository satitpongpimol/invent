<?php

// registered application
/*
$app['application_folder'] = array('title'=>'title message');
*/
// $app['login'] = array('title' => 'Login');
$app['stock-in'] = array('title' => 'Stock-In');
//$app['stock-out'] = array('title' => 'Stock-Out');
if (ENV !== 'PRD') {
    $app['test'] = array('title' => 'Test app');
}

$app['logout'] = array('title' => 'Log out');
