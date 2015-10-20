<?php
$cruis=GetPageInfo(mysql_escape_string($_GET['cruis_id']));
$ship=GetPageInfo($cruis->parent);
//$prices=$this->GetCruisPriceList($cruis->id);
$cauta_list=$this->GetCautaList($cruis->id);



/*
Request URL:http://www.riverlines.ru/remote/js/order.js?
host=berg-cruis-develop.about-seo.info
&id=281880&name=elelxdsdd
&phone=2322323&email=elext@gm.com
&info=wewe&cabins[9724][9724-1][name]=
&cabins[9724][9724-1][number]=
&cabins[9724][9724-1][birthday]=
&cabins[9724][9724-2][name]=
&cabins[9724][9724-2][number]=
&cabins[9724][9724-2][birthday]=
&_=0.05300467601045966

Query:
host:berg-cruis-develop.about-seo.info
id:281880
name:test33
phone:333333
email:elextraza@gmail.com
info:text
cabins[9724][9724-1][name]:
cabins[9724][9724-1][number]:
cabins[9724][9724-1][birthday]:
cabins[9724][9724-2][name]:
cabins[9724][9724-2][number]:
cabins[9724][9724-2][birthday]:
_:0.23654545610770583


 * */


?>
<script>
    function bron()
    {

        var cauta_inner_id=$('input[name=cauta_inner_id]:radio:checked').val();
        var name=$("#name").val();
        var Phone=$("#Phone").val();
        var Email=$("#Email").val();
        var cruis_id=$("#cruis_id").val();
        var cruis_inner_id=$("#cruis_id").val();
        var info=$("#info").val();
        var url="http://www.riverlines.ru/remote/js/order.js?";
        url=url+"id="+cruis_inner_id;
        url=url+"&info="+info;
        url=url+"&host=berg-cruis-develop.about-seo.info";
        url=url+"&name="+name;
        url=url+"&phone="+Phone;
        url=url+"&email="+Email;
        //url=url+"";


        url=url+'&cabins['+cauta_inner_id+"]["+cauta_inner_id+"-1][number]=";
        url=url+"&cabins["+cauta_inner_id+"]["+cauta_inner_id+"-1][birthday]=";
        url=url+"&cabins["+cauta_inner_id+"]["+cauta_inner_id+"-2][name]=";
        url=url+"&cabins["+cauta_inner_id+"]["+cauta_inner_id+"-2][number]=";
        url=url+"&cabins["+cauta_inner_id+"]["+cauta_inner_id+"-2][birthday]=";
        url=url+"&_=0.05300467601045966";



        setTimeout(function() {

            $.get(
                'ajax.html',
                {
                    action:"z_add",
                    z_cauta_nomer:cauta_inner_id,
                    z_cruis_id:cruis_id,
                    z_info:info,
                    z_user_email:Email,
                    z_user_name:name,
                    z_user_phone:Phone


                    //log1:1,
                    /* host: "berg-cruis-develop.about-seo.info",
                     id: cruis_id,
                     info: "sss",
                     'cabins['+cauta_inner_id+"]["+cauta_inner_id+"-1][number]": "",
                     "cabins["+cauta_inner_id+"]["+cauta_inner_id+"-1][birthday]": "",
                     "cabins["+cauta_inner_id+"]["+cauta_inner_id+"-2][name]": "",
                     "cabins["+cauta_inner_id+"]["+cauta_inner_id+"-2][number]": "",
                     "cabins["+cauta_inner_id+"]["+cauta_inner_id+"-2][birthday]": "",
                     "_":"0.05300467601045966"*/

                },
                function (data) {
                    console.info(data);


                }, "html"
            ); //$.get  END

        }, 500);

        setTimeout(function() {

            $.get(
                url,
                {
                    //log1:1,
                    /* host: "berg-cruis-develop.about-seo.info",
                     id: cruis_id,
                     info: "sss",
                     'cabins['+cauta_inner_id+"]["+cauta_inner_id+"-1][number]": "",
                     "cabins["+cauta_inner_id+"]["+cauta_inner_id+"-1][birthday]": "",
                     "cabins["+cauta_inner_id+"]["+cauta_inner_id+"-2][name]": "",
                     "cabins["+cauta_inner_id+"]["+cauta_inner_id+"-2][number]": "",
                     "cabins["+cauta_inner_id+"]["+cauta_inner_id+"-2][birthday]": "",
                     "_":"0.05300467601045966"*/

                },
                function (data) {
                    console.info(data);


                }, "html"
            ); //$.get  END

        }, 1000);
        setTimeout(function() {  $(".bron").html('<h3 class="form-h3">Спасибо. Вам перезвонят</h3>');},300);



    }
