<?php
/*
 * routing page
 *
 */
session_start();
include_once './common/config.php';
include_once './common/function.php';
?>
<html>
<head>
<title> Error page 
</title>
</head>
<body>
<h1><?=$_GET['code']; ?></h1>
<input type="button" value="Goto Home" onclick="window.location.href='<?=BASE_URL; ?>"/>
</body>
</html>