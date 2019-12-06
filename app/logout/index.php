<?php
require_once __DIR__.'/function.php';

if (isset($_POST['btnLogout'])) {
    session_destroy(); //destroy the session
    goto_app('login');
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
<?=include_template_assets(); ?>

</head>
<body>
<div id="container">
<?=gen_logout_form('Log out', 'LOGIN'); ?>
</div>
</body>
</html>