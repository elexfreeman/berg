<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 15-Oct-15
 * Time: 3:04 AM
 */
//$having=" having ";
$search_date_text="Любая";
if ((isset($_GET['city_start']))and($_GET['city_start']!=''))
{
	$having.="AND(kr_cities_start_tv_value like '".mysql_escape_string($_GET['city_start'])."%')";
}

if ((isset($_GET['city']))and($_GET['city']!=''))
{
	$having.="AND(kr_city_tv_value like '%".mysql_escape_string($_GET['city'])."%')";
}


if ((isset($_GET['date_start']))and($_GET['date_start']!=''))
{
	$having.="AND(kr_date_start_tv_value >= '".mysql_escape_string($_GET['date_start'])."')";
}


if ((isset($_GET['date_stop']))and($_GET['date_stop']!=''))
{
	$having.="AND(kr_date_end_tv_value <= '".mysql_escape_string($_GET['date_stop'])."')";
}

if($having!='')
{
	$having = " having ".substr($having, 3);
}

$sql_ship="
-- ********************************
						select ship_id id from
						(
						select
						ships.id ship_id,
						ships.pagetitle ship_title,
						tv.name tv_name,
						cv.value tv_value


						from ".$table_prefix."site_content ships

						left join ".$table_prefix."site_tmplvar_contentvalues cv
						on ships.id=cv.contentid

						left join ".$table_prefix."site_tmplvars tv
						on tv.id=cv.tmplvarid


						where (ships.parent=2)and(tv.name='t_in_filtr')

						) ships_tbl
					-- ********************************
";

if ((isset($_GET['ship']))and($_GET['ship']!=''))
{
	$sql_ship=mysql_escape_string($_GET['ship']);
}

$sql="select * from
(
		select
			kr.id kr_cities_start_id,
			kr.pagetitle kr_cities_start_title,
			tv.name kr_cities_start_tv_name,
			cv.value kr_cities_start_tv_value


			from ".$table_prefix."site_content kr

			left join ".$table_prefix."site_tmplvar_contentvalues cv
			on kr.id=cv.contentid

			left join ".$table_prefix."site_tmplvars tv
			on tv.id=cv.tmplvarid

			where (kr.parent in
						(

					".$sql_ship."
					)
		)

		and(kr.template=".$this->CruisTemplate." )and(tv.name='kr_cities')
) 	cities_start

join
(
		select
			kr.id kr_city_id,
			kr.pagetitle kr_city_title,
			tv.name kr_city_tv_name,
			cv.value kr_city_tv_value


			from ".$table_prefix."site_content kr

			left join ".$table_prefix."site_tmplvar_contentvalues cv
			on kr.id=cv.contentid

			left join ".$table_prefix."site_tmplvars tv
			on tv.id=cv.tmplvarid

			where (kr.parent in
						(

				".$sql_ship."
					)
		)

		and(kr.template=".$this->CruisTemplate." )and(tv.name='kr_cities')
) 	cities
on cities_start.kr_cities_start_id=kr_city_id

join
(
		select
			kr.id kr_date_start_id,
			kr.pagetitle kr_date_start_title,
			tv.name kr_date_start_tv_name,
			STR_TO_DATE(cv.value, '%d.%m.%Y') kr_date_start_tv_value


			from ".$table_prefix."site_content kr

			left join ".$table_prefix."site_tmplvar_contentvalues cv
			on kr.id=cv.contentid

			left join ".$table_prefix."site_tmplvars tv
			on tv.id=cv.tmplvarid

			where (kr.parent in
						(

					".$sql_ship."
					)
		)

		and(kr.template=".$this->CruisTemplate." )and(tv.name='kr_date_start')
) 	date_start
on cities_start.kr_cities_start_id=kr_date_start_id


join
(
		select
			kr.id kr_date_end_id,
			kr.pagetitle kr_date_end_title,
			tv.name kr_date_end_tv_name,
			STR_TO_DATE(cv.value, '%d.%m.%Y') kr_date_end_tv_value


			from ".$table_prefix."site_content kr

			left join ".$table_prefix."site_tmplvar_contentvalues cv
			on kr.id=cv.contentid

			left join ".$table_prefix."site_tmplvars tv
			on tv.id=cv.tmplvarid

			where (kr.parent in
						(

				".$sql_ship."
					)
		)

		and(kr.template=".$this->CruisTemplate." )and(tv.name='kr_date_end')
) 	date_end
on cities_start.kr_cities_start_id=date_end.kr_date_end_id
".$having."
limit 100
";
//echo $sql;

?>
    <h2 class="search-h2">Речные круизы по Волге<br>
       <!-- <span class="search-h2-detals">Результаты поиска: дата - любая,&nbsp;город отправления - Самара,&nbsp;теплоход - любой,&nbsp;город посещения - любой,&nbsp;"круиз выходного дня" - не важно</span>-->
    </h2>
<?php
foreach ($modx->query($sql) as $row)
{
    $cruis=GetPageInfo($row['kr_cities_start_id']);
	$ship=GetPageInfo($cruis->parent);
	$prices=$this->GetCruisPriceList($cruis->id);

    ?>

    <div class="search-item">
        <div class="w-row">
            <div class="w-col w-col-4 search-item-col1">
                <a class="search-item-teplohod-info" href="#">Круиз на теплоходе<br>"<?php echo $ship->TV['t_title']; ?>"</a>
                <img class="search-item-img" width="213" src="<?php echo $ship->TV['t_title_img']; ?>">
            </div>
            <div class="w-col w-col-4 search-item-col2">
                <a class="search-item-race" href="#"><?php echo $cruis->TV['kr_cities']; ?></a>

                <div class="search-item-marshrut"></div>
                <div class="search-item-description">
                    <div><?php echo $cruis->TV['kr_date_start']; ?> - <?php echo $cruis->TV['kr_date_end']; ?></div>
                    <div><?php echo $cruis->TV['kr_days']; ?> дня / <?php echo $cruis->TV['kr_nights']; ?> ночи</div>
                    <a href="/bronirovanie.html?cruis_id=<?php echo $cruis->id; ?>">
					<div class="button-cruis-reserv">
                        <div>забронировать</div>
                    </div>
					</a>
                </div>
            </div>
            <div class="w-col w-col-4 search-item-col3">
				<?php
				foreach($prices as $price)
				{
					if((isset($price->TV['cr_price_places_free']))and($price->TV['cr_price_places_free']!=''))
					{
						?>
						<div class="search-item-col-3-row">
							<div class="w-row">
								<div class="w-col w-col-6">
									<div><?php echo $price->TV['cr_price_name']; ?></div>
								</div>
								<div class="w-col w-col-6">
									<div><?php echo $price->TV['cr_price_price']; ?> ( <?php echo $price->TV['cr_price_places_free']; ?> )</div>
								</div>
							</div>
						</div>
						<?php
					}

				}
				?>

                <div class="search-item-col-3-row link-info">
					<a class="search-item-a-info" href="#">Информация о круизе и бронировании</a>
				</div>
            </div>
        </div>
    </div>






	<?php

}