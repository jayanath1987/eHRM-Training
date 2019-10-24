<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
?>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">


    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Training Participation") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSave" id="frmSave" method="post"  action="">


            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Institute Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">

                <select name="instName" id="instName" class="formSelect" style="width: 150px;" tabindex="4" onchange="getCo(this.value);" <?php echo $disabled ?>>


                    <option value="" ><?php echo __("--Select--") ?></option>
                    <?php foreach ($instList as $list) {
                    ?>
                        <option value="<?php echo $list->getTd_inst_id() ?>" <?php if ($list->getTd_inst_id() == $instituteId

                            )echo "selected=\"selected\""; ?>><?php
                            $abc = "getTd_inst_name_" . $culture;
                            if ($list->$abc() == "")
                                echo $list->getTd_inst_name_en(); else
                                echo $list->$abc(); ?></option>

                    <?php } ?>

                    </select>
                </div>
                <br class="clear"/>

                <div class="leftCol">
                    <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Name") ?> <span class="required">*</span></label>
                </div>
                <div class="centerCol" id="courselist">

                    <select name="courseid" id="courseid" class="formSelect" style="width: 150px;" tabindex="4" onchange="getCourseId(this.value,<?php echo $instituteId ?>)" <?php echo $disabled ?>>

                        <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($currentCourses as $clist) {
                    ?>

                            <option value="<?php echo $clist->getTd_course_id() ?>" <?php if ($clist->getTd_course_id() == $cID)
                                echo "selected=\"selected\"" ?>><?php
                                $abc = "getTd_course_name_" . $culture;
                                if ($clist->$abc() == "")
                                    echo $clist->getTd_course_name_en(); else
                                    echo $clist->$abc();
                    ?></option>
                    <?php } ?>

                        </select>

                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Calender Year") ?> <span class="required">*</span></label>
                    </div>
                    <div class="centerCol">

                        <input id="txten"  name="txtyear"  type="text" style='width:140px;'  class="formInputText" value="<?php if (is_object($assCourse)

                                )echo $assCourse[0]->getTd_asl_year() ?>" tabindex="1" maxlength="4" <?php echo $disabled ?>/>


                     </div>
                     <br class="clear"/>
                     <div class="leftCol">
                         <label class="controlLabel"  for="txtLocationCode"  style='padding-top:5px;'><?php echo __("Employee List") ?></label>
                     </div>


                     <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 690px; border-style:  solid; border-color: #FAD163; padding-top:0px;  height:100%; display:inline-block;">
                         <div style="">
                             <div class="centerCol" style='width:150px; background-color:#FAD163;'>
                                 <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Employee Name") ?></label>
                             </div>
                             <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                                 <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444;"><?php echo __("Participated") ?></label>
                             </div>
                             <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                                 <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; width:100px; background-color:#FAD163; margin-top: 0px; color:#444444;"><?php echo __("Approve Status") ?></label>
                             </div>
                             <div class="centerCol" style='width:340px;  background-color:#FAD163;'>
                                 <label class="languageBar" style="width:133px; padding-left:0px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Comment") ?></label>
                                 <label class="languageBar" style="width:150px; padding-left:17px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Training History") ?></label>
