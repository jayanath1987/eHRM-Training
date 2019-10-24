<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery-ui.min.js') ?>"></script>
<link href="<?php echo public_path('../../themes/orange/css/jquery/jquery-ui.css') ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<link href="../../themes/orange/css/style.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?php echo public_path('../../scripts/time.js') ?>"></script>
<style type="text/css">
    .controlLabel{
        width: 130px;
    }
</style>   
<div class="formpage2col">
    <div class="navigation">
   </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Update Training Record") ?></h2></div>
<?php
echo message();
?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Institute Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">

                <select name="cmbinstiName" id="cmbinstiName" class="formSelect" style="width: 150px;" tabindex="4" disabled onchange="getCo(this.value);">

                    <option value=""><?php echo __("--Select--") ?></option>
<?php foreach ($instList as $inslist) {
?>
                    <option value="<?php echo $inslist->getTd_inst_id() ?>" <?php if ($trainDao->getInstituteName($trainRecordlist[0]['td_course_id'])->getTd_inst_id() == $inslist->getTd_inst_id()

                        )echo "selected" ?>><?php
                        $abc = "getTd_inst_name_" . $culture;
                        if ($inslist->$abc() == "")
                            echo $inslist->getTd_inst_name_en(); else
                            echo $inslist->$abc();
?></option>
                        <?php } ?>

                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Name") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol" id="course">
                    <select name="cmbcourseid" id="cmbcourseid" class="formSelect" style="width: 150px;" tabindex="4" onchange="getYear(this.value)">

                        <option value=""><?php echo __("--Select--") ?></option>
<?php foreach ($currentCourses as $clist) {
?>

                            <option value="<?php echo $trainDao->getCourseName($trainRecordlist[0]['td_course_id']) ?>"><?php
                            $abc = "td_course_name_" . $culture;
                            if ($clist->$abc() == "")
                                echo $clist->getTd_course_name_en(); else
                                echo $clist->$abc();
?></option>
                        <?php } ?>

                </select>
            </div>
            <br class="clear"/>
            <div class="centerCol" id="course">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Duration of Training") ?><span class="required">*</span> </label>
                    <input id="txtDuration"  name="txtDuration" type="text"  class="formInputText" value="<?php echo $trainRecordlist[0]['td_asl_duration']; ?>" tabindex="1"  maxlength="50" style="width:225px;"/>
                </div>
                <br class="clear"/>

                <div class="leftCol">
                    <label class="controlLabel" for="txtLocationCode"><?php echo __("Conducted Person") ?><span class="required">*</span> </label>
                </div>
                <div class="centerCol" id="course">
                    <input id="txtCondPers"  name="txtCondPers" type="text"  class="formInputText" value="<?php echo $trainRecordlist[0]['td_asl_conductperson']; ?>" tabindex="1" maxlength="75" style="width:225px;"/>
                </div>
                <br class="clear"/>

                <div class="leftCol">
                    <label class="controlLabel" for="txtLocationCode"><?php echo __("Conducted Date") ?><span class="required">*</span></label>
                </div>
                <div class="centerCol" id="course">
                    <input id="txtDate"  name="txtDate" type="text"  class="formInputText" value="<?php echo $trainRecordlist[0]['td_asl_conductdate']; ?>" tabindex="1" maxlength="50" style="width:225px;"/>
                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label class="controlLabel" for="txtLocationCode"><?php echo __("Content") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol" id="course">
                    <textarea class="formTextArea"  id="txtContent" name="txtContent" value="" style="height:80px;" maxlength="200"><?php echo $trainRecordlist[0]['td_asl_content']; ?></textarea>
                </div>
                <br class="clear"/>
                <div class="leftCol">
                    <label class="controlLabel" for="txtLocationCode"><?php echo __("Remarks") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol" id="course">
                    <textarea class="formTextArea"  id="txtRemarks" name="txtRemarks" value="" style="height:80px;" maxlength="200""><?php echo $trainRecordlist[0]['td_asl_remarks']; ?></textarea>
                </div>
                <br class="clear"/>
<?php
                        if ($userType == "Admin") {
?>
                            <div class="leftCol">
                                <label class="controlLabel" for="txtLocationCode"><?php echo __("Effectiveness") ?> <span class="required">*</span></label>
                            </div>
                            <div class="centerCol" id="course">
                                <textarea class="formTextArea"  id="txtEffect" name="txtEffect" value="" style="height:80px;" maxlength="200"><?php echo $trainRecordlist[0]['td_asl_effectiveness']; ?></textarea>
                            </div>
                            <br class="clear"/>
                            <div class="leftCol">
                                <label class="controlLabel" for="txtLocationCode"><?php echo __("Admin Remarks") ?> <span class="required">*</span></label>
                            </div>
                            <div class="centerCol" id="course">
                                <textarea class="formTextArea"  id="txtAdminremarks" name="txtAdminremarks" style="height:80px;" maxlength="200"><?php echo $trainRecordlist[0]['td_asl_adminremarks']; ?></textarea>
                            </div>
<?php } ?>
                        <br class="clear"/>
