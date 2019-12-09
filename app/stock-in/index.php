<?php
require_once __DIR__.'/function.php';

/* application config */
define('USE_AJAX', true);
$form_name = 'frmoperation';

/* end app config */

$complete_word = 'COMPLETE';
$operation_flag = '';

$pallete_no = '';
$inhkanban = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $step = $_POST['step'];
    $pallete_no = $_POST['txtpallete_no'];
    $inhkanban = $_POST['txtinhkanban_no'];

    switch ($step) {
        case 0:
            $pallete_no = $_POST['txtpalletno'];
            ++$step;
        break;
        case 1:
  
            $inhkanban = $_POST['txtinhkanban'];
            $valid_kanban_result = validate_inhouse_sn($inhkanban);            
            if (!empty($valid_kanban_result)) {
                        if ($valid_kanban_result->status == 1)
                        {
                            $receive_list = $valid_kanban_result->receive;
                            $array = json_decode(json_encode($receive_list),true);
                            //var_dump($array);    
                            //exit;
                            $column = array(
                                    'time' => 'Receive Time.',
                                    'part_id' => 'Part Cd.',
                                    'part_serial' => "Part Serial.",
                                );
                                 
                            $datatable = array('column_header' => $column, 'data_row' => $array);
                            $operation_flag = 'OK';
                        }
                        else {
                            set_display_message('error', $valid_kanban_result->content);
                            $operation_flag = 'NG';      
                        }
            } else {
                set_display_message('error', $valid_kanban_result->content);
                $operation_flag = 'NG';               
            }            
            //--$step;
        break;
    }
    
}else {
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

<form name="<?=$form_name; ?>" action="<?=$_SERVER['REQUEST_URI']; ?>" method="post" onsubmit="return validate_empty(this);" autocomplete="no">
<table id="table-menu">
<tr>
<td colspan="2"><div class="header-panel"><?=$app[basename(__DIR__)]['title']; ?></div></td>
</tr>

<?php
// set step show textbox for scan pallete
$html[0] = <<<HTML
<tr>
<td >Shelf No.:</td>
<td><input type="text" name="txtpalletno" size="15" maxlength="20" /></td>
</tr>
HTML;

// set step show textbox for scan inhouse kanban
$html[1] = <<<HTML
<tr>
<td >PROCESS K/B:</td>
<td><input type="text" name="txtinhkanban" size="15" maxlength="255"/></td>
</tr>
HTML;

// finally every step include button and invisible value for submit
$html[$step] .= <<<HTML
<tr>
<td colspan="2">
<input type="hidden" value="{$step}" name="step"/>
<input type="hidden" value="{$pallete_no}" name="txtpallete_no"/>
<input type="hidden" value="{$inhkanban}" name="txtinhkanban_no"/>
<input class="button" type="submit" name="btnSubmit" value="Submit"/>
</td>
</tr>
HTML;

/*
* render form
*/
echo $html[$step];

?>
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