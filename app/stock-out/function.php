<?php

$complete_word = 'COMPLETE';

function shopping_pk($rid, $palletno, $inhouse_sn)
{
    $url = "ShoppingPK?_USERNAME={$_SESSION['username']}&_DEVICE={$_SESSION['DeviceId']}&_SN={$inhouse_sn}&_MMHRID={$rid}&_PALLETCODE={$palletno}";
    $result = CallAPIGET('fast', $url, false);

    return $result;
}
