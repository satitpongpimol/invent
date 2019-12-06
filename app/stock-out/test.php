<?php
require_once APP_DIR.'/shopping_domestic/function.php';
require_once __DIR__.'/function.php';

$docnum = '';
$pallete_no = '';
$mm_rowid = 0;
$operation_flag = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $step = $_POST['step'];
    $docnum = $_POST['txtdocnum'];
    $pallete_no = $_POST['txtpallete_no'];
    $mm_rowid = $_POST['txtmm_rowid'];

    $column = array('');

    switch ($step) {
        case 0:
            $docnum = $_POST['txtpickingno'];
            gen_order_fg($docnum, $_SESSION['DeviceId'], $_SESSION['username']);
            ++$step;
        break;
        case 1:
                $pallete_no = $_POST['txtpalletno'];
                ++$step;
        break;
        case 2:
                if (strcasecmp(strtoupper($_POST['txtinhkanban']), $complete_word) == 0) {
                    goto_page('menu');
                } else {
                    $result_shopping = shopping_pk($mm_rowid, $pallete_no, $_POST['txtinhkanban']);

                    if ($result_shopping['Validate']['Status'] == 'Y') {
                        $operation_flag = 'OK';
                    } else {
                        $operation_flag = 'NG';
                        set_display_message('ERROR', $result_shopping['Validate']['Message']);
                    }

                    if ($result_shopping['IsComplete'] === 'Y') {
                        $step = 0;
                        $operation_flag = 'COMPLETE';
                    }
                }
        break;
    }
    // show picking list
    // show on step 0 but increased step
    // show on step 3 but decreased step
    // also like this
    if ($step > 0 && $step <= 3) {
        $order_result = get_order_list($docnum);
        if ($order_result['Validate']['Status'] == 'Y') {
            $mm_rowid = $order_result['DocRid'];
            $column = array(
                    'PartNum' => 'Part No.',
                    'PartCode' => 'Part Cd.',
                    'Qpack' => "Q'Pck.",
                    'OrderQty' => "Q'Ord.",
                    'PickQty' => "Q'ty",
                );
            $datatable = array('column_header' => $column, 'data_row' => $order_result['PickingList']);
        } else {
            --$step;
            set_display_message('error', $order_result['Validate']['Message']);
        }
    }
} else {
    $step = 0;
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Shopping Export</title>
<?=include_template_assets(); ?>
<script src="./assets/js/popup.js" type="text/javascript"></script>

<script type="text/javascript">
function pageload(){
    var frm = '<?=(!empty($operation_flag) && $operation_flag !== 'NG') ? 'frmShopping' : 'frmLogin'; ?>';
    <?php
        gen_js_popup_form($operation_flag);
    ?>
    form_setfocus(frm,0);

}
</script>
<script type="text/javascript">
window.onload = pageload;
</script>
<script type="text/javascript">
function setfocus(frm){
    var step = 0;
    <?php
    if (!empty($operation_flag) && $operation_flag !== 'NG') {
        gen_js_popup_form($operation_flag);
    }
    ?>
    form_setfocus(frm,step);
}
function validate_empty(frm){
    var txt = frm.elements[0];
    if(txt.value == ''){
        txt.focus();
        return false;
    }
    return true;
}
</script>
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
    // border-left: 2px solid #D0E4F5;
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
<?php
if ($operation_flag == 'NG') {
        $frmname = 'frmLogin';
    } else {
        $frmname = 'frmShopping';
    }
$setfocus = "onload=\"return setfocus('{$frmname}');\"";
?>
</head>
<body <?=$setfocus; ?>>
<div id="container">
<?php
if ($operation_flag == 'NG') {
    gen_ng_form();
} else {
    ?>
<div id="Wndpopup" class="wnd-popup">
</div>
<form name="frmShopping" action="<?=$_SERVER['REQUEST_URI']; ?>" method="post" onsubmit="return validate_empty(this);" autocomplete="no">
<table id="table-menu">
<tr>
<td  colspan="2"><div class="header-panel">Export Shopping</div></td>
</tr>
<?php
$html[0] = <<<HTML
<tr>
<td>PKL No:</td>
<td ><input type="text" name="txtpickingno" size="15" maxlength="20" /></td>
</tr>
HTML;
    $html[1] = <<<HTML
<tr>
<td >PLT No.:</td>
<td><input type="text" name="txtpalletno" size="15" maxlength="20" /></td>
</tr>
HTML;
    $html[2] = <<<HTML
<tr>
<td >INH K/B:</td>
<td><input type="text" name="txtinhkanban" size="15" maxlength="255"/></td>
</tr>
HTML;
    $html[$step] .= <<<HTML
<tr>
<td colspan="2">
<input type="hidden" value="{$step}" name="step"/>
<input type="hidden" value="{$mm_rowid}" name="txtmm_rowid"/>
<input type="hidden" value="{$docnum}" name="txtdocnum"/>
<input type="hidden" value="{$pallete_no}" name="txtpallete_no"/>
<input class="button" type="submit" name="btnSubmit" value="Submit"/>
</td>
</tr>
HTML;
?>
<?=$html[$step]; ?>
</table>
</form>
<?php
if (isset($datatable)) {
    echo gen_grid_table($datatable);
    unset($datatable);
} ?>
<?php
} ?>
<?=display_message(); ?>
</div>
</body>
</html>