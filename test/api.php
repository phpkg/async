<?php
/**
 * @author: Jackong
 * Date: 15/5/18
 * Time: 下午12:48
 */

$input = explode('&', file_get_contents('php://input'));
$params = [];
foreach ($input as $str) {
    list($key, $value) = explode('=', $str);
    $params[$key] = $value;
}

echo json_encode([
    'method' => $_SERVER['REQUEST_METHOD'],
    'params' => array_merge($_REQUEST, $params),
    'authorization' => $_SERVER['HTTP_AUTHORIZATION']
]);