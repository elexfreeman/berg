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

    public $shipKey='ad441cf7449bc9af3977e6b0c2a6806e3655247c';

/*todo: сделать загрузку кораблей и круизо в модых*/


    /*Загружает список кораблей из сервиса*/
    /*todo: загрузка TV
    - t_title название теплохода
    - t_inner_id внутренний номер в базе
    - t_title_img Титульная фотография теплохода
    */




    function LoadShipsList()
    {
        global $modx;
        global $table_prefix;
        global $shipKey;
        $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/Ships/';
        $ships=json_decode(file_get_contents($URL), true);

        $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/ShipsImages/';
        $ships_img=json_decode(file_get_contents($URL), true);

        foreach($ships as $inner_id => $ship)
        {
            $product = new stdClass();
            $product->ShipName=$ship;
            $product->inner_id=$inner_id;
            if(isset($ships_img[$inner_id]))  $product->title_img=$ships_img[$inner_id];


            $this->IncertShip($product);
        }
    }


    /*
     * Описание объекта Ship
     * $Ship->pagetitle - Название корабля
     * $Ship->parent=2 - Родитель
     * $Ship->template=2 - Шаблон
     * $Ship->url=2 - Шаблон
     * $Ship->TV['t_title']
     * $Ship->TV['t_inner_id']
     * $Ship->TV['t_title_img']
     *
     *$Ship->alias = encodestring($Ship->TV['t_inner_id'].'_'.$Ship->TV['t_title']);
     *$Ship->url="ships/" .$Ship->alias . ".html"
     * */

    /*Вставляет в базу один корабль из объекта $Ship*/
    function IncertShip($Ship)
    {
        global $modx;
        global $table_prefix;
        //импортируем страницы
        $parent = 2;
        $template = 2;
        //Ищем такую страницу
        $pagetitle = $Ship->ShipName;
        $alias = encodestring($Ship->inner_id.'_'.$Ship->ShipName);
        $url = "ships/" . $alias . ".html";


        $product_id = 0;
        $sql_page = "select * from " . $table_prefix . "site_content where pagetitle='" . mysql_escape_string($pagetitle) . "'";
        echo $sql_page;
        foreach ($modx->query($sql_page) as $row_page) {
            $product_id = $row_page['id'];
        }
        if ($product_id == 0) {
            $sql_product = "INSERT INTO " . $table_prefix . "site_content
(id, type, contentType, pagetitle, longtitle,
description, alias, link_attributes,
published, pub_date, unpub_date, parent,
isfolder, introtext, content, richtext,
template, menuindex, searchable,
cacheable, createdby, createdon,
editedby, editedon, deleted, deletedon,
deletedby, publishedon, publishedby,
menutitle, donthit, privateweb, privatemgr,
content_dispo, hidemenu, class_key, context_key,
content_type, uri, uri_override, hide_children_in_tree,
show_in_tree, properties)
VALUES (NULL, 'document', 'text/html', '" . $pagetitle . "', '', '', '" . encodestring(mysql_escape_string($articul . "-" . $pagetitle)) . "',
'', true, 0, 0, " . $parent . ", false, '', '', true, " . $template . ", 1, true, true, 1, 1421901846, 0, 0, false, 0, 0, 1421901846, 1, '',
false, false, false, false, false, 'modDocument', 'web', 1,
 '" . $url . "', false, false, true, null
 );

;";
            echo "------------------------------------------------------";
            echo "--------------------- ПРОДУКТ ------------------------";
            echo $sql_product . "<br>";
            $modx->query($sql_product);
            $product_id = $modx->lastInsertId();
        }
        IncertPageTV($product_id,'t_title',$Ship->ShipName);
        IncertPageTV($product_id,'t_inner_id',$Ship->inner_id);
        IncertPageTV($product_id,'t_title_img',$Ship->title_img);
        print_r($Ship);
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

    function Run($scriptProperties)
    {
        if(isset($scriptProperties['action']))
        {
            if($scriptProperties['action']=='LoadShipsList') $this->LoadShipsList();
        }
    }

}