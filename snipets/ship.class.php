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

    public $CruisTemplate = 3;

    public $ShipPhotoTemplate = 5;
    public $CruisPriceTemplate = 5;
    public $CityTemplate = 9;
    public $CityParent = 4528;
    public $PriceTemplate = 6;
    public $ExTemplate = 10;
    public $CautaTemplate = 4;

    public $ZayavkaTemplate = 11;
    public $ZayavkaParent = 20303;




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


        $sql="select
                    ships.id ship_id,
                    ships.pagetitle ship_title,
                    tv.name tv_name,
                    cv.value tv_value


                    from ".$table_prefix."site_content ships

                    left join ".$table_prefix."site_tmplvar_contentvalues cv
                    on ships.id=cv.contentid

                    left join ".$table_prefix."site_tmplvars tv
                    on tv.id=cv.tmplvarid


                    where (ships.parent=".$this->ShipsParent.")and(tv.name='t_in_filtr')

";
        echo $sql;
        $Ships = array();
        foreach ($modx->query($sql) as $row)
        {
            $Ships[]=GetPageInfo($row['ship_id']);
        }
        return $Ships;
        //print_r($Ships);
    }


    /*Список городов выбраных кораблей*/
    function GetShipsCityList()
    {
        global $modx;
        global $table_prefix;
        $sql="	select
	kr.id kr_id,
	kr.pagetitle kr_title,
	tv.name tv_name,
	cv.value tv_value


	from " . $table_prefix . "site_content kr

	left join " . $table_prefix . "site_tmplvar_contentvalues cv
	on kr.id=cv.contentid

	left join " . $table_prefix . "site_tmplvars tv
	on tv.id=cv.tmplvarid

	where (kr.parent in
				(

			-- ********************************
				select ship_id id from
				(
				select
				ships.id ship_id,
				ships.pagetitle ship_title,
				tv.name tv_name,
				cv.value tv_value


				from " . $table_prefix . "site_content ships

				left join " . $table_prefix . "site_tmplvar_contentvalues cv
				on ships.id=cv.contentid

				left join " . $table_prefix . "site_tmplvars tv
				on tv.id=cv.tmplvarid


				where (ships.parent=".$this->ShipsParent.")and(tv.name='t_in_filtr')

				) ships_tbl
			-- ********************************
			)
)

and(kr.template=".$this->CruisTemplate." )and(tv.name='kr_cities')
order by cv.value
";


        $citiesy=array();

        foreach ($modx->query($sql) as $row_c_tv)
        {
            $tmp=explode(" – ",$row_c_tv['tv_value']);

            foreach($tmp as $city)
            {
                $citiesy[$city]=1;
            }
        }
        return $citiesy;
    }

    //ЗАгрузка статусов кают
    function LoadCauts()
    {
        global $modx;
        global $table_prefix;
        global $shipKey;
        echo "<pre>";
        $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/Tours/4/';
        echo $URL;

       /* $cruis_list=json_decode(file_get_contents($URL), true);*/

/*
        $sql="select
               ships.id ship_id,
                ships.alias ship_aliac,
                ships.pagetitle ship_title,
                cruis.id cruis_id,
                cruis.alias cruis_aliac,
                cruis.pagetitle cruis_title

                from modx_site_content ships


                join modx_site_content cruis
                on cruis.parent=ships.id

                 where
                 (ships.template=".$this->ShipsTemplate.")and(cruis.template=".$this->CruisTemplate.")";
*/
        $Ships=$this->GetShipsList();
       // print_r($Ships);

        /*Перебераем этот список*/
        foreach($Ships as $key=>$ship)
        {
            echo "********// ship ".$ship->title."\r\n";
            $cruis_list=$this->GetShipCruisList($ship->id);
            foreach($cruis_list as $cr_id=>$cruis)
            {
                echo "********* CRUIS".$cruis->title."\r\n";
                $URL='http://api.infoflot.com/JSON/'.
                    $this->shipKey.'/CabinsStatus/'.$ship->TV['t_inner_id'].'/'.$cruis->TV['kr_inner_id']."/";
                echo $URL."\r\n";
                $cauta_list=json_decode(file_get_contents($URL), true);
               // print_r($cauta_list);
                foreach($cauta_list as $id=>$cauta)
                {
                    echo "********* cauta".$cauta['name']."\r\n";
                   /* ob_flush();
                    flush();*/
                     //ie working must
                    $obj = new stdClass();

                    $obj->pagetitle=$ship->alias."-".$cruis->alias."-".$id."_".$cauta['name'];
                    $obj->parent=$cruis->id;
                    $obj->template=$this->CautaTemplate;
                    $obj->TV['k_name']=$cauta['name'];
                    $obj->TV['k_type']=$cauta['type'];
                    $obj->TV['k_deck']=$cauta['deck'];
                    $obj->TV['k_separate']=$cauta['separate'];
                    $obj->TV['k_status']=$cauta['status'];
                    $obj->TV['k_gender']=$cauta['gender'];
                    $obj->TV['k_inner_id']=$id;

                    $obj->TV['k_places']='';
                    $places=$cauta['places'];
                    foreach($places as $place_id=>$place)
                    {
                        $obj->TV['k_places'].="ID:".$place_id."-NAME:".$place['name']."-TYPE:".$place['type']."-POSITION:".$place['position']."-STATUS:".$place['status']."||";
                    }

                    $obj->alias = encodestring($obj->pagetitle);
                    $obj->url="ships/".$ship->alias."/".$cruis->alias."/" . $obj->alias.".html";

                  //  echo "=================== Каюта \r\n";
                   // print_r($obj);

                    echo "cauta_id=".IncertPage($obj)."\r\n";
                    // $cruis_inner_id=$obj->TV['kr_inner_id'];

                }
            }


         /*  */

        }




/*
        foreach ($modx->query($sql) as $row)
        {
            $ship=GetPageInfo($row['ship_id']);
            print_r($ship);

            $cruis=GetPageInfo($row['cruis_id']);
            print_r($cruis);

            $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/CabinsStatus/'.$ship->TV['k_inner_id'].'/'.$cruis->TV['kr_inner_id']."/";
            echo $URL;

            $cauta_list=json_decode(file_get_contents($URL), true);
            foreach($cauta_list as $id=>$cauta)
            {
                ob_flush();
                flush(); //ie working must
                $obj = new stdClass();

                $obj->pagetitle=$id."_".$cauta['name'];
                $obj->parent=$row['cruis_id'];
                $obj->template=$cauta->CruisTemplate;
                $obj->TV['k_name']=$cauta['name'];
                $obj->TV['k_type']=$cauta['type'];
                $obj->TV['k_deck']=$cauta['deck'];
                $obj->TV['k_separate']=$cauta['separate'];
                $obj->TV['k_status']=$cauta['status'];
                $obj->TV['k_gender']=$cauta['gender'];
                $obj->TV['k_inner_id']=$id;

                $obj->TV['k_places']='';
                $places=$cauta['places'];
                foreach($places as $place_id=>$place)
                {
                    $obj->TV['k_places']=$place_id."-".$place['name']."-".$place['type']."-".$place['position']."-".$place['status']."||";

                }

                $obj->alias = encodestring($obj->pagetitle);
                $obj->url="ships/".$row['ship_aliac']."/".$row['cruis_aliac']."/" . $obj->alias.".html";

                //print_r($obj);
                echo "Круиз \r\n";
                IncertPage($obj);
               // $cruis_inner_id=$obj->TV['kr_inner_id'];

            }
        }
        */
    }


    //Загрузка туров для теплохода
    function LoadShipsTours()
    {
        global $shipKey;
        echo "<pre>";
        $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/Tours/4/';
        echo $URL;
        $cities=array();
        $cruis_list=json_decode(file_get_contents($URL), true);
       // print_r($cruis_list);
        /*Получаем список теплоходов*/
        $Ships=$this->GetShipsList();

        /*Перебераем этот список*/
        foreach($Ships as $key=>$Ship)
        {

            echo "Корбель \r\n";
            print_r($Ship);

            /*Загружаем список круизов для теплохода*/
            $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/Tours/'.$Ship->TV['t_inner_id'].'/';
            echo $URL."<br>";
            $cruis_list=json_decode(file_get_contents($URL), true);
            /*Перебираем этот список*/
            echo "-------------------------------------
            ";
            echo "-------------------------------------
            ";
            echo "Список круизов
            ";
            foreach($cruis_list as $id=>$cruis)
            {
                //echo $cruis['name']."\r\n";
                ob_flush();
                flush(); //ie working must
                $obj = new stdClass();

                $obj->pagetitle=$id."_".$cruis['name'];
                $obj->parent=$Ship->id;
                $obj->template=$this->CruisTemplate;
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

                $obj->alias = encodestring($obj->pagetitle);
                $obj->url="ships/".$Ship->alias."/".$obj->alias . ".html";
                $cruis_alias=$obj->alias;
                //print_r($obj);
                echo "Круиз \r\n";
                $cruis_id=IncertPage($obj);
                $cruis_inner_id=$obj->TV['kr_inner_id'];
                /*Вставляем цены*/

                //Обновляем города
                $tmp=explode(' – ',$obj->TV['kr_cities']);
                foreach($tmp as $city)
                {
                    $cities[$city]=1;
                }



                /*Нужен выделенный сервер чтобы проставить таймауты*/
                echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                ";
                echo "Цены
                ";
                foreach($cruis['prices'] as $price_id=>$price)
                {
                    $obj2 = new stdClass();

                    $obj2->pagetitle=$cruis['name']."_".$price_id."_".$price['name'];
                    $obj2->parent=$cruis_id;
                    $obj2->template=$this->PriceTemplate;
                    $obj2->TV['cr_price_name']=$price['name'];
                    $obj2->TV['cr_price_price_eur']=$price['price_eur'];
                    $obj2->TV['cr_price_price']=$price['price'];
                    $obj2->TV['cr_price_price_usd']=$price['price_usd'];
                    $obj2->TV['cr_price_places_total']=$price['places_total'];
                    $obj2->TV['cr_price_places_free']=$price['places_free'];


                    $obj2->alias = encodestring($obj2->pagetitle);
                    $obj2->url="ships/".$Ship->alias."/".$cruis_alias."/".$obj2->alias . ".html";
                   //  print_r($obj2);
                    IncertPage($obj2);
                }


                /*Загружаем экскурсии*/
              /*  echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                ";
                echo "экскурсии
                ";
                $URL='http://api.infoflot.com/JSON/'.$this->shipKey.'/Excursions/'.$Ship->TV['t_inner_id'].'/'.$cruis_inner_id."/";
                echo $URL."<br>";
                $ex_list=json_decode(file_get_contents($URL), true);
                foreach($ex_list as $ex_inner_id=>$ex)
                {

                    ob_flush();
                    flush(); //ie working must
                    $obj2 = new stdClass();

                    $obj2->pagetitle=$ex_inner_id."_".$ex['city'];
                    $obj2->parent=$cruis_id;
                    $obj2->template=$this->ExTemplate;
                    $obj2->TV['ex_city']=$ex['city'];
                    $obj2->TV['ex_date_start']=$ex['date_start'];
                    $obj2->TV['ex_time_start']=$ex['time_start'];
                    $obj2->TV['ex_date_end']=$ex['date_end'];
                    $obj2->TV['ex_time_end']=$ex['time_end'];
                    $obj2->TV['ex_description']=$ex['description'];


                    $obj2->alias = encodestring($ex_inner_id."_".$obj2->pagetitle);
                    $obj2->url="ships/".$Ship->alias."/".$cruis_alias."/".$obj2->alias . ".html";
                    //  print_r($obj2);
                    IncertPage($obj2);
                }*/

            }
        }

        /*Вставляем странцы городов*/
        foreach($cities as $city=>$val)
        {
            $obj2 = new stdClass();

            $obj2->pagetitle=$city;
            $obj2->parent=$this->CityParent;
            $obj2->template=$this->CityTemplate;
            IncertPage($obj2);
        }
        echo "</pre>";
    }


    function LoadShipsPhoto()
    {

        $Ships=$this->GetShipsList();
        print_r($Ships);

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
                $obj->template=$this->ShipPhotoTemplate;
                $obj->TV['ph_t_full']=$Images['full'];
                $obj->TV['ph_t_thumbnail']=$Images['thumbnail'];

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

    function GetShipImg($ship_id)
    {
        global $modx;
        global $table_prefix;

        $sql="select * from ".$table_prefix."site_content where (parent=".$ship_id.")and(template=".$this->ShipPhotoTemplate.")";
        $obj = array();
        foreach ($modx->query($sql) as $row)
        {
            $obj[]=GetPageInfo($row['id']);
        }
        return $obj;
    }


    /*Получает список круизов для теплохода*/
    function GetShipCruisList($ship_id)
    {
        global $modx;
        global $table_prefix;

        $sql="select * from ".$table_prefix."site_content where (parent=".$ship_id.")and(template=".$this->CruisTemplate.")";
       // echo $sql;
        $obj = array();
        foreach ($modx->query($sql) as $row)
        {
            $tem=GetPageInfo($row['id']);
           // if((isset($tem->TV['kr_route_name']))and($tem->TV['kr_route_name']!=''))
                $obj[]=$tem;
        }
        return $obj;
    }

    /*Возвращает массив прайса курза*/
    function GetCruisPriceList($cruis_id)
    {
        global $modx;
        global $table_prefix;

        $sql="select * from ".$table_prefix."site_content where (parent=".$cruis_id.")and(template=".$this->PriceTemplate.")";
        // echo $sql;
        $obj = array();
        foreach ($modx->query($sql) as $row)
        {
            $tem=GetPageInfo($row['id']);
            $obj[]=$tem;
        }
        return $obj;
    }

    /*Вывод списка круизов для теплохода*/
    function tplShipCruisList($ship_id)
    {
        include "tpl/tplShipCruisList.php";
    }

    function tplSearchForm()
    {

        include "tpl/tplSearchForm.php";
    }


    function Search()
    {
        global $modx;
        global $table_prefix;
        include "tpl/tplSearchResult.php";
    }



    /*Шаблон формы бронирования*/
    function tplBron()
    {
        global $modx;
        global $table_prefix;
        include "tpl/tplBron.php";
    }


    /*список сают круизов*/
    function GetCautaList($cruis_id)
    {
        global $modx;
        global $table_prefix;

        $sql="select * from ".$table_prefix."site_content where (parent=".$cruis_id.")and(template=".$this->CautaTemplate.")";
        foreach ($modx->query($sql) as $row)
        {
            $tem=GetPageInfo($row['id']);
            // if((isset($tem->TV['kr_route_name']))and($tem->TV['kr_route_name']!=''))
            $obj[]=$tem;
        }
        return $obj;
    }

    /*Иформация о каюте в виде объекта*/
    function GetCautaInfo($cauta_id)
    {
        $obj = new stdClass();
        $cauta=GetPageInfo($cauta_id);
        $obj->nomer=$cauta->TV['k_name'];
        $obj->type=$cauta->TV['k_type'];
        $obj->deck=$cauta->TV['k_deck'];
        $obj->places=$cauta->TV['k_places'];
        $obj->deck=$cauta->TV['k_deck'];
        $obj->inner_id=$cauta->TV['k_inner_id'];
        $obj->id=$cauta->id;
        $cruis_id=$cauta->parent;
        $cruis_price_list=$this->GetCruisPriceList($cruis_id);
        foreach ($cruis_price_list as $price_id=>$price)
        {
            if($obj->type==$price->TV['cr_price_name'])
            {
                $obj->price=$price->TV['cr_price_price'];
                $obj->free_place=$price->TV['cr_price_places_free'];
            }
        }
        return $obj;
    }


    /*==========  ЗАЯВКИ ===============*/
    /*Добавить заказ от клиента в базц*/
    function z_add()
    {
        $obj = new stdClass();

        $today = date("Y-m-d H:i:s");
        echo $today;

        $obj->parent=$this->ZayavkaParent;
        $obj->template=$this->ZayavkaTemplate;

        $obj->TV['z_cauta_nomer']=$_GET['z_cauta_nomer'];
        $obj->TV['z_cruis_id']=$_GET['z_cruis_id'];
        $obj->TV['z_info']=$_GET['z_info'];
        $obj->TV['z_user_email']=$_GET['z_user_email'];
        $obj->TV['z_user_name']=$_GET['z_user_name'];
        $obj->TV['z_user_phone']=$_GET['z_user_phone'];
        $obj->TV['z_date']=$today;
        $obj->TV['z_status']='Новая';

        $cruis=GetPageInfo($obj->TV['z_cruis_id']);
        $ship=GetPageInfo($cruis->parent);
        $obj->TV['z_ship_id']=$ship->id;

        $obj->pagetitle="z_".rand(5, 60)."_".$obj->TV['z_user_name']."_".$obj->TV['z_ship_id']."_". $obj->TV['z_cruis_id']."_". $obj->TV['z_cauta_nomer'];
        //$obj->pagetitle=$ship;

        $obj->alias = encodestring($obj->pagetitle);
        $obj->url="zayavki/" .$obj->alias . ".html";


        IncertPage($obj);
    }


    /*===================================*/

    /*Главная функция для снипита*/
    function Run($scriptProperties)
    {
        if(isset($scriptProperties['action']))
        {
            if($scriptProperties['action']=='LoadShipsList') $this->LoadShipsList();
            if($scriptProperties['action']=='LoadShipsTours') $this->LoadShipsTours();
            if($scriptProperties['action']=='LoadShipsPhoto') $this->LoadShipsPhoto();
            if($scriptProperties['action']=='LoadCauts') $this->LoadCauts();

            if($scriptProperties['action']=='tplShipsList') $this->tplShipsList();
            if($scriptProperties['action']=='tplBron') $this->tplBron();

            if($scriptProperties['action']=='tplSearchForm') $this->tplSearchForm();
            if($scriptProperties['action']=='GetShipsCityList') echo $this->GetShipsCityList();
            if($scriptProperties['action']=='ajax') $this->Ajax();
        }
    }

    /*Ajax - вывод*/
    function Ajax()
    {
        if(isset($_GET['action']))
        {
            if ($_GET['action'] == 'GetShipsCityList')
            {
                echo $this->GetShipsCityList();
            }
            elseif ($_GET['action'] == 'Search')
            {
                $this->Search();
            }
            elseif ($_GET['action'] == 'z_add')
            {
                $this->z_add();
            }
        }

    }

}