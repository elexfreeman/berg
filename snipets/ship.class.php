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

    public $ShipsParent = 2;
    public $ShipsTemplate = 2;
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

            $product->pagetitle=$ship;
            $product->parent=$this->ShipsParent;
            $product->template=$this->ShipsTemplate;

            $product->TV['t_title']=$ship;
            $product->TV['t_inner_id']=$inner_id;
            $product->TV['t_title_img'];

            $product->alias = encodestring($product->TV['t_inner_id'].'_'.$product->TV['t_title']);
            $product->url="ships/" .$product->alias . ".html";

            if(isset($ships_img[$inner_id]))  $product->TV['t_title_img']=$ships_img[$inner_id];
            IncertPage($product);
        }
    }


    /*
     * Описание объекта Ship
     * $Ship->pagetitle - Название корабля
     * $Ship->parent=2 - Родитель
     * $Ship->template=2 - Шаблон

     * $Ship->TV['t_title']
     * $Ship->TV['t_inner_id']
     * $Ship->TV['t_title_img']
     *
     *$Ship->alias = encodestring($Ship->TV['t_inner_id'].'_'.$Ship->TV['t_title']);
     *$Ship->url="ships/" .$Ship->alias . ".html"
     * */





    /*получить InnerID корабля*/
    function GetShipInnerID($content_id)
    {
        $ship=GetPageInfo($content_id);
        return $ship->TV['t_inner_id'];
    }


    /*Информация в ввиде объекта о корабля по его внутреннему номеру*/
    function GetShipInfo($ship_id)
    {
        GetPageInfo($ship_id);

    }



    /*Массив объектов теплоходов*/
    function GetShipsList()
    {
        global $modx;
        global $table_prefix;

        $sql="select * from ".$table_prefix."site_content where parent=".$this->ShipsParent;
        $Ships = array();
        foreach ($modx->query($sql) as $row)
        {
            $Ships[]=GetPageInfo($row['id']);
        }
        return $Ships;
        //print_r($Ships);

    }


    //Загрузка туров для теплохода
    function LoadShipsTours()
    {
        global $shipKey;
        $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/Tours/4/';
        echo $URL;
        $cruis_list=json_decode(file_get_contents($URL), true);
        print_r($cruis_list);
        /*Получаем список теплоходов*/
        $Ships=$this->GetShipsList();

        /*Перебераем этот список*/
        foreach($Ships as $key=>$Ship)
        {
            /*Загружаем список круизов для теплохода*/
            $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/Tours/'.$Ship->TV['t_inner_id'].'/';
            echo $URL."<br>";
            $cruis_list=json_decode(file_get_contents($URL), true);
            /*Перебираем этот список*/
            foreach($cruis_list as $id=>$cruis)
            {
                //echo $cruis['name']."\r\n";
                ob_flush();
                flush(); //ie working must
                $obj = new stdClass();

                $obj->pagetitle=$cruis['name'];
                $obj->parent=$Ship->id;
                $obj->template=3;
                $obj->TV['kr_name']=$cruis['name'];
                $obj->TV['kr_inner_id']=$id;
                $obj->TV['kr_date_start']=$cruis['date_start'];
                $obj->TV['kr_date_end']=$cruis['date_end'];
                $obj->TV['kr_nights']=$cruis['nights'];
                $obj->TV['kr_days']=$cruis['days'];
                $obj->TV['kr_weekend']=$cruis['weekend'];
                $obj->TV['kr_cities']=$cruis['cities'];
                $obj->TV['kr_route']=$cruis['route'];
                $obj->TV['kr_route_name']=$cruis['route_name'];
                $obj->TV['kr_region']=$cruis['region'];
                $obj->TV['kr_river']=$cruis['river'];
                $obj->TV['kr_surchage_meal_rub']=$cruis['surchage_meal_rub'];
                $obj->TV['kr_surcharge_excursions_rub']=$cruis['surcharge_excursions_rub'];

                $obj->alias = encodestring($obj->TV['kr_inner_id'].'_'.$obj->TV['kr_name']);
                $obj->url="ships/".$Ship->alias."/".$obj->alias . ".html";
                $cruis_alias=$obj->alias;
                print_r($obj);
                $cruis_id=IncertPage($obj);
                /*Вставляем цены*/


                /*Нужен выделенный сервер чтобы проставить таймауты*/
               /* foreach($cruis['prices'] as $price_id=>$price)
                {
                    $obj = new stdClass();

                    $obj->pagetitle=$price['name'];
                    $obj->parent=$cruis_id;
                    $obj->template=6;
                    $obj->TV['cr_price_name']=$price['name'];
                    $obj->TV['cr_price_price_eur']=$price['price_eur'];
                    $obj->TV['cr_price_price_usd']=$price['price_usd'];
                    $obj->TV['cr_price_places_total']=$price['places_total'];
                    $obj->TV['cr_price_places_free']=$price['places_free'];


                    $obj->alias = encodestring($price_id.'_'.$obj->pagetitle);
                    $obj->url="ships/".$Ship->alias."/".$cruis_alias."/".$obj->alias . ".html";
                    print_r($obj);
                    IncertPage($obj);
                }*/

            }
        }
    }


    function LoadShipsPhoto()
    {

        $Ships=$this->GetShipsList();

        /*Перебераем этот список*/
        foreach($Ships as $key=>$Ship)
        {
            $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/ShipsPhoto/'.$Ship->TV['t_inner_id'].'/';
            echo $URL."<br>";
            $ShipsPhotos=json_decode(file_get_contents($URL), true);
            foreach($ShipsPhotos as $id=>$Images)
            {
                $obj = new stdClass();

                $obj->pagetitle='Img_'.$key."_".$id;
                $obj->parent=$Ship->id;
                $obj->template=5;
                $obj->TV['ph_t_full']=$Images['full'];

                $obj->alias = encodestring($obj->pagetitle);
                $obj->url="ships/".$Ship->alias."/".$obj->alias . ".html";
                print_r($obj);
                IncertPage($obj);
            }
        }
    }

    function tplShipsList()
    {
        include "tpl/tplShipsList.php";

    }


    function Run($scriptProperties)
    {
        if(isset($scriptProperties['action']))
        {
            if($scriptProperties['action']=='LoadShipsList') $this->LoadShipsList();
            if($scriptProperties['action']=='LoadShipsTours') $this->LoadShipsTours();
            if($scriptProperties['action']=='LoadShipsPhoto') $this->LoadShipsPhoto();
            if($scriptProperties['action']=='tplShipsList') $this->tplShipsList();
        }
    }

}