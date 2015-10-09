<?php
/**
 * Created by PhpStorm.
 * User: elex
 * Date: 10/9/2015
 * Time: 12:49 AM
 * Список круизов для теплохода
 */

$CruisList=$this->GetShipCruisList($ship_id);
foreach($CruisList as $id=>$Cruis)
{
    ?>
    <div class="ship-cruis">
        <div class="ship-cruis-data"><?php echo $Cruis->TV['kr_date_start']; ?> - <?php echo $Cruis->TV['kr_date_end']; ?></div>
        <div class="ship-cruis-caption"><strong>Название круиза: </strong><?php echo $Cruis->TV['kr_route_name']; ?></div>
        <div class="ship-cruis-sity"><strong>Маршрут:</strong> <?php echo $Cruis->TV['kr_cities']; ?></div>
    </div>
    <?php
}

