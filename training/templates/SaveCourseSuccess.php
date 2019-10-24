<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>

<div class="formpage4col">
    <div class="navigation">

        <?php echo message() ?>
    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("New Training Define") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">

            <div class="leftCol">
                &nbsp;
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("English") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Sinhala") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Tamil") ?></label>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="transfertypecombo"><?php echo __("Institute Name") ?><span class="required">*</span> </label>
            </div>
            <div class="centerCol">
                <select name="instiName" id="instiName" class="formSelect" style="width: 150px;" tabindex="4">

                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($institutelist as $inslist) {
                    ?>
                        <option value="<?php echo $inslist->getTd_inst_id() ?>"><?php
                        $abc = "getTd_inst_name_" . $culture;
                        if ($inslist->$abc() == "")
                            echo $inslist->getTd_inst_name_en(); else
                            echo $inslist->$abc(); ?></option>
<?php } ?>

                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Calendar Year") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="TrainYear"  name="TrainYear" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH=4 />
            </div>
            <br class="clear"/>

            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Code") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="TrainCode"  name="TrainCode" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH=10/>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="TrainNameEn"  name="TrainNameEn" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH=100/>
            </div>

            <div class="centerCol">
                <input id="TrainNameSi"  name="TrainNameSi" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH=100/>

            </div>

            <div class="centerCol">
                <input id="TrainNameTa"  name="TrainNameTa" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH=100/>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Medium") ?> </label>
            </div>
            <div class="centerCol">
                <select name="medium" id="medium" class="formSelect" style="width: 150px;" tabindex="4">

                    <option value=""><?php echo __("--Select--") ?></option>
<?php foreach ($medium as $m) { ?>
                        <option value="<?php echo $m->getLang_code() ?>"><?php
                        if ($culture == "en") {
                            $abc = "getLang_name";
                        } else {
                            $abc = "getLang_name_" . $culture;
                        } if ($m->$abc() == "")
                            echo $m->getLang_name(); else
                            echo $m->$abc();
?></option>
<?php } ?>

                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Venue") ?> </label>
            </div>
            <div class="centerCol">
                <input id="venueEn"  name="venueEn" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH=200/>
            </div>
            <div class="centerCol">

                <input id="venueSi"  name="venueSi" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH=200/>
            </div>

            <div class="centerCol">
                <input id="venueTa"  name="venueTa" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH=200/>
            </div>


            <br class="clear"/>
            <div class="leftCol"> <label class="controlLabel" for="txtLocationCode"><?php echo __("Level") ?> <span class="required"> * </span></label></div>
            <div class="centerCol"><select name="cmbLevel" class="formSelect" style="width: 150px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
