<?php
/* key
 allow -> allow ajax client connect to server
 deny  -> deny ajax client connect to server

example allowed
$allow_ajax_cors['allowed'][] = 'http://10.100.1.101:8082';
example deny
$allow_ajax_cors['deny'][] = 'http://10.100.1.102';

allow ajax cors
*/
$allow_ajax_cors = array();
$allow_ajax_cors['allowed'][] = 'http://10.100.1.101';
$allow_ajax_cors['allowed'][] = 'https://10.100.1.101';
$allow_ajax_cors['allowed'][] = 'http://10.100.1.101:8082';
$allow_ajax_cors['deny'][] = 'http://10.100.1.102';