</script>
<div class="w-container bron">
    <h3 class="form-h3">Круиз: <?php echo $cruis->title; ?></h3>
    <h3 class="form-h3">Выберите каюту</h3>

    <div class="kuta-select-box">
        <div class="w-row cauta-select-row">
            <div class="w-col w-col-2"></div>
            <div class="w-col w-col-2">
                <div class="select-cuta-heaad">Каюта</div>
            </div>
            <div class="w-col w-col-2">
                <div class="select-cuta-heaad">Категория</div>
            </div>
            <div class="w-col w-col-2">
                <div class="select-cuta-heaad">Палуба</div>
            </div>
            <div class="w-col w-col-2">
                <div class="select-cuta-heaad">Цена основного места</div>
            </div>
            <div class="w-col w-col-2">
                <div class="select-cuta-heaad">Количество мест</div>
            </div>
        </div>

        <?php
        foreach($cauta_list as $cauta)
        {
          //  if ((isset($price->TV['cr_price_places_free'])) and ($price->TV['cr_price_places_free'] != ''))
            {

                //echo "<pre>";
                //$cauta=$this->GetCautaInfo($cauta->id);
                //echo "</pre>";

                /*
                 *
                [nomer] => 131
                [type] => 2Г уд
                [deck] => Нижняя палуба
                [places] => ID:1896600000000000001-NAME:1-TYPE:0-POSITION:0-STATUS:0||ID:1896600000000000002-NAME:2-TYPE:0-POSITION:0-STATUS:0||
                [price] => 10200
                [free_place] => 2
                 */
                $cauta=$this->GetCautaInfo($cauta->id);
        ?>

                <div class="w-row cauta-select-row">

                    <div class="w-col w-col-2">
                        <!--
                       <div class="w-radio">
                           <label class="w-form-label" for="radio">Radio</label>
                           <input class="w-radio-input" id="radio" type="radio" name="radio" value="Radio"
                                  data-name="Radio">
                       </div> -->
                    </div>

                    <div class="w-col w-col-2">
                        <div class="w-radio">
                            <label class="w-form-label" for="radio"><?php echo $cauta->nomer; ?></label>
                            <input class="w-radio-input" id="radio_cauta_inner_id" type="radio" name="cauta_inner_id" value="<?php echo $cauta->inner_id; ?>"
                                   data-name="Radio">
                        </div>

                <!--    <div class="select-cauta-text"><?php echo $cauta->nomer; ?></div> -->
                    </div>
                    <div class="w-col w-col-2">
                        <div class="select-cauta-text"><?php echo $cauta->type; ?></div>
                    </div>
                    <div class="w-col w-col-2">
                        <div class="select-cauta-text"><?php echo $cauta->deck; ?></div>
                    </div>
                    <div class="w-col w-col-2">
                        <div class="select-cauta-text"><?php echo $cauta->price; ?></div>
                    </div>
                    <div class="w-col w-col-2">
                        <div class="select-cauta-text"><?php echo $cauta->free_place; ?></div>
                    </div>
                </div>
        <?php
            }
        }
        ?>

    </div>

    <div class="form-bron-div">
        <h3 class="form-h3">Бронирование</h3>

        <div>На нашем сайте Вы можете воспользоваться предварительной системой бронирования круизов.<br>
            Бронирование
            круизов производится бесплатно.<br>
            Срок оплаты забронированного тура составляет в среднем 3-5 дней после
            подтверждения заявки и зависит от выбранного Вами круиза.
        </div>
        <div class="w-form form-bron">

            <input type="hidden" id="cauta_inner_id" name="cauta_inner_id" value="<?php echo $cauta->inner_id; ?>">
            <input type="hidden" id="cruis_inner_id" name="cruis_id" value="<?php echo $cruis->TV['kr_inner_id']; ?>">
            <input type="hidden" id="cruis_id" name="cruis_id" value="<?php echo $cruis->id; ?>">
                <label for="name">Ваше
                    имя:</label>
                <input class="w-input" id="name" type="text" placeholder="Антон Помидоров"
                                       name="name" data-name="Name" autofocus="autofocus" required="required">

                <label for="Phone">Контактный телефон:</label>
                <input class="w-input" id="Phone" type="email"
                                                                  placeholder="+7-936-125-25-12" name="Phone"
                                                                  data-name="Phone" required="required">

                <label for="Email-3">Ваша электронная почта:</label>
                <input class="w-input" id="Email" type="email"
                                                                        placeholder="anton@mail.ru" name="Email"
                                                                        data-name="Email" required="required">

                <label for="email-2">Выбранная каюта: <span class="select-cauta">45</span></label>

                <label for="info">Дополнительная  информация:</label>
                <textarea class="w-input" id="info" name="info" data-name="info"></textarea>


                <input class="w-button button-z" type="button" value="Оформить заявку" onclick="bron();">

            <div class="w-form-done"><p>Thank you! Your submission has been received!</p></div>
            <div class="w-form-fail"><p>Oops! Something went wrong while submitting the form</p></div>
        </div>
    </div>
</div>