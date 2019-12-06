<?php

function login_form($header_text, $function_flag)
{
    $html = '<form name="frmLogin" action="'.post_action('login', 'login').'" method="post"  onsubmit="return login_validate();">';
    $html .= gen_login_form();
    $html .= '<input type="hidden" value="'.$function_flag.'" name="function_flag"/>';
    if (isset($GLOBALS['callbackurl']) && !empty($GLOBALS['callbackurl'])) {
        $html .= <<<HTML
<input type="hidden" value="{$GLOBALS['callbackurl']}" name="callbackUrl"/>
HTML;
    } else {
        $html .= <<<HTML
<input type="hidden" value="{$_SERVER['REQUEST_URI']}" name="callbackUrl"/>
</form>
HTML;
    }
    $html .= '</form>';

    return $html;
}

function ajax_login_form($action)
{
    $html = '<form name="frmLogin" action="'.post_action('login', 'api&operation='.$action).'" method="post"  onsubmit="return ajax_login(this);">';
    $html .= str_replace(array("\n\r", "\n", "\r"), '', gen_login_form());
    $html .= '</form>';

    return $html;
}

function gen_login_form()
{
    $html = <<<HTML
    <table class="login-form">
    <tr><td>Username:</td><td><input type="text" name="txtusername" size="15" autofocus="autofocus"/></td></tr>
    <tr><td>Password:</td><td><input type="password" name="txtpassword" size="15"/></td></tr>
    <tr><td colspan="2"><input type="submit" name="btnLogin" value="login"/></td></tr>
    </table>
HTML;

    return $html;
}

// check user login
function check_login($username, $password)
{
    //check username from barcode scan
    $isBarcodeUser = strpos($username, '||');
    $user = $username;
    $pass = $password;

    if ($isBarcodeUser) {
        $extract_user = explode('||', $username);
        if (count($extract_user) == 2) {
            list($user, $pass) = $extract_user;
        }
    }

    $result = CallAPIPOST('api', 'login', array('username' => $user, 'password' => $pass));
    if ($result == '[]') {
        $result = '';
    }
    return $result;
}

// set user entity
function set_user_session($entity)
{
    if (empty($entity) || is_null($entity)) {
        return;
    }

    //$_SESSION['username'] = $entity[0]->USERNAME;
    //$_SESSION['position'] = $entity[0]->POSITION;
    //$_SESSION['level'] = $entity[0]->LEVEL;
    //$_SESSION['userid'] = $entity[0]->USERID;
    $_SESSION['content'] = $entity->content;
    $_SESSION['token'] = $entity->token;
    $_SESSION['title'] = $entity->title;
    $_SESSION['loggedIn'] = $entity->status;
}
