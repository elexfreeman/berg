<?php
$Ships=$this->GetShipsList();

/*?????????? ???? ??????*/
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
                        <script type="application/json" class="w-json">{
                                "items": [
                                    {
                                        "id": "5607962f2cdc27cd51edd5f1",
                                        "url": "https://daks2k3a4ib2z.cloudfront.net/55e8880c427f5d0f707c85f3/5607962f2cdc27cd51edd5f1_SeaLines2%20(small).jpg",
                                        "fileName": "5607962f2cdc27cd51edd5f1_SeaLines2 (small).jpg",
                                        "origFileName": "SeaLines2 (small).jpg",
                                        "width": 271,
                                        "height": 187,
                                        "size": 17889,
                                        "type": "image"
                                    },
                                    {
                                        "id": "55e898ae01a3cd432d0442d5",
                                        "url": "https://daks2k3a4ib2z.cloudfront.net/55e8880c427f5d0f707c85f3/55e898ae01a3cd432d0442d5_vk.jpg",
                                        "fileName": "example-bg.png",
                                        "origFileName": "example-bg.png",
                                        "width": 250,
                                        "height": 250,
                                        "size": 3618,
                                        "type": "image"
                                    }
                                ]
                            }</script>
                    </a></div>
                <div class="w-col w-col-9 w-clearfix">
                    <div class="ship-description">
                        <div class="ship-cruis">
                            <div class="ship-cruis-data">2016-07-15&nbsp;2016-07-17</div>
                            <div class="ship-cruis-caption"><strong>???????? ??????: </strong>??????????
                                ??????????? ? ???
                            </div>
                            <div class="ship-cruis-sity"><strong>???????:</strong>&nbsp;?????? (???) – ????? –
                                ?????? ???????? – ?????? (???)
                            </div>
                        </div>
                        <div class="ship-cruis">
                            <div class="ship-cruis-data">2016-07-15&nbsp;2016-07-17</div>
                            <div class="ship-cruis-caption"><strong>???????? ??????: </strong>??????????
                                ??????????? ? ???
                            </div>
                            <div class="ship-cruis-sity"><strong>???????:</strong>&nbsp;?????? (???) – ????? –
                                ?????? ???????? – ?????? (???)
                            </div>
                        </div>
                        <div class="ship-cruis">
                            <div class="ship-cruis-data">2016-07-15&nbsp;2016-07-17</div>
                            <div class="ship-cruis-caption"><strong>???????? ??????: </strong>??????????
                                ??????????? ? ???
                            </div>
                            <div class="ship-cruis-sity"><strong>???????:</strong>&nbsp;?????? (???) – ????? –
                                ?????? ???????? – ?????? (???)
                            </div>
                        </div>
                        <div class="ship-cruis">
                            <div class="ship-cruis-data">2016-07-15&nbsp;2016-07-17</div>
                            <div class="ship-cruis-caption"><strong>???????? ??????: </strong>??????????
                                ??????????? ? ???
                            </div>
                            <div class="ship-cruis-sity"><strong>???????:</strong>&nbsp;?????? (???) – ????? –
                                ?????? ???????? – ?????? (???)
                            </div>
                        </div>
                        <div class="ship-cruis">
                            <div class="ship-cruis-data">2016-07-15&nbsp;2016-07-17</div>
                            <div class="ship-cruis-caption"><strong>???????? ??????: </strong>??????????
                                ??????????? ? ???
                            </div>
                            <div class="ship-cruis-sity"><strong>???????:</strong>&nbsp;?????? (???) – ????? –
                                ?????? ???????? – ?????? (???)
                            </div>
                        </div>
                        <div class="ship-cruis">
                            <div class="ship-cruis-data">2016-07-15&nbsp;2016-07-17</div>
                            <div class="ship-cruis-caption"><strong>???????? ??????: </strong>??????????
                                ??????????? ? ???
                            </div>
                            <div class="ship-cruis-sity"><strong>???????:</strong>&nbsp;?????? (???) – ????? –
                                ?????? ???????? – ?????? (???)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}