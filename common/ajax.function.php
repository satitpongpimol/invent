<?php

function allow_cors_header()
{
    // exit if not allowed cors
    if (!ALLOW_REG_AJAX_CORS && !ALLOW_ALL_AJAX_CORS) {
        return;
    }

    //$origin = $_SERVER['HTTP_ORIGIN'];
    // fixed for old browser
    $origin = $_SERVER['HTTP_REFERER'];
    if (in_array($origin, $GLOBALS['allow_ajax_cors']['allowed']) && ALLOW_REG_AJAX_CORS) {
        header('Access-Control-Allow-Origin: '.$origin);
    } elseif (!in_array($origin, $GLOBALS['allow_ajax_cors']['allowed']) && ALLOW_ALL_AJAX_CORS) {
        header('Access-Control-Allow-Origin: *');
    }
}
