<?php

$complete_word = 'COMPLETE';

function shopping_pk($rid, $inhouse_sn)
{
    $result = CallAPIGET('fast', "ShoppingPK?_USERNAME={$_SESSION['username']}&_DEVICE={$_SESSION['DeviceId']}&_SN={$inhouse_sn}&_MMHRID={$rid}", false);

    return $result;
}