<?php
                        if ($userType == "Ess" && $trainRecordlist[0]['td_asl_isadcommented'] == 1) {
?>
                            <div class="leftCol">
                                <label class="controlLabel" for="txtLocationCode"><?php echo __("Effectiveness") ?> <span class="required">*</span></label>
                            </div>
                            <div class="centerCol" id="course">
                                <textarea class="formTextArea"  id="txtEffect" name="txtEffect" value="" style="height:80px;" maxlength="200"><?php echo $trainRecordlist[0]['td_asl_effectiveness']; ?></textarea>
                            </div>
                            <br class="clear"/>
<?php } ?>
            <?php
                        if ($userType == "Ess" && $trainRecordlist[0]['td_asl_isadcommented'] == 1) {
            ?>
                            <div class="leftCol">
                                <label class="controlLabel" for="txtLocationCode"><?php echo __("Admin Remarks") ?> <span class="required">*</span></label>
                            </div>
                            <div class="centerCol" id="course">
                                <textarea class="formTextArea"  id="txtAdminremarks" name="txtAdminremarks" style="height:80px;" maxlength="200"><?php echo $trainRecordlist[0]['td_asl_adminremarks']; ?></textarea>
                            </div>
<?php } ?>
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
            <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<?php
                        require_once '../../lib/common/LocaleUtil.php';
                        $sysConf = OrangeConfig::getInstance()->getSysConf();
                        $sysConf = new sysConf();
                        $inputDate = $sysConf->dateInputHint;
                        $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
                        $encryptObj = new EncryptionHandler();
