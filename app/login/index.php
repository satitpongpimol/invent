<?php
require_once __DIR__.'/function.php';
/* application config */
define('USE_AJAX', true);

if (isset($_POST['btnLogin'])) {
    $username = $_POST['txtusername'];
    $userpass = $_POST['txtpassword'];

    $flag = $_POST['function_flag'];
    $redirect_url = $_POST['callbackUrl'];

    $user_entity = check_login($username, $userpass);

    if (!empty($user_entity)) {
        switch (strtoupper($flag)) {
            case 'LOGIN':
                if ($user_entity->status <> -1)
                {
                    set_user_session($user_entity);
                    goto_page('MENU');
                }
                else {
                    $message['type'] = 'ERROR';
                    $message['msg'] = 'Invalid Username or password!';
                }
            break;
            case 'UNLOCK':
                if (isset($redirect_url)) {
                    $_SESSION['locked'] = 0;
                    redirect_url($redirect_url);
                }
            break;
        }
    } else {
        $message['type'] = 'ERROR';
        $message['msg'] = 'Invalid Username or password!';
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
<?=include_template_assets(); ?>
<style type="text/css">
.header-panel{
    text-align:center;
    font-size:13px;
    width:100%;
    height:30px;
    padding-top:5px;
    margin-bottom:5px;
    background: #1C6EA4;
    border-bottom: 2px solid #444444;
    font-size: 15px;
    font-weight: bold;
    color: #FFFFFF;
    border-left: 2px solid #D0E4F5;
}
.message-panel{
    text-align:center;
    width:100%;
    height:30px;
    padding-top:5px;
    margin-bottom:5px;
    font-size: 14px;
    font-weight: bold;
    color: #FFFFFF;
    background: #267795;
}
</style>
</head>
<body onload="return Login_setfocus();">
<div class="header-panel">
AISIN H/T APP
</div>
<div id="container">
<?=login_form('Login', 'LOGIN'); ?>
</div>
<div id="footer">
<?=display_message(); ?>
</div>

<div>
Device ID :<?=$_SESSION['DeviceId']; ?>
</div>

<?=get_news($_SESSION['DeviceId']); ?>

</body>
</html>