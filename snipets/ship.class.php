<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 27.09.15
 * Time: func15:23
 */

require_once 'functions.php';

/*Класс для работы с кораблями*/
class Ship
{


/*todo: сделать загрузку кораблей и круизо в модых*/


    /*Загружает список кораблей из сервиса*/
    function LoadShipsList()
    {
        global $modx;
        global $table_prefix;
    }

    /*Вставляет в базу один корабль из объекта $Ship*/
    function IncertShip($Ship)
    {
        global $modx;
        global $table_prefix;
    }



    /*получить InnerID корабля*/
    function GetShipInnerID($content_id)
    {
        global $modx;
        global $table_prefix;
    }


    /*Информация в ввиде объекта о корабля по его внутреннему номеру*/
    function GetShipInfo($ship_id)
    {
        global $modx;
        global $table_prefix;

    }

}