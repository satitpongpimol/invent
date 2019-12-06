<?php

$callbackurl = '';

/*
 * page redirection
 */

function post_action($app, $action)
{
    $url = BASE_URL.'?app='.$app.'&'.$action;

    return $url;
}
function goto_app($app)
{
    $url = BASE_URL.'?app='.$app;
    redirect_url($url);
}
function goto_page($url)
{
    $url = BASE_URL.'?page='.$url;
    redirect_url($url);
}
function redirect_url($url)
{
    header('location:'.$url);
    //echo "<script>window.location='{$url}';</script>";
}
function link_page($page)
{
    $url = BASE_URL.'?page='.$page;

    return $url;
}
function goto_notfound_page()
{
    redirect_url(ERROR_DIR.'/404.php');
}
function render_widget($widget)
{
    $widget_path = WIDGET_DIR."/{$widget}.php";
    existing_page($widget_path);
}
function render_header()
{
    $headerpage = LAYOUT_DIR.'/header.php';
    existing_page($headerpage);
}
function render_sidebar()
{
    $sidebarpage = LAYOUT_DIR.'/side-bar.php';
    existing_page($sidebarpage);
}
function render_page($page)
{
    $page = PAGE_DIR."/{$page}.php";
    existing_page($page, $model);
}
function render_view($controller, $view)
{
    $page = PAGE_DIR."/{$controller}/{$view}.php";
    existing_page($page);
}
function render_badge($amount)
{
    echo $amount > 0 ? '<span class="badge badge-danger">'.$amount.'</span>' : '';
}
function get_date_string($date)
{
    $retdate = '';
    if (!empty($date)) {
        $retdate = date('d-M-Y', strtotime($date));
    }

    return $retdate;
}
function existing_page($page)
{
    if (file_exists($page)) {
        include_once $page;
    } else {
        echo "file : {$page} doesn't existing.";
    }
}
function show_modal_message($header_msg, $body_msg, $footer_msg)
{
    $template = <<<MSG
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">$header_msg</h4>
                                        </div>
                                        <div class="modal-body">
                                            $body_msg
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
MSG;
    echo $template;
}
function show_msg($msgtype, $msg)
{
    switch (strtoupper($msgtype)) {
        case 'ERROR':
        show_error_msg($msg);
        break;
        case 'INFO':
        show_info_msg($msg);
        break;
        case 'WARNING':
        show_warning_msg($msg);
        break;
        case 'SUCCESS':
        show_success_msg($msg);
        break;
    }
}
function show_error_msg($msg)
{
    $template = msg_template('danger', $msg);
    echo $template;
}
function show_success_msg($msg)
{
    $template = msg_template('success', $msg);
    echo $template;
}
function show_info_msg($msg)
{
    $template = msg_template('info', $msg);
    echo $template;
}
function show_warning_msg($msg)
{
    $template = msg_template('warning', $msg);
    echo $template;
}
function msg_template($msg_type, $msg)
{
    $template = <<<MSG
    <div class="alert alert-$msg_type alert-dismissable">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
       $msg
    </div>
MSG;

    return $template;
}
function link_attachfile($username, $fileid)
{
    if ($fileid == 0) {
        return;
    }
    global $_Endpoint,$_Service;
    $MyUrl = $_Endpoint."/api/DocFile/GetRawFile?_USERNAME={$username}&_FILERID={$fileid}";

    return $MyUrl;
}
function show_alert_msg($msg)
{
    echo "<script>bootbox.alert('{$msg}');</script>";
}
function set_callback_url($url)
{
    $GLOBALS['callbackurl'] = $url;
}
function get_callback_url()
{
    $url = $GLOBALS['callbackurl'];
    $GLOBALS['callbackurl'] = '';

    return $url;
}
