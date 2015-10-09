<?php
$Ships=$this->GetShipsList();

/*Перебераем этот список*/
$i=10;
foreach($Ships as $key=>$Ship)
{
    if( $Ship->TV['t_title']!='')
    {
        ?>
        <div class="ship-item">
            <h3 class="ship-name"><?php echo $Ship->TV['t_title']; ?></h3>

            <div class="w-row ship-row">
                <div class="w-col w-col-3"><a class="w-lightbox w-inline-block ship-lightbox" href="#">
                        <img  src="<?php echo $Ship->TV['t_title_img']; ?>">
                        <?php
                        $ShipImg=$this->GetShipImg($Ship->id)   ;
                        $imgList=' ';
                        foreach($ShipImg as $img)
                        {
                            $imgList.='
                            {
                            "id": "'.$i.'",
                            "url": "'.$img->TV['ph_t_full'].'",
                            "fileName": "5607962f2cdc27cd51edd5f1_SeaLines2 (small).jpg",
                            "origFileName": "SeaLines2 (small).jpg",
                            "width": 271,
                            "height": 187,
                            "size": 17889,
                            "type": "image"
                            },';

                            $i++;
                        }
                        $imgList = substr($imgList, 0, -1);

                        ?>
                        <script type="application/json" class="w-json">{
                                "items": [ <?php echo $imgList;?>


                                ]
                            }</script>
                    </a></div>
                <div class="w-col w-col-9 w-clearfix">
                    <div class="ship-description">

                        <?php
                        $this->tplShipCruisList($Ship->id);
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}