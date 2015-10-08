<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 10/8/2015
 * Time: 3:55 AM
 */

//?? ???????? ?????
/* ?????????? ????????? ? ????????? ??????? ???? ??? MODX*/
@include('config.core.php');
if (!defined('MODX_CORE_PATH')) define('MODX_CORE_PATH', $_SEVER['DOCUMENT_ROOT'].'/core/');
/* ?????????? ????? modX */
if (!@include_once (MODX_CORE_PATH . "model/modx/modx.class.php")) {
    $errorMessage = 'Site temporarily unavailable';
    @include(MODX_CORE_PATH . 'error/unavailable.include.php');
    header('HTTP/1.1 503 Service Unavailable');
    echo "<html><title>Error 503: Site temporarily unavailable</title><body><h1>Error 503</h1><p>{$errorMessage}</p></body></html>";
    exit();
}
/* ????? ?????? ?? ?????? */

/* ??????? ????????? ?????? modX */
if (empty($options) || !is_array($options)) $options = array();
$modx= new modX('', $options);
if (!is_object($modx) || !($modx instanceof modX)) {
    @ob_end_flush();
    $errorMessage = '<a href="setup/">MODx not installed. Install now?</a>';
    @include(MODX_CORE_PATH . 'error/unavailable.include.php');
    header('HTTP/1.1 503 Service Unavailable');
    echo "<html><title>Error 503: Site temporarily unavailable</title><body><h1>Error 503</h1><p>{$errorMessage}</p></body></html>";
    exit();
}


include "snipets/ship.class.php";
ob_end_flush();
ob_start();
set_time_limit(0);

$dd = new Ship();
$dd->LoadShipsTours();