<?php foreach ($Level as $LevelDetail) {
?>
                    <option value="<?php echo $LevelDetail->getLevel_code() ?>" ><?php
                        if ($culture == 'en') {
                            $abcd = "getLevel_name";
                        } else {
                            $abcd = "getLevel_name_" . $culture;
                        }
                        if ($LevelDetail->$abcd() == "") {
                            echo $LevelDetail->getLevel_name();
                        } else {
                            echo $LevelDetail->$abcd();
                        }
?></option>
<?php } ?>
                </select></div>



            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Duration") ?></label>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Date from") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="fromdate" type="text" class="formInputText" name="fromdate">
                <div style="display: none;" class="demo-description"></div>
            </div>


            <div class="centerCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Date To") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="todate" type="text" class="formInputText" name="todate">
                <div style="display: none;" class="demo-description"></div>
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Time from") ?></label>
            </div>
            <div class="centerCol">
                <select name="timefromHR" id="timefrom" class="formSelect" style="width: 50px;" tabindex="4">

                    <option value=""><?php echo __("HH") ?></option>
                    <option value="00"><?php echo __("00") ?></option>
                    <option value="01"><?php echo __("01") ?></option>
                    <option value="02"><?php echo __("02") ?></option>
                    <option value="03"><?php echo __("03") ?></option>
                    <option value="04"><?php echo __("04") ?></option>
                    <option value="05"><?php echo __("05") ?></option>
                    <option value="06"><?php echo __("06") ?></option>
                    <option value="07"><?php echo __("07") ?></option>
                    <option value="08"><?php echo __("08") ?></option>
                    <option value="09"><?php echo __("09") ?></option>
                    <option value="10"><?php echo __("10") ?></option>
                    <option value="11"><?php echo __("11") ?></option>
                    <option value="12"><?php echo __("12") ?></option>
                    <option value="13"><?php echo __("13") ?></option>
                    <option value="14"><?php echo __("14") ?></option>
                    <option value="15"><?php echo __("15") ?></option>
                    <option value="16"><?php echo __("16") ?></option>
                    <option value="17"><?php echo __("17") ?></option>
                    <option value="18"><?php echo __("18") ?></option>
                    <option value="19"><?php echo __("19") ?></option>
                    <option value="20"><?php echo __("20") ?></option>
                    <option value="21"><?php echo __("21") ?></option>
                    <option value="22"><?php echo __("22") ?></option>
                    <option value="23"><?php echo __("23") ?></option>
                    <option value="24"><?php echo __("24") ?></option>


                </select>



                <select name="timefromMM" id="timeto" class="formSelect" style="width: 50px;" tabindex="4">

                    <option value=""><?php echo __("MM") ?></option>
                    <option value="00"><?php echo __("00") ?></option>
                    <option value="05"><?php echo __("05") ?></option>
                    <option value="10"><?php echo __("10") ?></option>
                    <option value="15"><?php echo __("15") ?></option>
                    <option value="20"><?php echo __("20") ?></option>
                    <option value="25"><?php echo __("25") ?></option>
                    <option value="30"><?php echo __("30") ?></option>
                    <option value="35"><?php echo __("35") ?></option>
                    <option value="40"><?php echo __("40") ?></option>
                    <option value="45"><?php echo __("45") ?></option>
                    <option value="50"><?php echo __("50") ?></option>
                    <option value="55"><?php echo __("55") ?></option>


                </select>
            </div>
            <div class="centerCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Time To") ?></label>
            </div>
            <div class="centerCol">
                <select name="timetoHR" id="timetohrs" class="formSelect" style="width: 50px;" tabindex="4">

                    <option value=""><?php echo __("HH") ?></option>
                    <option value="00"><?php echo __("00") ?></option>
                    <option value="01"><?php echo __("01") ?></option>
                    <option value="02"><?php echo __("02") ?></option>
                    <option value="03"><?php echo __("03") ?></option>
                    <option value="04"><?php echo __("04") ?></option>
                    <option value="05"><?php echo __("05") ?></option>
                    <option value="06"><?php echo __("06") ?></option>
                    <option value="07"><?php echo __("07") ?></option>
                    <option value="08"><?php echo __("08") ?></option>
                    <option value="09"><?php echo __("09") ?></option>
                    <option value="10"><?php echo __("10") ?></option>
                    <option value="11"><?php echo __("11") ?></option>
                    <option value="12"><?php echo __("12") ?></option>
                    <option value="13"><?php echo __("13") ?></option>
                    <option value="14"><?php echo __("14") ?></option>
                    <option value="15"><?php echo __("15") ?></option>
                    <option value="16"><?php echo __("16") ?></option>
                    <option value="17"><?php echo __("17") ?></option>
                    <option value="18"><?php echo __("18") ?></option>
                    <option value="19"><?php echo __("19") ?></option>
                    <option value="20"><?php echo __("20") ?></option>
                    <option value="21"><?php echo __("21") ?></option>
                    <option value="22"><?php echo __("22") ?></option>
                    <option value="23"><?php echo __("23") ?></option>
                    <option value="24"><?php echo __("24") ?></option>


                </select>



                <select name="timetoMM" id="timetoMM" class="formSelect" style="width: 50px;" tabindex="4">

                    <option value=""><?php echo __("MM") ?></option>
                    <option value="00"><?php echo __("00") ?></option>
                    <option value="05"><?php echo __("05") ?></option>
                    <option value="10"><?php echo __("10") ?></option>
                    <option value="15"><?php echo __("15") ?></option>
                    <option value="20"><?php echo __("20") ?></option>
                    <option value="25"><?php echo __("25") ?></option>
                    <option value="30"><?php echo __("30") ?></option>
                    <option value="35"><?php echo __("35") ?></option>
                    <option value="40"><?php echo __("40") ?></option>
                    <option value="45"><?php echo __("45") ?></option>
                    <option value="50"><?php echo __("50") ?></option>
                    <option value="55"><?php echo __("55") ?></option>


                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Resource Person") ?><span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="txtRSP" MAXLENGTH=200></textarea>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Objective") ?></label>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="ObjectiveEn" MAXLENGTH=200></textarea>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="ObjectiveSi" MAXLENGTH=200></textarea>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="ObjectiveTa" MAXLENGTH=200></textarea>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("For Whom") ?></label>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="ForwhomEn" MAXLENGTH=200></textarea>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="ForwhomSi" MAXLENGTH=200></textarea>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="ForwhomTa" MAXLENGTH=200></textarea>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Contents") ?></label>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="ContentEn" MAXLENGTH=200></textarea>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="ContentSi" MAXLENGTH=200></textarea>
            </div>
            <div class="centerCol">
                <textarea class="formTextArea"  name="ContentTa" MAXLENGTH=200></textarea>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Course fee If Applicable") ?></label>
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Per Head Cost") ?></label>
            </div>
            <div class="centerCol">
                <input id="feesPerHeadCost"  name="feesPerHeadCost" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH='20'/>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Additional Cost") ?></label>
            </div>
            <div class="centerCol">
                <input id="textAdditionalCost"  name="textAdditionalCost" type="text"  class="formInputText" value="" tabindex="1" MAXLENGTH='20'/>
            </div>
            <br class="clear"/>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtcomment"><?php echo __("Please Select") ?><span class="required">*</span></label>
            </div>
            <br class="clear"/>
            <div class="leftCol" style="width: 50px">
                <input style="margin-top: 10px; width: 50px;" type="radio" id="routeflow" name="routeflow" value="1" >
            </div> 
            <div class="centerCol" style="width: 700px">
                <label style="margin-top: 10px; width: 700px;" class="controlLabel" for="txtcomment"><?php echo __("Immediate Supervisor -> Supervisor -> Assistant Secretary") ?></label>
            </div>     
            <br class="clear"/>
            <div class="leftCol" style="width: 50px">
                <input style="margin-top: 10px; width: 50px;" type="radio" id="routeflow" name="routeflow" value="1" >
            </div> 
            <div class="centerCol" style="width: 700px">
                <label style="margin-top: 10px; width: 700px;" class="controlLabel" for="txtcomment"><?php echo __("Immediate Supervisor -> Supervisor -> Assistant Secretary -> Additional Secretary") ?></label>
            </div>     
            <br class="clear"/>
            <div class="leftCol" style="width: 50px">
                <input style="margin-top: 10px; width: 50px;" type="radio" id="routeflow" name="routeflow" value="1" >
            </div> 
            <div class="centerCol" style="width: 700px">
                <label style="margin-top: 10px; width: 700px;" class="controlLabel" for="txtcomment"><?php echo __("Immediate Supervisor -> Supervisor -> Assistant Secretary -> Senior Assistant Secretary -> Additional Secretary") ?></label>
            </div>     
            <br class="clear"/>
            <div class="leftCol" style="width: 50px">
                <input style="margin-top: 10px; width: 50px;" type="radio" id="routeflow" name="routeflow" value="1" >
            </div> 
            <div class="centerCol" style="width: 700px">
                <label style="margin-top: 10px; width: 700px;" class="controlLabel" for="txtcomment"><?php echo __("Immediate Supervisor -> Supervisor -> Assistant Secretary -> Senior Assistant Secretary -> Additional Secretary -> Secretary") ?></label>
            </div>     
            <br class="clear"/>

            <br class="clear"/>

            <div class="formbuttons">
                <input type="button" class="savebutton" id="editBtn"

                       value="<?php echo __("Save") ?>" tabindex="8" />
                <input type="button" class="clearbutton"  id="resetBtn"
                       value="<?php echo __("Reset") ?>" tabindex="9" />
                <input type="button" class="backbutton" id="btnBack"
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>

        </form>

    </div>

