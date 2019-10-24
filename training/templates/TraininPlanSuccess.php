<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
$encrypt = new EncryptionHandler();
?>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">
    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Training Plan") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <?php echo message() ?>
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
             <input type="hidden" name="txttrnplnid" id="txttrnplnid" value="<?php echo $trainingPlan->td_plan_id; ?>"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Month") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbMonth" id="cmbMonth" class="formSelect" style="width: 150px;" tabindex="4" onchange="">

                    <option value=""><?php echo __("--Select--") ?></option>
                    <option value="January"><?php echo __("January") ?></option>
                    <option value="February"><?php echo __("February") ?></option>
                    <option value="March"><?php echo __("March") ?></option>
                    <option value="April"><?php echo __("April") ?></option>
                    <option value="May"><?php echo __("May") ?></option>
                    <option value="June"><?php echo __("June") ?></option>
                    <option value="July"><?php echo __("July") ?></option>
                    <option value="August"><?php echo __("August") ?></option>
                    <option value="September"><?php echo __("September") ?></option>
                    <option value="October"><?php echo __("October") ?></option>
                    <option value="November"><?php echo __("November") ?></option>
                    <option value="December"><?php echo __("December") ?></option>

                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Year") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol" id="course">
                <select name="cmbYear" id="cmbYear" class="formSelect" style="width: 150px;" tabindex="4">

                    <option value=""><?php echo __("--Select--") ?></option>
                    <option value="2009"><?php echo __("2009") ?></option>
                    <option value="2010"><?php echo __("2010") ?></option>
                    <option value="2011"><?php echo __("2011") ?></option>
                    <option value="2012"><?php echo __("2012") ?></option>
                    <option value="2013"><?php echo __("2013") ?></option>
                    <option value="2014"><?php echo __("2014") ?></option>
                    <option value="2015"><?php echo __("2015") ?></option>
                    <option value="2016"><?php echo __("2016") ?></option>

                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol" id="course">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Institute Name") ?> <span class="required">*</span></label>


            </div>

            <div class="centerCol">

                <select name="instName" id="instName" class="formSelect" onchange="getCo(this.value);"  <?php echo $disabled ?>>


                    <option value="" ><?php echo __("--Select--") ?></option>
                    <?php foreach ($instList as $list) {
                    ?>
                        <option value="<?php echo $list->getTd_inst_id() ?>" <?php if ($list->td_inst_id == $trainingPlan->td_inst_id

                            )echo "selected=\"selected\""; ?>><?php
                            $abc = "getTd_inst_name_" . $culture;
                            if ($list->$abc() == "")
                                echo $list->getTd_inst_name_en(); else
                                echo $list->$abc(); ?></option>

                    <?php } ?>

                    </select>
                </div>

            <br class="clear"/>
            <div class="leftCol"> <label class="controlLabel" for="txtLocationCode"><?php echo __("Level") ?> <span class="required"> * </span></label></div>
            <div class="centerCol"><select name="cmbLevel" class="formSelect" style="width: 150px;" tabindex="4">
                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($Level as $LevelDetail) {
                    ?>
                        <option value="<?php echo $LevelDetail->getLevel_code() ?>" <?php if ($trainingPlan) {
                            if ($LevelDetail->getLevel_code() == $trainingPlan->getLevel_code()) {
                                echo "selected=selected";
                            }
                        } ?> ><?php
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
                <label class="controlLabel" for="txtTrainingName"><?php echo __("Training Name") ?><span class="required">*</span> </label>
            </div>
                <div class="centerCol" id="courselist">

                    <select name="txtTrainingName" id="txtTrainingName" class="formSelect"  <?php echo $disabled ?>>

                        <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($currentCourses as $clist) {
                    ?>

                            <option value="<?php echo $clist->getTd_course_id() ?>" <?php if ($clist->getTd_course_id() == $trainingPlan->td_course_id)
                                echo "selected=\"selected\"" ?>><?php
                                $abc = "getTd_course_name_" . $culture;
                                if ($clist->$abc() == "")
                                    echo $clist->getTd_course_name_en(); else
                                    echo $clist->$abc();
                                    $TDYear=$clist->getTd_course_year();
                    ?></option>
                    <?php } ?>

                        </select>

                    </div>
                    <br class="clear"/>            
<!--            <div class="centerCol" id="course">
                <input id="txtTrainingName"  name="txtTrainingName" type="text"  class="formInputText" value="<?php //echo $trainingPlan->td_plan_training_name; ?>" tabindex="1" maxlength="100" />
            </div>
            <div class="centerCol" id="course">
                <input id="txtTrainingNameSi"  name="txtTrainingNameSi" type="text"  class="formInputText" value="<?php //echo $trainingPlan->td_plan_training_name_si; ?>" tabindex="1" maxlength="100" />
            </div>
            <div class="centerCol" id="course">
                <input id="txtTrainingNameTa"  name="txtTrainingNameTa" type="text"  class="formInputText" value="<?php //echo $trainingPlan->td_plan_training_name_ta; ?>" tabindex="1" maxlength="100" />
            </div>
            <br class="clear"/>
-->

            <div class="leftCol">
                <label class="controlLabel" for="txtTrainingSummary"><?php echo __("Training Summary") ?> </label>
            </div>
            <div class="centerCol" id="course">
                <textarea class="formTextArea"  id="txtTrainingSummary" name="txtTrainingSummary"  style="height:80px; width: 450px;"><?php echo $trainingPlan->td_plan_training_summery; ?></textarea>
            </div>
            <br class="clear"/>
            <div class="leftCol" id="course">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Resource Person") ?> </label>


            </div>
            <div class="centerCol" id="course">
                <input id="txtResoucePerson"  name="txtResoucePerson" type="text"  class="formInputText" value="<?php echo $trainingPlan->td_plan_resource_person; ?>" tabindex="1" maxlength="200" />
            </div>


            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtForWhom"><?php echo __("For Whom") ?> </label>
            </div>
            <div class="centerCol" id="course">
                <textarea class="formTextArea"  id="txtForWhom" name="txtForWhom"  style="height:80px; width: 450px;"><?php echo $trainingPlan->td_plan_training_frowhom; ?></textarea>
            </div>
            <br class="clear"/>

            <br class="clear"/>

            <div class="formbuttons">
                <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                       value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                       onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                       value="<?php echo __("Reset"); ?>" />
                 <input type="button" class="backbutton" id="btnBack"
               value="<?php echo __("Back") ?>" tabindex="10" />
            </div>
        </form>
    </div>

</div>


<script type="text/javascript">
    var Month="<?php echo $trainingPlan->td_plan_month; ?>";
    var Year="<?php echo $trainingPlan->td_plan_year; ?>";


                     function getCo(cid){
                         
                         
                         var instiname=$('#instName').val();

                         $.post(

                         "<?php echo url_for('training/ajaxloadcourse') ?>", //Ajax file

                         { cid: cid },  // create an object will all values

                         //function that is called when server returns a value.
                         function(data){



                             var selectbox="<select name='txtTrainingName' id='txtTrainingName' class='formSelect'  >";
                             selectbox=selectbox +"<option value=''><?php echo __('--Select--') ?></option>";
                             $.each(data, function(key, value) {

                                 selectbox=selectbox +"<option value="+key+">"+value+"</option>";
                             });
                             selectbox=selectbox +"</select>";

                             $('#courselist').html('');
                             $('#courselist').html(selectbox);
                         },

                         //How you want the data formated when it is returned from the server.
                         "json"

                     );

                     }
    $(document).ready(function() {

        $('#cmbMonth').val(Month);
        $('#cmbYear').val(Year);
        // When click edit button
<?php if ($editMode == true) { ?>
                    $("#editBtn").show();
                    buttonSecurityCommon(null,null,"editBtn",null);
                    $('#frmSave :input').attr('disabled', true);
                    $('#editBtn').removeAttr('disabled');
<?php } else { ?>
                              $("#editBtn").show();
                              buttonSecurityCommon(null,"editBtn",null,null);
<?php } ?>
                            $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                            $("#editBtn").click(function() {

                                var editMode = $("#frmSave").data('edit');
         
                                if (editMode == 1) {
                                    // Set lock = 1 when requesting a table lock

                                    location.href="<?php echo url_for('training/TraininPlan?id=' . $encrypt->encrypt($trainingPlan->td_plan_id) . '&lock=' . $encrypt->encrypt(1)) ?>";
                                }
                                else {

                                    $('#frmSave').submit();
                                }


                            });

                            //Validate the form
                            $("#frmSave").validate({

                                rules: {
                                    cmbMonth: { required: true },
                                    cmbYear: { required: true},
                                    cmbLevel: { required: true},
                                    instName: {required: true},
                                    txtTrainingName: {required: true},
                                                    txtTrainingSummary:{maxlength:200,noSpecialCharsOnly:true},
                                    txtForWhom:{maxlength:200,noSpecialCharsOnly:true},
                                    txtResoucePerson:{maxlength:200,noSpecialCharsOnly:true}

                                },
                                messages: {
                                    cmbMonth: "<?php echo __('This field is required') ?>",
                                    cmbYear: "<?php echo __('This field is required') ?>",
                                    cmbLevel: "<?php echo __('This field is required') ?>",
                                    instName: {required:"<?php echo __("This field is required") ?>"},
                                    txtTrainingName: {required: "<?php echo __('This field is required') ?>"},
                                    txtTrainingSummary:{maxlength:"<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    txtForWhom:{maxlength:"<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                    txtResoucePerson:{maxlength:"<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"}



                                },
                                submitHandler: function(form) {
                                    $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                                    form.submit();
                                }
                            });

                            //When click reset buton
                            $("#btnClear").click(function() {
                                var tid="<?php echo $trainingPlan->td_plan_id ?>";
                                if ( tid.length>0) {
                                    location.href="<?php echo url_for('training/TraininPlan?id=' . $encrypt->encrypt($trainingPlan->td_plan_id) . '&lock=' . $encrypt->encrypt(0)) ?>";
                                }
                                else{
                                    document.forms[0].reset('');
                                }
                
           
                            });

                            //When Click back button
                            $("#btnBack").click(function() {
                                location.href="<?php echo url_for('training/TrainingPlanList') ?>";
                            });




                        });
</script>
