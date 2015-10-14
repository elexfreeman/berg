<?php

?>
<div class="main-search">
    <div class="w-form">
        <form id="email-form" name="email-form" data-name="Email Form">
            <div class="w-row">
                <div class="w-col w-col-4">


                    <div class="drop-teplohod-text">ГОРОд ОТПРАВЛЕНИЯ</div>
                    <select  class="w-input drop-teplohod " id="city_start">
                        <option>-</option>
                        <?php
                        $citys=$this->GetShipsCityList();
                        foreach($citys as $city=> $t)
                        {
                            ?>
                            <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                            <?php
                        }
                        ?>
                    </select>



                    <div class="drop-teplohod-text">город посещения</div>
                    <select  class="w-input drop-teplohod " id="city">
                        <option>-</option>
                        <?php
                        $citys=$this->GetShipsCityList();
                        foreach($citys as $city=> $t)
                        {
                            ?>
                            <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                            <?php
                        }
                        ?>
                    </select>

                </div>


                <div class="w-col w-col-4">
                    <label class="search-label">Дата отправления:</label>

                    <div class="w-row">
                        <div class="w-col w-col-6 date-col">
                            <input class="w-input date-input date_picker" id="date_start"
                                                                   type="text" placeholder="с:"
                                                                   name="date_start" required="required"
                                                                   data-name="date_start"></div>
                        <div class="w-col w-col-6">
                            <input class="w-input date-input date_picker" id="date_stop"
                                                          type="text" placeholder="по:" name="date_stop"
                                                          required="required" data-name="date_stop"></div>
                    </div>
                    <div class="w-checkbox kruis-weekend"><input class="w-checkbox-input" id="node"
                                                                 type="checkbox"
                                                                 data-name="Круизы выходного дня"><label
                            class="w-form-label" for="node">Круизы выходного дня</label></div>
                </div>
                <div class="w-col w-col-4">
                    <div class="w-dropdown drop-select-teplohd" data-delay="0">
                        <div class="drop-teplohod-text">теплоход</div>
                        <select  class="w-input drop-teplohod " id="ship">
                            <option>-</option>
                            <?php
                            $ships=$this->GetShipsList();
                            foreach($ships as $ship)
                            {
                                ?>
                                <option value="<?php echo $ship->id; ?>"><?php echo $ship->title; ?></option>
                                <?php
                            }

                            ?>
                        </select>

                    </div>
                </div>
            </div>
            <div class="w-clearfix">
                <div class="button-search click" onclick="Search();">Поиск</div>
            </div>
        </form>
        <div class="w-form-done"><p>Thank you! Your submission has been received!</p></div>
        <div class="w-form-fail"><p>Oops! Something went wrong while submitting the form</p></div>
    </div>
</div>