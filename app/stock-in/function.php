<?php

$complete_word = 'COMPLETE';

function get_order_list($docnum)
{
    $result = CallAPIGET('fast', "getorderlist?_USERNAME={$_SESSION['username']}&_DEVICE={$_SESSION['DeviceId']}&_DOCNUM={$docnum}", false);

    return $result;
}
function gen_order_fg($docnum)
{
    $result = CallAPIGET('fast', "GenOrderFG?_USERNAME={$_SESSION['username']}&_DEVICE={$_SESSION['DeviceId']}&_DOCNUM={$docnum}", false);

    return $result;
}
function shopping_do($rid, $inhouse_sn, $cust_partno)
{
    $result = CallAPIGET('fast', "ShoppingDo?_USERNAME={$_SESSION['username']}&_DEVICE={$_SESSION['DeviceId']}&_SN={$inhouse_sn}&_MMHRID={$rid}&_CUSTPARTNUM={$cust_partno}", false);

    return $result;
}
function validate_inhouse_sn($inhouse_sn)
{
    //$result = CallAPIGET('fast', "ValidateFGSerial?_USERNAME={$_SESSION['username']}&_DEVICE={$_SESSION['DeviceId']}&_SN={$sn}", false);
    $result = CallAPIPOST('api', 'InsertReceive', array('doctype' => '1234', 'mmtype' => '1','qty' => '1', 'qrcode' => $inhouse_sn,'deviceid' => $_SESSION['DeviceId']));
    
    return $result;
}
