<?php
require_once APP_DIR.'/shopping_domestic/function.php';
require_once __DIR__.'/function.php';

/* application config */
define('USE_AJAX', true);
$form_name = 'frmoperation';
/* end app config */

$complete_word = 'COMPLETE';
$operation_flag = '';

$docnum = '';
$pallete_no = '';
$mm_rowid = 0;

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

<?php
/*
*  render header page include title
*/
app_header($app[basename(__DIR__)]['title']);

/*
* render body page include javascript set form focus
*/
app_body($operation_flag, $form_name);

?>

<form name="frmoperation" action="<?=$_SERVER['REQUEST_URI']; ?>" method="post" onsubmit="return validate_empty(this);" autocomplete="no">
<table id="table-menu">
<tr>
<td  colspan="2"><div class="header-panel"><?=$app[basename(__DIR__)]['title']; ?></div></td>
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
/*
* show datatable
*/

if (isset($datatable)) {
    echo gen_grid_table($datatable);
    // clear datatable
    unset($datatable);
}

/*
* render message
*/
display_message();

/*
* render end tag
*/
app_end();

?>