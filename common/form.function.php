<?php

include_once APP_DIR.'/login/function.php';
//short hand function gen ng form
function gen_ng_form()
{
    echo '<h1 class="text-header">NG</h1>';
    $login_hrml = ajax_login_form('unlock');
    $login_hrml = str_replace("'", "\'", $login_hrml);
    echo $login_hrml;
    play_sound_ng();
}
//short hand function gen ok form
function gen_ok_form()
{
    echo '<h1 class="text-header">OK</h1>';
    play_sound_ok();
}
//short hand function gen ng form
function gen_complete_form()
{
    echo '<h1 class="text-header">COMPLETE</h1>';
    play_sound_complete();
}
function gen_popup_form($title, $sound_url = '')
{
    echo "<h1 class=\"text-header\">{$title}</h1>";
    if (!empty($sound_url)) {
        play_sound_url($sound_url);
    }
}
function gen_js_popup_form($type)
{
    if (empty($type)) {
        return;
    }
    $timeout = 0;
    $cssClass = '';
    $msg = isset($GLOBALS['message']['msg']) ? $GLOBALS['message']['msg'] : '';
    switch ($type) {
        case 'OK':
        $cssClass = 'class="info"';
        break;
        case 'NG':
        $cssClass = 'class="error"';
        break;
        case 'COMPLETE':
        $cssClass = 'class="success"';
        break;
    }

    echo "ShowPopup('Wndpopup','<div id=\"popup-panel\" {$cssClass}>";
    switch (strtoupper($type)) {
        case 'OK':
            gen_ok_form();
            $timeout = OK_TIMEOUT;
        break;
        case 'NG':
            gen_ng_form();
            $timeout = NG_TIMEOUT;
        break;
        case 'COMPLETE':
            gen_complete_form();
            $timeout = COMPLETE_TIMEOUT;
        break;
    }
    echo "<div id=\"ajax_message\">{$msg}</div></div>',".$timeout.');'.PHP_EOL;
}