?>
                        <script type="text/javascript">


                            function getCo(cid){
                                var instiname=$('#instName').val();

                                $.post(

                                "<?php echo url_for('training/ajaxloadcourse') ?>", //Ajax file

                                { cid: cid },  // create an object will all values

                                //function that is called when server returns a value.
                                function(data){



                                    var selectbox="<select name='cmbcourseid' id='cmbcourseid' class='formSelect' style='width: 150px;' tabindex='4' disabled onchange=isThere(this.value)>";
                                    selectbox=selectbox +"<option value=''><?php echo __('--Select--') ?></option>";
                                    $.each(data, function(key, value) {

                                        selectbox=selectbox +"<option value="+key+">"+value+"</option>";
                                    });
                                    selectbox=selectbox +"</select>";
                                    $('#course').html(selectbox);



                                },

                                //How you want the data formated when it is returned from the server.
                                "json"

                            );
                            }


                            function isThere(id){
                                var instiname=$('#instName').val();
                                var coursId=id;

                                $.post(

                                "<?php echo url_for('training/CheckUserthere') ?>", //Ajax file

                                { instiname: instiname , coursId: coursId },  // create an object will all values

                                //function that is called when server returns a value.
                                function(data){

                                    if(data.msg=="error"){
                                        alert("<?php echo __('You are not assign or not requested to this Training') ?>");
                                        $('#editBtn').attr('disabled', true);
                                    }else{
                                        $('#editBtn').removeAttr('disabled');
                                    }
                                    if(data.msg=="error1"){
                                        alert("<?php echo __('Training Record Already Exsits') ?>");
                                        location.href = "<?php echo url_for('training/SummeryTrainRecord?user=') . $userType ?>";

                                        $('#editBtn').attr('disabled', true);
                                    }else{
                                        $('#editBtn').removeAttr('disabled');
                                    }





                                },

                                //How you want the data formated when it is returned from the server.
                                "json"

                            );


                            }

                            $(document).ready(function() {


<?php if ($editMode == true) { ?>
                                         $('#frmSave :input').attr('disabled', true);
                                         $('#editBtn').removeAttr('disabled');
                                         $('#btnBack').removeAttr('disabled');
                                         $("#editBtn").show();
                                         buttonSecurityCommon(null,null,"editBtn",null);
<?php } ?>


                                // When click edit button
                                $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                                $("#editBtn").click(function() {

                                    var editMode = $("#frmSave").data('edit');

                                    if (editMode == 1) {
                                        // Set lock = 1 when requesting a table lock

                                        location.href="<?php echo url_for('training/UpdateTrainRecord?lock=1&empid=' . $encryptObj->encrypt($trainRecordlist[0]['emp_number']) . '&corsid=' . $encryptObj->encrypt($trainRecordlist[0]['td_course_id']) . '&mode=edit&userType=' . $userType) ?>";
                                    }
                                    else {

                                        $('#frmSave').submit();
                                    }


                                });





                                $("#txtDate").datepicker({ dateFormat: 'yy-mm-dd' });

                                var instId=$("#cmbinstiName").val();

                                $.post(

                                "<?php echo url_for('training/ajaxloadcourse') ?>", //Ajax file

                                { cid: instId },  // create an object will all values

                                //function that is called when server returns a value.
                                function(data){



                                    var selectbox="<select name='cmbcourseid' id='cmbcourseid' class='formSelect' style='width: 150px;' tabindex='4' disabled  onchange=isThere(this.value)>";
                                    selectbox=selectbox +"<option value=''><?php echo __('--Select--') ?></option>";
                                    $.each(data, function(key, value) {

                                        if(key==<?php echo $trainRecordlist[0]['td_course_id'] ?>){
                                            var select="selected";
                                        }
                                        else{
                                            var select="";
                                        }
                                        selectbox=selectbox +"<option value="+key+" "+select+">"+value+"</option>";
                                    });
                                    selectbox=selectbox +"</select>";
                                    $('#course').html(selectbox);


                                    //$("#datehiddne1").val(data.message);
                                },

                                //How you want the data formated when it is returned from the server.
                                "json"

                            );


                                jQuery.validator.addMethod("orange_date",
                                function(value, element, params) {


                                    var format = params[0];


                                    if (value == '') {

                                        return true;
                                    }
                                    var d = strToDate(value, "<?php echo $format ?>");


                                    return (d != false);

                                }, ""
                            );


                                //Validate the form
                                $("#frmSave").validate({

                                    rules: {
                                        cmbinstiName: { required: true },
                                        cmbcourseid: { required: true},
                                        txtContent: {required: true,maxlength:200,noSpecialCharsOnly:true},
                                        txtDuration:{required: true,maxlength:50},
                                        txtRemarks:{required: true,maxlength:200,noSpecialCharsOnly:true},
                                        txtDate:{required: true,orange_date:true},
                                        txtCondPers:{required: true,maxlength:75,alphaCharacters:true},
                                        txtEffect:{required: true,maxlength:200,noSpecialCharsOnly:true},
                                        txtAdminremarks:{required: true,maxlength:200,noSpecialCharsOnly:true}

                                    },
                                    messages: {
                                        cmbinstiName: "<?php echo __("Invalid Institute Name") ?>",
                                        cmbcourseid: "<?php echo __("Training Name is required") ?>",
                                        txtContent: {required:"<?php echo __("This Fiels is required") ?>",maxlength:"<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                        txtDuration:{required:"<?php echo __("This Fiels is required") ?>",maxlength:"<?php echo __("Maximum length should be 50 characters") ?>"},
                                        txtRemarks:{required:"<?php echo __("This Fiels is required") ?>",maxlength:"<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                        txtDate:{required:"<?php echo __("This Fiels is required") ?>",orange_date: "<?php echo __("Please specify valid  date"); ?>"},
                                        txtCondPers:{required:"<?php echo __("This Fiels is required") ?>",maxlength:"<?php echo __("Maximum length should be 75 characters") ?>",alphaCharacters:"<?php echo __("Invalid characters.") ?>"},
                                        txtEffect:{required:"<?php echo __("This Fiels is required") ?>",maxlength:"<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"},
                                        txtAdminremarks:{required:"<?php echo __("This Fiels is required") ?>",maxlength:"<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>"}


                                    },
                                    submitHandler: function(form) {
                                        $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                                        form.submit();
                                    }
                                });





                                //When click reset buton
                                $("#btnClear").click(function() {
                                    location.href="<?php echo url_for('training/UpdateTrainRecord?lock=0&empid=' . $encryptObj->encrypt($trainRecordlist[0]['emp_number']) . '&corsid=' . $encryptObj->encrypt($trainRecordlist[0]['td_course_id']) . '&mode=edit&userType=' . $userType) ?>";

                                });


                                //When Click back button
                                $("#btnBack").click(function() {
                                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/SummeryTrainRecordAdmin')) ?>";
                                });


                                var isaddcommented="<?php echo $trainRecordlist[0]['td_asl_isadcommented'] ?>";
                                var isAdmin="<?php echo $userType ?>";


<?php
                        if ($_SESSION['user'] != 'USR001') {
?>
                                              if(isAdmin=="Ess" && isaddcommented=="1")
                                              {
                                                  //alert("disabled");

                                                  $('#frmSave :input').attr('disabled', true);
                                                  alert("<?php echo __("Can not update Admin has Commented") ?>");
                                              }
<?php
                        }
?>
                                

            });
</script>