</div>
<div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<?php
                    require_once '../../lib/common/LocaleUtil.php';
                    $sysConf = OrangeConfig::getInstance()->getSysConf();
                    $sysConf = new sysConf();
                    $inputDate = $sysConf->dateInputHint;
                    $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>

                    <script type="text/javascript">

                        function validateTraniningCode(){
                            var isTrainCodeDup;
                            $.ajax({
                                type: "POST",
                                async:false,
                                url: "<?php echo url_for('training/ValidateTrainingCode') ?>",
                                data: { cId : $("#TrainCode").val() },
                                dataType: "json",
                                success: function(data){

                                    if(data=="ok"){
                                        isTrainCodeDup=1;
                                    }else{
                                        isTrainCodeDup=0;
                                    }
                                }
                            });
                            return isTrainCodeDup;


                        }

                        $(document).ready(function() {

                            buttonSecurityCommon(null,"editBtn",null,null);
                            $("#fromdate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
                            $("#todate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });
                            jQuery.validator.addMethod("orange_date",
                            function(value, element, params) {


                                var format = params[0];

                                // date is not required
                                if (value == '') {

                                    return true;
                                }
                                var d = strToDate(value, "<?php echo $format ?>");


                                return (d != false);

                            }, ""
                        );

                            jQuery.validator.addMethod("dateValidation",
                            function(value, ment) {
                                var hint = '<?php echo $dateHint; ?>';
                                var format = '<?php echo $format; ?>';
                                var fromdate = strToDate($('#fromdate').val(), format)
                                var todate = strToDate($('#todate').val(), format);

                                if (fromdate && todate && (fromdate > todate)) {
                                    return false;
                                }
                                return true;
                            }, ""
                        );

                            jQuery.validator.addMethod("yearValidation",
                            function(value, ment) {
                                var hint = '<?php echo $dateHint; ?>';
                                var format = '<?php echo $format; ?>';
                                var trainYear = $('#fromdate').val();
                                var trainCalandarYear=$('#TrainYear').val();

                                var userYear;

                                var mySplitResult = trainYear.split("-");

                                for (i = 0; i < mySplitResult.length; i++) {
                                    if(mySplitResult[i].length==4){
                                        userYear=mySplitResult[i];
                                    }
                                }



                                if (trainYear  && (trainCalandarYear == userYear)) {
                                    return true;
                                }
                                return false;
                            }, ""
                        );

                            //Validate the form
                            $("#frmSave").validate({

                                rules: {
                                    feesPerHeadCost: { number: true, maxlength:20 ,noSpecialCharsOnly:true },
                                    textAdditionalCost: { number: true, maxlength:20 ,noSpecialCharsOnly:true },
                                    TrainYear: { required: true,digits: true,maxlength:4,minlength:4},
                                    cmbLevel: { required: true},
                                    TrainCode: { required: true,maxlength:10,noSpecialCharsOnly:true },
                                    TrainNameEn: { required: true,maxlength:100,noSpecialCharsOnly:true },
                                    TrainNameSi: { maxlength:100,noSpecialCharsOnly:true },
                                    TrainNameTa: { maxlength:100,noSpecialCharsOnly:true },
                                    txtRSP:{maxlength:100,noSpecialCharsOnly:true,required: true},
                                    ObjectiveEn:{maxlength:200,noSpecialCharsOnly:true },
                                    ObjectiveSi:{maxlength:200,noSpecialCharsOnly:true },
                                    ObjectiveTa:{maxlength:200,noSpecialCharsOnly:true },
                                    venueEn:{ maxlength:200,noSpecialCharsOnly:true },
                                    venueSi:{ maxlength:200,noSpecialCharsOnly:true },
                                    venueTa:{ maxlength:200,noSpecialCharsOnly:true },
                                    ForwhomEn:{maxlength:200,noSpecialCharsOnly:true },
                                    ForwhomSi:{maxlength:200,noSpecialCharsOnly:true },
                                    ForwhomTa:{maxlength:200,noSpecialCharsOnly:true },
                                    ContentEn:{maxlength:200,noSpecialCharsOnly:true },
                                    ContentSi:{maxlength:200,noSpecialCharsOnly:true },
                                    ContentTa:{maxlength:200,noSpecialCharsOnly:true },
                                    fromdate:{required:200,orange_date:true,dateValidation:true,yearValidation:true},
                                    todate:{required:200,orange_date:true,dateValidation:true},
                                    instiName:{required:true},
                                    fees:{number: true,maxlength:20,noSpecialCharsOnly:true },
                                    routeflow:{required: true}


                                },
                                messages: {
                                    cmbLevel: "<?php echo __("This Field is required") ?>",
                                    TrainYear: "<?php echo __("This Field is required") ?>",
                                    TrainCode: {required: "<?php echo __("This Field is required") ?>",maxlength: "<?php echo __("Maximum length should be 10 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    TrainNameEn: {required: "<?php echo __("This Field is required") ?>",maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    TrainNameSi: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    TrainNameTa: {maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    fromdate: {required:"<?php echo __("This Field is required") ?>",orange_date:"<?php echo __("Please specify valid  date"); ?>",yearValidation:"<?php echo __("Date is not in the Training Year") ?>"},
                                    todate: {required:"<?php echo __("This Field is required") ?>",orange_date:"<?php echo __("Please specify valid  date"); ?>",dateValidation: "<?php echo __("Please specify valid  date") ?>"},
                                    instiName: "<?php echo __("This Field is required") ?>",
                                    txtRSP:{ maxlength: "<?php echo __("Maximum length should be 100 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>",required:"<?php echo __("This Field is required") ?>"},
                                    ObjectiveEn:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    ObjectiveSi:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    ObjectiveTa:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    venueEn:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    venueSi:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>" },
                                    venueTa:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    ForwhomEn:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    ForwhomSi:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    ForwhomTa:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    ContentEn:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    ContentSi:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    ContentTa:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    fees:{number:"<?php echo __("Invalid fees") ?>",maxlength: "<?php echo __("Maximum length should be 20 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    feesPerHeadCost: {number:"<?php echo __("Invalid fees") ?>",maxlength: "<?php echo __("Maximum length should be 20 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    textAdditionalCost: {number:"<?php echo __("Invalid fees") ?>",maxlength: "<?php echo __("Maximum length should be 20 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    routeflow: {required:"<?php echo __("This Field is required") ?>"}
                                
                                    },errorClass: "errortd",
                                submitHandler: function(form) {
                                    $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                                    form.submit();
                                }
                            });


                            var mode	=	'edit';



                            $("#editBtn").click(function() {


                                var timeFromHrstoSec=$('#timefrom').val()*3600;


                                var timeToHrstoSec=$('#timetohrs').val()*3600;

                                var timeFromMM=$('#timeto').val()*60;

                                var timeToMM=$('#timetoMM').val()*60;

                                var totalTimetoSec=timeToHrstoSec+timeToMM;

                                var totalTimeFromSec=timeFromHrstoSec+timeFromMM;

                                if(totalTimetoSec==0 && totalTimeFromSec==0){
                                    if($('#timefrom').val()=="00" || $('#timetohrs').val()=="00" || $('#timeto').val()=="00" || $('#timetoMM').val()=="00"){
                                        alert("<?php echo __('Invalid Time') ?>");
                                    }else{
                                        if(validateTraniningCode()==1){
                                            $('#frmSave').submit();
                                        }else{
                                            alert("<?php echo __("Training code can not be duplicated"); ?>");
                                        }
                                    }
                                }else{

                                    if($('#timefrom').val()=="" ||  $('#timeto').val()=="" ){

                                        alert("<?php echo __('Invalid Time') ?>");
                                    }else{

                                        if(totalTimetoSec<=totalTimeFromSec){

                                            alert("<?php echo __('Invalid Time') ?>");

                                        }
                                        else{

                                            if($('#timetohrs').val()=="" || $('#timetoMM').val()==""){
                                                alert("<?php echo __('Invalid Time') ?>");
                                            }else{
                                                if(validateTraniningCode()==1){
                                                    $('#frmSave').submit();
                                                }else{
                                                    alert("<?php echo __('Training code can not be duplicated') ?>");
                                                }





                                            }
                                        }

                                    }


                                }



                                //}
                            });

                            //When click reset buton
                            $("#resetBtn").click(function() {
                                document.forms[0].reset('');
                            });

                            //When Click back button
                            $("#btnBack").click(function() {
                                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/CourseList')) ?>";
        });


    });
</script>
