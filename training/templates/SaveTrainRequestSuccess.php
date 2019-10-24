<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage2col">
    <div class="navigation">

    

    </div>
    <div id="status"></div>
    <div class="outerbox">
        
        <div class="mainHeading"><h2><?php echo __("New Training Registration") ?></h2></div>
            <?php echo message() ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Institute Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="cmbinstiName" id="cmbinstiName" class="formSelect" style="width: 150px;" tabindex="4" onchange="getCo(this.value);">

                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($instList as $inslist) {
                    ?>
                        <option value="<?php echo $inslist->getTd_inst_id() ?>" <?php if ($inslist->getTd_inst_id() == $insid

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

                            <option value="<?php echo $clist->getTd_course_id() ?> <?php if ($clist->getTd_course_id() == $cid)
                                echo "selected" ?>" <?php if ($clist->getTd_course_id() == $cID)
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
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Calender Year") ?> </label>
                            <input id="txttrainYear"  name="txttrainYear" type="text"  class="formInputText" value="" tabindex="1" readonly />
                        </div>
                        <br class="clear"/>
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee Name") ?> </label>
                            <input id="txtEmpName"  name="txtEmpName" type="text"  class="formInputText" value="" tabindex="1" readonly/>
                        </div>
                        <br class="clear"/>
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Department") ?> <span class="required"></span></label>
                            <input id="txtDepartment"  name="txtDepartment" type="text"  class="formInputText" value="" tabindex="1" readonly/>
                        </div>
                        <br class="clear"/>
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Official Address") ?> <span class="required"></span></label>
                            <textarea class="formTextArea"  id="txtAddress" name="txtAddress" readonly></textarea>
                        </div>
                        <br class="clear"/>
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("NIC No") ?> <span class="required"></span></label>
                            <input id="txtNic"  name="txtNic" type="txtNic"  class="formInputText" value="" tabindex="1" readonly/>
                        </div>
                        <br class="clear"/>
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Designation or Service") ?> <span class="required"></span></label>
                            <input id="txtDesi"  name="txtDesi" type="text"  class="formInputText" value="" tabindex="1" readonly/>
                        </div>
                        <br class="clear"/>
                        <label class="controlLabel" for="txtLocationCode"><?php echo __("Contact Phone No") ?> <span class="required"></span></label>


                        <br class="clear"/>

                        <label class="controlLabel" for="txtLocationCode"><?php echo __("Office") ?> <span class="required"></span></label>

                        <input id="txtOffPhn"  name="txtOffPhn" type="text"  class="formInputText" value="" tabindex="1" readonly/>
                        <br class="clear"/>
                        <label class="controlLabel" for="txtLocationCode"><?php echo __("mobile") ?> <span class="required"></span></label>

                        <input id="txtmobile"  name="txtmobile" type="text"  class="formInputText" value="" tabindex="1" readonly/>
                        <br class="clear"/>
                        <label class="controlLabel" for="txtLocationCode"><?php echo __("Residence") ?> <span class="required"></span></label>

                        <input id="txtResident"  name="txtResident" type="text"  class="formInputText" value="" tabindex="1" readonly/>
                        <br class="clear"/>
                        <label class="controlLabel" for="txtLocationCode"><?php echo __("Fax") ?> <span class="required"></span></label>

                        <input id="txtFax"  name="txtFax" type="text"  class="formInputText" value="" tabindex="1" readonly/>
                        <br class="clear"/>


                        <div class="formbuttons">
                            <input type="button" class="savebutton" id="editBtn"

                                   value="<?php echo __("Edit") ?>" tabindex="8" />
                            <input type="button" class="clearbutton"  id="resetBtn"
                                   value="<?php echo __("Reset") ?>" tabindex="9" />
                        </div>
                    </form>
                </div>

            </div>
            <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
            <script type="text/javascript">
                var counter=0;

                function getCo(cid){

                    $.post(

                    "<?php echo url_for('training/ajaxloadcourse') ?>", //Ajax file

                    { cid: cid },  // create an object will all values

                    //function that is called when server returns a value.
                    function(data){



                        var selectbox="<select name='cmbcourseid' id='cmbcourseid' class='formSelect' style='width: 150px;' tabindex='4' onchange='getYear(this.value)'>";
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
                function getYear(cid){

                    $.post(

                    "<?php echo url_for('training/AjaxloadcourseDetails') ?>", //Ajax file

                    { cid: cid },  // create an object will all values

                    //function that is called when server returns a value.
                    function(data){

                        $('#txttrainYear').val(data.year);



                        //alert(data.year);
                    },

                    //How you want the data formated when it is returned from the server.
                    "json"

                );
                }

                function  checkUserthere(){


                }




                $(document).ready(function() {



                    buttonSecurityCommon(null,null,"editBtn",null);

                    var user="<?php echo $_SESSION['user']; ?>"


                    if(user=="USR001"){
                        if(counter==0){
                            alert("<?php echo __('Admin cannot register for a new training'); ?>");

                            counter++;
                            $('#frmSave :input').attr('disabled', true);
                            location.href="<?php echo url_for('training/trainsummery') ?>";
                        }
                    }

                    var instId=$("#cmbinstiName").val();
                    var courseId=$("#cmbcourseid").val();



                    $.post(

                    "<?php echo url_for('training/ajaxloadcourse') ?>", //Ajax file

                    { cid: instId },  // create an object will all values

                    //function that is called when server returns a value.
                    function(data){



                        var selectbox="<select name='cmbcourseid' id='cmbcourseid' class='formSelect' style='width: 150px;' tabindex='4' disabled onchange=isThere(this.value)>";
                        selectbox=selectbox +"<option value=''><?php echo __('--Select--') ?></option>";
                        $.each(data, function(key, value) {

                            if(key==<?php
                                if (strlen($cid)

                                    )echo $cid;else
                                    echo "0";
                    ?>){
                            var select="selected";
                        }
                        else{
                            var select="";
                        }
                        selectbox=selectbox +"<option value="+key+" "+select+">"+value+"</option>";
                    });
                    selectbox=selectbox +"</select>";
                    $('#course').html(selectbox);
                    getYear($("#cmbcourseid").val());



                },

                //How you want the data formated when it is returned from the server.
                "json"

            );



                $.post(

                "<?php echo url_for('training/LoadEmployeeDetails') ?>", //Ajax file
                // create an object will all values
                { cid: 1 },

                //function that is called when server returns a value.
                function(data){
                    if(data.workstaion!= null){
                    $('#txtDepartment').val(data.workstaion);
                    }
                    if(data.fullName!= null){
                    $('#txtEmpName').val(data.fullName);
                    }
                    if(data.nic!= null){
                    $('#txtNic').val(data.nic);
                    }
                    if(data.job_tit!= null){
                    $('#txtDesi').val(data.job_tit);
                    }
                    if(data.address!= null){
                    $('#txtAddress').val(data.address);
                    }
                    if(data.offphone!= null){
                    $('#txtOffPhn').val(data.offphone);
                    }
                    if(data.mobile!= null){
                    $('#txtmobile').val(data.mobile);
                    }
                    if(data.resphone!= null){
                    $('#txtResident').val(data.resphone);
                    }
                    if(data.fax!= null){
                    $('#txtFax').val(data.fax);
                    }


                },

                //How you want the data formated when it is returned from the server.
                "json"

            );




                //Validate the form
                $("#frmSave").validate({

                    rules: {
                        cmbinstiName: { required: true },
                        cmbcourseid: { required: true}

                    },
                    messages: {
                        cmbinstiName: { required: "<?php echo __("Training Name is required") ?>"},
                        cmbcourseid: { required:"<?php echo __("Training Name is required") ?>"}

                    },
                    submitHandler: function(form) {
                        $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                        form.submit();
                    }
                });

                // When click edit button
                var mode	=	'edit';

                //Disable all fields
                $('#frmSave :input').attr('disabled', true);
                $('#editBtn').removeAttr('disabled');
                $("#editBtn").click(function() {

                    if( mode == 'edit')
                    {


                        $('#editBtn').attr('value', '<?php echo __("Save") ?>');
                        $('#frmSave :input').removeAttr('disabled');
                        mode = 'save';

                    }
                    else
                    {
                        $.post(

                        "<?php echo url_for('training/CheckTrainAssign') ?>", //Ajax file
                        // create an object will all values
                        { cid: $("#cmbcourseid").val() },

                        //function that is called when server returns a value.
                        function(data){

                            if(data.msg=="ok")
                            {
                                $('#frmSave').submit();
                            }
                            else{
                                if(data.isRejected==-1){
                                alert("<?php echo __('You have already assigned to this training and it was rejected.') ?>");
                                }
                                else{
                                alert("<?php echo __('You have already assigned to this training try another.') ?>");
                                }
                            }


                        },
                        "json"
                    );


                    }
                });


                //When click reset buton
                $("#resetBtn").click(function() {
                    document.forms[0].reset('');
                });

                //When Click back button
                $("#btnBack").click(function() {
                    location.href = "<?php echo url_for('training/Newregister') ?>";
    });




});
</script>
