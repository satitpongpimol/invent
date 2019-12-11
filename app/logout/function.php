<?php

function gen_logout_form($header_text, $function_flag)
{
    $html = '<form name="frmLogout" action="'.post_action('logout', 'login').'" method="post"  onsubmit="return form_validate();">';
    $html .= <<<HTML
<table class="login-form">
<tr>
<td colspan="2"><h3>{$header_text}</h3><hr/></td>
</tr>
<tr>
<td colspan="2">
<hr/>
<input type="submit" class="button" name="btnLogout" value="Continue Logout"/><br/>
<input type="button" class="button" name="btnCancel" value="Go To Menu"/ onclick="javascript:window.location.href='?page=MENU';">
</td>
</tr>
</table>
<input type="hidden" value="{$function_flag}" name="function_flag"/>
<input type="hidden" value="{$_SERVER['REQUEST_URI']}" name="callbackUrl"/>
</form>
HTML;
    echo $html;
}
