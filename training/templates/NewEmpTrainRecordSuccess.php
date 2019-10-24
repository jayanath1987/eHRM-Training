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
    label.error{
        padding-left:150px;
    }
</style>    
<div class="formpage2col">
    <div class="navigation">

        <?php echo message() ?>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("New Training Record") ?></h2></div>

        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Institute Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbinstiName" id="cmbinstiName" class="formSelect" style="width: 150px;" tabindex="4" onchange="getCo(this.value);">

                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($instList as $inslist) {
                    ?>
                        <option value="<?php echo $inslist->getTd_inst_id() ?>"<?php if ($inslist->getTd_inst_id() == $insid
                        
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

                    <select name="cmbcourseid" id="cmbcourseid" class="formSelect" style="width: 150px;" tabindex="4" onchange="isThere(this.value)">

                        <option value=""><?php echo __("--Select--") ?></option>
                            <?php foreach ($currentCourses as $clist) {
 ?>

                    <option value="<?php echo $clist->getTd_course_id() ?>" <?php if ($clist->getTd_course_id() == $cid)
                                    echo "selected" ?>><?php
                                    $abc = "getTd_course_name_" . $culture;
                                    if ($clist->$abc() == "")
                                        echo $clist->getTd_course_name_en(); else
                                        echo $clist->$abc();
                            ?></option>
<?php } ?>

                            </select>
                        </div>
                        <br class="clear"/>
                        <div class="leftCol" id="course">
                            <label class="controlLabel" for="txtLocationCode" ><?php echo __("Duration of Training") ?> <span class="required">*</span></label>
                            <input id="txtDuration"  name="txtDuration" type="text"  class="formInputText" value="" tabindex="1" readonly="readonly" maxlength="50" style="width:225px;"/>
                            <input id="txtDuration"  name="txthidden" type="hidden"  class="formInputText" value="gone" tabindex="1"  />
                        </div>
                        <br class="clear"/>

                        <div class="leftCol">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Conducted Person") ?> <span class="required">*</span></label>
                        </div>
                        <div class="centerCol" id="course">
                            <input id="txtCondPers"  name="txtCondPers" type="text"  class="formInputText" value="" tabindex="1" maxlength="75" style="width:225px;"/>
                        </div>
                        <br class="clear"/>

                        <div class="leftCol">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Conducted Date") ?><span class="required">*</span></label>
                        </div>
                        <div class="centerCol" id="course">
                            <input id="txtDate"  name="txtDate" type="text"  class="formInputText" value="" tabindex="1" maxlength="50" style="width:225px;"/>
                        </div>
                        <br class="clear"/>
                        <div class="leftCol">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Content") ?> <span class="required">*</span></label>
                        </div>
                        <div class="centerCol" id="course">
                            <textarea class="formTextArea"  id="txtContent" name="txtContent"  style="height:80px;"></textarea>
                        </div>
                        <br class="clear"/>
                        <div class="leftCol">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Remarks") ?> <span class="required">*</span></label>
                        </div>
                        <div class="centerCol" id="course">
                            <textarea class="formTextArea"  id="txtRemarks" name="txtRemarks" MAXLENGTH=200 style="height:80px;"></textarea>
                        </div>
                        <br class="clear"/>

                        <br class="clear"/>



                        <div class="formbuttons">
                            <input type="button" class="savebutton" id="editBtn"

                                   value="<?php echo __("Edit") ?>" tabindex="8" />
                            <input type="button" class="clearbutton"  id="resetBtn"
                                   value="<?php echo __("Reset") ?>" tabindex="9" />
                            <input type="button" class="backbutton" id="btnBack"
                       value="<?php echo __("Back") ?>" tabindex="10" />
                                            </div>
                                        </form>
                                    </div>

                                </div>
<?php
                                require_once '../../lib/common/LocaleUtil.php';
                                $sysConf = OrangeConfig::getInstance()->getSysConf();
                                $sysConf = new sysConf();
                                $inputDate = $sysConf->dateInputHint;
                                $format = LocaleUtil::convertToXpDateFormat($sysConf->getDateFormat());
?>

                                <script type="text/javascript">


                                    function getCo(cid){
                                        var instiname=$('#instName').val();

                                        // post(file, data, callback, type); (only "file" is required)
                                        $.post(

                                        "<?php echo url_for('training/ajaxloadcourse') ?>", //Ajax file

                                        { cid: cid },  // create an object will all values

                                        //function that is called when server returns a value.
                                        function(data){



                                            var selectbox="<select name='cmbcourseid' id='cmbcourseid' class='formSelect' style='width: 150px;' tabindex='4' onchange=isThere(this.value)>";
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
                                                alert("<?php echo __('You are not assigned or not requested to this training') ?>");
                                                location.href = "<?php echo url_for('training/NewEmpTrainRecord?user=') . $userType ?>";
                                                //$('#editBtn').attr('disabled', true);
                                            }else{
                                                
                                                $('#editBtn').removeAttr('disabled');
                                            }

                                            if(data.msg1=="error"){
                                                alert("<?php echo __('Training Record Already Exists') ?>");
                                                location.href = "<?php echo url_for('training/NewEmpTrainRecord?user=') . $userType ?>";

                                                $('#editBtn').attr('disabled', true);
                                            }else{
                                                
                                                $('#editBtn').removeAttr('disabled');
                                            }

                                             if(data.isRejected=="-1"){
                                                alert("<?php echo __('You have already assigned to this training and it was rejected.') ?>");
                                                location.href = "<?php echo url_for('training/NewEmpTrainRecord?user=') . $userType ?>";

                                                $('#editBtn').attr('disabled', true);
                                            }else{

                                                $('#editBtn').removeAttr('disabled');
                                            }

                                            if(data.msg!="error" && data.msg1!="error"){
                                                $("#txtDuration").val(data.fullDate);
                                                $("#txtDate").val(data.conductDate);


                                            }

                                            


                                        },

                                        //How you want the data formated when it is returned from the server.
                                        "json"

                                    );


                                    }



                                    $(document).ready(function() {



                                        buttonSecurityCommon(null,null,"editBtn",null);

                                        $("#txtDate").datepicker({ dateFormat: '<?php echo $inputDate; ?>' });



                                        // When click edit button
                                        var mode	=	'edit';

                                        //Disable all fields
                                        $('#frmSave :input').attr('disabled', true);
                                        $('#editBtn').removeAttr('disabled');
                                        $('#btnBack').removeAttr('disabled');


                                        // When click edit button

                                        $("#editBtn").click(function() {

                                            if( mode == 'edit')
                                            {


                                                $('#editBtn').attr('value', '<?php echo __("Save") ?>');
                                                $('#frmSave :input').removeAttr('disabled');
                                                mode = 'save';


                                            }
                                            else
                                            {


                                                $('#frmSave').submit();


                                            }
                                        });


                                        jQuery.validator.addMethod("orange_date",
                                        function(value, element, params) {

                                            //var hint = params[0];
                                            var format = params[0];

                                            // date is not required
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
                                                txtContent: {required: true,maxlength:200,noSpecialCharsWithBrackets:true},
                                                txtDuration:{required: true,maxlength:50},
                                                txtRemarks:{required: true,maxlength:200,noSpecialCharsWithBrackets:true},
                                                txtDate:{required: true,orange_date:true},
                                                txtCondPers:{required: true,maxlength:75,alphaCharacters:true}

                                            },
                                            messages: {
                                                cmbinstiName: "<?php echo __("This Field is required") ?>",
                                                cmbcourseid: "<?php echo __("This Field is required") ?>",
                                                txtContent: {required:"<?php echo __("This Field is required") ?>",maxlength:"<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsWithBrackets:"<?php echo __("No invalid characters are allowed") ?>"},
                                                txtDuration:{required:"<?php echo __("This Field is required") ?>",maxlength:"<?php echo __("Maximum length should be 50 characters") ?>"},
                                                txtRemarks:{required:"<?php echo __("This Field is required") ?>",maxlength:"<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsWithBrackets:"<?php echo __("No invalid characters are allowed") ?>"},
                                                txtDate:{required:"<?php echo __("This Field is required") ?>",orange_date: "<?php echo __("Please specify valid  date"); ?>"},
                                                txtCondPers:{required:"<?php echo __("This Field is required") ?>",maxlength:"<?php echo __("Maximum length should be 75 characters") ?>",alphaCharacters:"<?php echo __("No invalid characters are allowed") ?>"}




                                            }
                                        });

                                        //When click reset buton
                                        $("#resetBtn").click(function() {
                                            document.forms[0].reset('');
                                        });

                                        //When Click back button
                                        $("#btnBack").click(function() {
                                            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/SummeryTrainRecord')) ?>";
        });




    });
</script>
