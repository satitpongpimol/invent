<?php

function app_header($title)
{
    $html = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$title}</title>
HTML;
    echo $html;
    include_template_assets();
}
function app_body($operation_flag, $form_name)
{
    $frmname = $form_name;
    if ($operation_flag == 'NG') {
        $frmname = 'frmLogin';
    } else {
        $frmname = $form_name;
    }

    echo '<script type="text/javascript">window.onload=function(){';
    gen_js_popup_form($operation_flag);
    echo "var frm = '{$frmname}';form_setfocus(frm,0);setTimeout(form_setfocus(frm,0),2000);}</script>";
    $html = <<<HTML
</head>
<body>
<div id="container">
HTML;
    echo $html;
    echo create_popup_window();
}
function app_end()
{
    echo '</div></body></html>';
}
function create_popup_window()
{
    $html = '<div id="Wndpopup" class="wnd-popup"></div>';

    return $html;
}

/* write assets command */
function include_template_assets($arg = array())
{
    $assets['js'] = <<<JS
    <script src="./assets/js/form-validation.js" type="text/javascript"></script>
JS;
    $assets['css'] = <<<CSS
    <link href="./assets/css/main.css" rel="stylesheet" />
    <link href="./assets/css/table.css" rel="stylesheet" />
CSS;
    if (defined('USE_AJAX')) {
        if (USE_AJAX) {
            $assets['js'] = $assets['js'].'<script src="./assets/js/json2.js" type="text/javascript"></script>'.PHP_EOL;
            $assets['js'] = $assets['js'].'<script src="./assets/js/ajax.js" type="text/javascript"></script>'.PHP_EOL;
            $assets['js'] = $assets['js'].'<script src="./assets/js/popup.js" type="text/javascript"></script>'.PHP_EOL;
        }
    }
    if (is_array($arg) && count($arg) > 0) {
        // print only specific array file
        foreach ($arg as $asset) {
            echo $assets[$asset].PHP_EOL;
        }
    } elseif (is_array($arg) && count($arg) == 0) {
        // print all assets
        foreach ($assets as $asset => $value) {
            echo $value.PHP_EOL;
        }
    } else {
        //print only specific file
        echo $assets[$arg];
    }
}
function get_news($device_id)
{
    return '<div class="news-box"><ul><li class="msg-error">แจ้งปิดระบบ เพื่อทำการปรับปรุงให้ดีขึ้น - 30/12/2018</li><li class="msg-warning">แจ้งปิดระบบ เพื่อทำการปรับปรุงให้ดีขึ้น - 30/11/2018</li></ul></div>';
}
//short hand play sound
function play_sound($sound)
{
    if (!empty($sound)) {
        play_registered_sound($sound);
    }
}

//short hand function play sound ng
function play_sound_ng()
{
    play_sound('NG');
}
//short hand function play sound ok
function play_sound_ok()
{
    play_sound('OK');
}
//short hand function play sound complete
function play_sound_complete()
{
    play_sound('COMPLETE');
}
//play registered sound
function play_registered_sound($sound)
{
    if (array_key_exists($sound, $GLOBALS['assets']['SOUND'])) {
        play_sound_file($GLOBALS['assets']['SOUND'][$sound]);
    } else {
        echo "sound : {$sound} isn't register in our system.";
    }
}
//play our sound
function play_sound_file($sound)
{
    $sound_dir = SOUND_DIR.'/'.$sound;
    $sound_url = SOUND_URL.'/'.$sound;
    if (file_exists($sound_dir)) {
        play_sound_url($sound_url);
    } else {
        echo "file sound {$sound} doesn't exist in our system";
    }
}

//play anonymouse sound
function play_sound_url($url_sound)
{
    $html = <<<HTML
    <bgsound src="{$url_sound}"/>
HTML;
    echo $html;
}

function gen_grid_table($data, $cssClass = 'grid')
{
    if (!is_array($data)) {
        return;
    }

    $html = "<table class=\"{$cssClass}\"><thead>";
    foreach ($data['column_header'] as $header => $value) {
        $html .= "<th>{$value}</th>".PHP_EOL;
    }
    $html .= '</thead>'.PHP_EOL;
    $html .= '<tbody>'.PHP_EOL;

    foreach ($data['data_row'] as $row) {
        //$html .= "<tr bgcolor=\"{$row['ColorCode']}\">".PHP_EOL;
        $html .= "<tr>".PHP_EOL;
        foreach ($data['column_header'] as $key => $value) {
            $html .= "<td>{$row[$key]}</td>";
        }
        $html .= '</tr>'.PHP_EOL;
    }

    $html .= '</tbody>'.PHP_EOL;
    $html .= '</table>'.PHP_EOL;

    return $html;
}
function reset_display_message()
{
    global $message;
    $message = array();
}
function set_display_message($type, $msg)
{
    global $message;
    $message = array('type' => strtoupper($type), 'msg' => $msg);
}
function display_message()
{
    global $message;
    $html = '';
    $font_color = 'red';
    $bg_color = 'yellow';
    if (count($message) > 0) {
        switch (strtoupper($message['type'])) {
            case 'ERROR':
                $font_color = 'white';
                $bg_color = '#f44336';
            break;
            case 'WARNING':
                $font_color = 'black';
                $bg_color = '#ff9800';
            break;
            case 'INFO':
                $font_color = 'white';
                $bg_color = '#2196f3';
            break;
            case 'SUCCESS':
                $font_color = 'black';
                $bg_color = '#4caf50';
            break;
        }
        $html = "<div style=\"background:{$bg_color};color:{$font_color};opacity:0.83;margin-top:10px;\">{$message['type']} : {$message['msg']}</div>";
    }
    reset_display_message();

    return $html;
}
