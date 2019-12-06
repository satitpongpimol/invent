<?php

// web api

if (!isset($_REQUEST['operation'])) {
    exit;
}

// payment online
include_once __DIR__.'/api/login.webapi.php';
