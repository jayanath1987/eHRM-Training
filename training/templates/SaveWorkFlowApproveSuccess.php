<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage2col">
    <div class="navigation">

        <?php echo message() ?>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Training Approval") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="<?php echo url_for('training/WorkFlowApprove'); ?>">

                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee ID") ?> </label>
                            <input id="txtEmpID"  name="txtEmpID" type="text"  class="formInputText" value="<?php echo $AssignEmployee->Employee->employeeId; ?>" tabindex="1" readonly/>
                        </div>
            <br class="clear">
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee Name") ?> </label>
                            <input id="txtEmpName"  name="txtEmpName" type="text"  class="formInputText" value="<?php 
                                           if ($culture == 'en') {
                                                $abc = "emp_display_name";
                                            } else {
                                                $abc = "emp_display_name_" . $culture;
                                            }

                                            $dd = $AssignEmployee->Employee->$abc;
                                            if($dd==null){
                                               $dd=$AssignEmployee->Employee->emp_display_name;
                                            }
                            echo $dd ?>" tabindex="1" readonly/>
                        </div>
            <br class="clear">
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Institute") ?> </label>
                            <input id="txtInstitute"  name="txtInstitute" type="text"  class="formInputText" value="<?php 
             
                                             $abc = "td_inst_name_" . $culture;
                                            

                                            $dd = $AssignEmployee->TrainingCourse->TrainingInstitute->$abc;
                                            if($dd==null){
                                               $dd=$AssignEmployee->TrainingCourse->TrainingInstitute->td_inst_name_en;
                                            }
                                            
                            echo $dd ?>" tabindex="1" readonly/>
                        </div>
            <br class="clear">
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Name") ?> </label>
                            <input id="txtTrainingName"  name="txtTrainingName" type="text"  class="formInputText" value="<?php 
                                           
                                                $abc = "td_course_name_" . $culture;
                                            

                                            $dd = $AssignEmployee->TrainingCourse->$abc;
                                            if($dd==null){
                                               $dd=$AssignEmployee->TrainingCourse->td_course_name_en;
                                            }
                            echo $dd ?>" tabindex="1" readonly/>
                        </div>
            <br class="clear">
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Year") ?> </label>
                            <input id="txtTrainingCalenderYear"  name="txtTrainingYear" type="text"  class="formInputText" value="<?php echo $AssignEmployee->td_asl_year ?>" tabindex="1" readonly/>
                        </div>
            <br class="clear">
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Start Date") ?> </label>
                            <input id="txtStartDate"  name="txtStartDate" type="text"  class="formInputText" value="<?php echo LocaleUtil::getInstance()->formatDate($AssignEmployee->TrainingCourse->td_course_fromdate) ?>" tabindex="1" readonly/>
                        </div>
            <br class="clear">  
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("End Date") ?> </label>
                            <input id="txtEndDate"  name="txtEndDate" type="text"  class="formInputText" value="<?php echo LocaleUtil::getInstance()->formatDate($AssignEmployee->TrainingCourse->td_course_todate) ?>" tabindex="1" readonly/>
                        </div>
            
                        <br class="clear">
                        <div class="centerCol" id="course">
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("Comment") ?> <span class="required">*</span></label>
                            <textarea id="txtComment"  name="txtComment"   class="formTextArea" value="" tabindex="1" style="width: 150px;"></textarea>
                        </div>
                        <div class="centerCol" id="course">
<br class="clear">
<a style="padding-left: 10px;" href="javascript:void(0);" onclick="trainingHistoryPopup(<?php echo $AssignEmployee->Employee->getEmpNumber() ?>)" >
                           <?php
                                            echo __("Training History");
                            ?></a>     
                        </div>  

            
                    
         <br class="clear">
         <div class="formbuttons">
             

    <input type="hidden" name="hiddenWfMainID" value="<?php echo $wfID ?>" />
    <input type="hidden" id="hiddenStatus" name="hiddenStatus" value="" />

    
    <input  type="button" class="backbutton" id="buttonRemove" onclick="submmit('1');"
       value="<?php echo __("Approve") ?>" />


    <input type="button" class="backbutton" id="buttonRemove" onclick="submmit('0');"
       value="<?php echo __("Reject") ?>" />
         </div>
</form>
                </div>

            </div>
            <div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
            <script type="text/javascript">
 function submmit(status){
    if(status==1){    
        $("#hiddenStatus").val("1");

    }else{
        $("#hiddenStatus").val("0");
    }
                               
    $("#frmSave").submit()
}
 function trainingHistoryPopup(empId){
                $.ajax({
                    type: "POST",
                    async:false,
                    url: "<?php echo url_for('training/AjaxEncryption') ?>",
                                data: { empId: empId },
                                dataType: "json",
                                success: function(data){empId = data;}
                            });

                            window.open( "<?php echo url_for('training/trainingHistory?empId=') ?>"+empId, "myWindow", "status = 1, height = 300, width = 825, resizable = 0" );
                        }
                $(document).ready(function() {

                    $("#frmSave").validate({

    rules: {
      txtComment:{maxlength:200,noSpecialCharsOnly:true, required: true }  
     },
    messages: {
        txtComment:{ maxlength: "<?php echo __("Maximum length should be 200 characters") ?>",noSpecialCharsOnly:"<?php echo __("No invalid characters are allowed") ?>", required:"<?php echo __("This Field is required") ?>" }
     }
     });

                    buttonSecurityCommon(null,null,"editBtn",null);



});
</script>
