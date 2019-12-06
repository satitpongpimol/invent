
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<title>AISIN HT PROGRAM</title>
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
<body>
<div id="container">
<div class="header-panel">
AISIN H/T APP
</div>
<table id="table-menu">
<tr><td>
<?php
foreach ($app as $item => $value) {
    $app_index = APP_DIR."/{$item}/index.php";
    if (file_exists($app_index)) {
        echo "<input class=\"button\" type=\"button\" value=\"{$value['title']}\" onclick=\"window.location='?app={$item}';\"/><br/>".PHP_EOL;
    }
}
?>
</td></tr>
</table>
</div>
<div class="message-panel">
Version <?=APP_VERSION; ?>&nbsp;<?=APP_RELEASE_STATUS; ?> &nbsp;
</div>
</body>
</html>