<!--                                 <label class="languageBar" style="width:75px; padding-left:9px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Remove") ?></label>-->
                             </div>

                         </div>
                         <br class="clear"/>

                         <div id="tohide">
                    <?php
                                if (strlen($childDiv)) {

                                    echo $sf_data->getRaw('childDiv');
                                }
                    ?>

                            </div>
                            <br class="clear"/>
                        </div>
                        <br class="clear"/>

                        <div class="leftCol">
                            <br class="clear"/>
                            <label class="controlLabel" for="txtLocationCode"><?php echo __("General Comment") ?> </label>
                        </div>

                        <div class="centerCol" id="courselist" style='padding-left:1px;'>
                            <br class="clear"/>
                            <textarea name="gencomment_en" id="gencomment_en" <?php echo $disabled ?>><?php if (is_object($GenerealComment)

                                    )echo $GenerealComment[0]->getTd_asl_admincomment() ?></textarea>


                            </div>

                            <br class="clear"/>
                            <input type="hidden" name="hiddeni" id="hiddeni" value="<?php if (strlen($i)

                                        )echo $i; ?>"/>
                             <div class="formbuttons">
                                 <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                                        value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                                        title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                                        onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
                                 <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                                        onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                                        value="<?php echo __("Reset"); ?>" />

                             </div>
                         </form>
                     </div>

                 </div>

                 <script type="text/javascript">
                     //ajax start to load to the grid ///
                     var courseId="";
                     var empIDMaster
                     var myArray2= new Array();

                     function trainingHistoryPopup(empId){
                         window.open( "<?php echo url_for('training/trainingHistory?empId=') ?>"+empId, "myWindow", "status = 1, height = 300, width = 825, resizable = 0" );
                     }

                     function GetListedEmpids(){


                         var cname=$('#courseid').val();


                         if(cname!=""){
                             $.post(

                             "<?php echo url_for('training/GetListedEmpids') ?>", //Ajax file

                             { cname : cname },  // create an object will all values

                             //function that is called when server returns a value.
                             function(data){

                                 $.each(data, function(key, value) {
                                     myArray2.push(Number(value));

                                 });



                             },

                             //How you want the data formated when it is returned from the server.
                             "json"

                         );

                         }

                     }
                     function removeByValue(arr, val) {
                         for(var i=0; i<arr.length; i++) {
                             if(arr[i] == val) {

                                 arr.splice(i, 1);

                                 break;

                             }
                         }
                     }
                     function deleteSaved(empId,cId,rawId,inst){

                         answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

                         if (answer !=0)
                         {
                             removeByValue(myArray2, empId);

                             $.post(

                             "<?php echo url_for('training/deleteSavedTrain') ?>", //Ajax file

                             { empId : empId , cId : cId },  // create an object will all values

                             //function that is called when server returns a value.
                             function(data){

                                 if(data.isDeleted==true){

                                     alert("<?php echo __('Sucessfully Deleted') ?>");
                                     window.location = "<?php echo url_for('training/participations?id=') ?>"+cId+"?insid="+inst;

                                     $('#hiddeni').val(Number($('#hiddeni').val())-1);


                                 }



                             },

                             //How you want the data formated when it is returned from the server.
                             "json"

                         );

                         }
                         else{
                             return false;
                         }
                     }

                     function getCourseId(id,insid){

                         courseId=id;


                         $.post(

                         "<?php echo url_for('training/checkcourse') ?>", //Ajax file

                         { id: id },  // create an object will all values

                         //function that is called when server returns a value.
                         function(data){
                             window.location = "<?php echo url_for('training/participations?id=') ?>"+id+"?insid="+insid+"&hideBtnFlg=1";
                             if(data.isCo=="yes"){


                             }
                             else{

                             }



                         },

                         //How you want the data formated when it is returned from the server.
                         "json"

                     );


                     }

                     function SelectEmployee(data){

                         myArr=new Array();
                         lol=new Array();
                         myArr = data.split('|');


                         addtoGrid(myArr);
                     }


                     function addtoGrid(empid){


                         var arraycp=new Array();

                         var arraycp = $.merge([], myArray2);

                         var items= new Array();
                         for(i=0;i<empid.length;i++){
                             items[i]=empid[i];
                         }




                         var u=1;

                         $.each(items,function(key, value){


                             if(jQuery.inArray(value, arraycp)!=-1)
                             {

                                 if(!Array.indexOf){
                                     Array.prototype.indexOf = function(obj){
                                         for(var i=0; i<this.length; i++){
                                             if(this[i]==obj){
                                                 return i;
                                             }
                                         }
                                         return -1;
                                     }
                                 }

                                 var idx = arraycp.indexOf(value);
                                 // Find the index

                                 if(idx!=-1) arraycp.splice(idx, 1); // Remove it if really found!

                                 u=0;

                             }
                             else{

                                 arraycp.push(value);



                             }


                         }


                     );

                         $.each(myArray2,function(key, value){

                             if(jQuery.inArray(value, arraycp)!=-1)
                             {


                                 var idx = arraycp.indexOf(value); // Find the index
                                 if(idx!=-1) arraycp.splice(idx, 1); // Remove it if really found!

                                 u=0;


                             }
                             else{


                             }


                         }


                     );
                         $.each(arraycp,function(key, value){
                             myArray2.push(value);
                         }


                     );

                         if(u==0){
                             // alert("user already exsits");
                             //return false;
                         }
                         var courseId1=$('#courseid').val();
                         $.post(

                         "<?php echo url_for('training/LoadGrid') ?>", //Ajax file



                         { 'empid[]' : arraycp },  // create an object will all values

                         //function that is c    alled when server returns a value.
                         function(data){

                             var childDiv="";
                             var testDiv="";
                             var participated="";
                             var testDiv="";
                             var approved="";
                             var comment="";
                             var delete1="";
                             var rowstart="";
                             var rowend="";
                             var childdiv="";


                             $.each(data, function(key, value) {
                                 i=Number($('#hiddeni').val())+1;


                                 childdiv="<div id='row_"+i+"' style='padding-top:15px;  height:100%; display:inline-block;'>";
                                 childdiv+="<div class='centerCol' id='master' style='width:150px;'>";
                                 childdiv+="<div id='employeename' style=' padding-left:3px;'>"+key+"</div>";
                                 childdiv+="</div>";
                                 childdiv+="<div class='centerCol' id='master' style='width:100px;'>";

                                 childdiv+="<div id='child' style=' padding-left:3px;'><select id='parti' name='parti_"+courseId1+"_"+value+"_"+i+"' style='width:50px;'><option id='0' value='0' selected='selected'><?php echo __('No') ?></option></select></div>";
                                 childdiv+="</div>";
                                 childdiv+="<div class='centerCol' id='master' style='width:175px;'>";

                                 childdiv+="<div id='child' style=' padding-left:3px;'><input type='text' style='width:50px;' readonly='readonly' name='appro_"+courseId1+"_"+value+"_"+i+"' value='<?php echo __('Pending') ?>'/></div>";
                                 childdiv+="</div>";
                                 childdiv+="<div class='centerCol' id='master' style='width:150px;'>";
                                 childdiv+="<div id='child' style=' padding-left:3px;'><input type='text' id='commentGrid' name='commentgrid_"+courseId1+"_"+value+"_"+i+"' style='width:125px;' maxlength='200' onkeypress='return onkeyUpevent(event)' onblur='return validationComment(event,this.id)'/></div>";
                                 childdiv+="</div>";
                                 childdiv+="<div class='centerCol' id='master' style='width:150px;'>";
                                 childdiv+="<div id='child' name='delete_"+courseId1+"_"+value+"_"+i+"' style='height:25px; padding-left:3px;'><a href='#' style='width:50px;' onclick='deleteCRow("+i+","+value+")'><?php echo __('Delete') ?></a></div>";
                                 childdiv+="</div>";
                                 childdiv+="</div>";

                                 $('#employeeGrid').append(childdiv);

                                 $('#hiddeni').val(i);

                             });



                         },

                         //How you want the data formated when it is returned from the server.
                         "json"

                     );


                     }

                     function deleteCRow(id,value){

                         answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

                         if (answer !=0)
                         {

                             $("#row_"+id).remove();
                             removeByValue(myArray2, value);

                             $('#hiddeni').val(Number($('#hiddeni').val())-1);

                         }
                         else{
                             return false;
                         }


                     }
                     //ajax close to load the grid

                     //Ajax Start to Load the Courses

                     function getCo(cid){
                         var instiname=$('#instName').val();

                            

                         $.post(

                         "<?php echo url_for('training/ajaxloadcourse') ?>", //Ajax file

                         { cid: cid },  // create an object will all values

                         //function that is called when server returns a value.
                         function(data){

                         

                             var selectbox="<select name='courseid' id='courseid' class='formSelect' style='width: 150px;' tabindex='4' onchange='getCourseId(this.value,"+instiname+")'>";
                             selectbox=selectbox +"<option value=''><?php echo __('--Select--') ?></option>";
                             $.each(data, function(key, value) {

                                 selectbox=selectbox +"<option value="+key+">"+value+"</option>";
                             });
                             selectbox=selectbox +"</select>";
                             $('#courselist').html(selectbox);
                             $('#tohide').html("");
                             $('#txten').val("");
                             $('#gencomment_en').val("");
                             $('#gencomment_si').val("");
                             $('#gencomment_ta').val("");


                         },

                         //How you want the data formated when it is returned from the server.
                         "json"

                     );



                     }

                     function validationComment(e,id){


                         if($('#'+id).val().length > 200){
                             alert("<?php echo __('Maximum length should be 200 characters') ?>");
                             return false;
                         }else {
                             return true;
                         }

                     }
                     function onkeyUpevent(e){


                         var keynum;
                         var keychar;
                         var numcheck;


                         if(window.event) // IE
                         {
                             keynum = e.keyCode;
                         }
                         else if(e.which) // Netscape/Firefox/Opera
                         {
                             keynum = e.which;
                         }
                         keychar = String.fromCharCode(keynum);
                         numcheck = /^[^@\*\!#\$%\^&()~`\+=]+$/i;

                         if(!numcheck.test(keychar)){
                             alert("<?php echo __('No invalid characters are allowed') ?>");
                             return false;
                         }
                     }

                     //Ajax End to Load Courses//


                     $(document).ready(function() {
                     var hideBtn="<?php echo $hideBtnFlag; ?>";
                     
                     if(hideBtn!=1){
 
                        $("#editBtn").hide();
                        $("#empRepPopBtn").hide();
                    }else{

                        $("#editBtn").show();
                        $("#empRepPopBtn").show();
                    }
                    $('#frmSave :input').removeAttr('disabled');
                    
<?php if ($editMode == true && $hideBtnFlag!=0) { ?>
                            $('#frmSave :input').attr('disabled', true);
                            $('#editBtn').removeAttr('disabled');
                                    //$("#editBtn").show();
                                    buttonSecurityCommon(null,null,"editBtn",null);
                                    buttonSecurityCommonMultiple(null,null,null,"deleteLinks");
<?php } else { ?>
                                       // $("#editBtn").show();
                                        buttonSecurityCommon(null,"editBtn",null,null);
<?php } ?>




                                    var cname=$('#courseid').val();

                                    //var course

                                    if(cname!=""){
                                        $.post(

                                        "<?php echo url_for('training/GetListedEmpids') ?>", //Ajax file

                                        { cname : cname },  // create an object will all values

                                        //function that is called when server returns a value.
                                        function(data){

                                            $.each(data, function(key, value) {
                                                myArray2.push(value);

                                            });

                                        },

                                        //How you want the data formated when it is returned from the server.
                                        "json"

                                    );

                                    }



                                    //Validate the form
                                    $("#frmSave").validate({

                                        rules: {
                                            instName: { required: true },
                                            courseid: { required: true },
                                            txtyear: { required: true,digits: true,maxlength:4,minlength:4 },
                                            gencomment_en: { noSpecialCharsOnly: true,maxlength:200 },
                                            gencomment_si: { noSpecialChars: true },
                                            gencomment_ta: { noSpecialChars: true }
                                        },
                                        messages: {
                                            instName: "<?php echo __("Invalid Institute Name") ?>",
                                            courseid: "<?php echo __("Training Name is required") ?>",
                                            txtyear: "<?php echo __("Training Year is required") ?>",
                                            gencomment_en: {noSpecialCharsOnly:"<?php echo __("No Special characters allowed") ?>",maxlength:"<?php echo __("Maximum length should be 200 characters") ?>"},
                                            gencomment_si: "<?php echo __("No Special characters allowed") ?>",
                                            gencomment_ta: "<?php echo __("No Special characters allowed") ?>"

                                        },
                                        submitHandler: function(form) {
                                            $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                                            form.submit();
                                        }
                                    });


                                    var mode	='<?php echo $mode ?>';



                                    // When click edit button
                                    $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

                                    $("#editBtn").click(function() {

                                        var editMode = $("#frmSave").data('edit');
                                        if (editMode == 1) {
                                            // Set lock = 1 when requesting a table lock

                                            location.href="<?php echo url_for('training/participations?insid=' . $instituteId . '&id=' . $cID . '&hideBtnFlg=1&lock=1') ?>";
                                        }
                                        else {
                                            if(myArray2.length==0){
                                                alert("<?php echo __('Please select at least one employee') ?>");
                                            }
                                            else{
                                                $('#frmSave').submit();

                                            }
                                        }


                                    });

                                    $('#empRepPopBtn').click(function() {

                                        var popup=window.open('<?php echo public_path('../../symfony/web/index.php/pim/searchEmployee?type=multiple&method=SelectEmployee'); ?>','Locations','height=450,width=800,resizable=1,scrollbars=1');


                                        if(!popup.opener) popup.opener=self;
                                        popup.focus();
                                    });


                                    //When click reset buton
                                    $("#btnClear").click(function() {
                                        // Set lock = 0 when resetting table lock
                                        location.href="<?php echo url_for('training/participations?insid=' . $instituteId . '&id=' . $cID . '&lock=0') ?>";
                                    });

                                    //When Click back button
                                    $("#btnBack").click(function() {
                                        location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/trainsummery')) ?>";
                   });

               });
</script>

