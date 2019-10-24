<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled ="disabled"';
}
$encrypt = new EncryptionHandler();
?>

<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">


    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Training") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSave" id="frmSave" method="post"  action="">


            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Institute Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">

                <select name="instName" id="instName" class="formSelect"  onchange="getCo(this.value);" <?php echo $disabled ?>>


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

                    <select name="courseid" id="courseid" class="formSelect"  onchange="getCourseId(this.value,'<?php echo $instituteId ?>')" <?php echo $disabled ?>>

                        <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($currentCourses as $clist) {
                    ?>

                            <option value="<?php echo $clist->getTd_course_id() ?>" <?php if ($clist->getTd_course_id() == $cID)
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
                    <div class="leftCol">
                        <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Calender Year") ?> <span class="required">*</span></label>
                    </div>
                    <div class="centerCol">
                        <input type="text" class="formInputText" style="width:180px"  id="txtyear" name="txtyear"  value="<?php echo $TDYear;  //if($assCourse[0]){ echo $assCourse[0]->getTd_asl_year(); } ?>" />
                     

                    </div>
                    <br class="clear"/>
                    <div class="leftCol">
                        <label class="controlLabel"  for="txtLocationCode"  style='padding-top:5px;'><?php echo __("Employee List") ?></label>
                        </div>


                        <div id="employeeGrid" class="centerCol" style="margin-left:10px; margin-top: 8px; width: 660px; height: 100%; border-style:  solid; border-color: #FAD163">
                            <div style="">
                                <div class="centerCol" style='width:150px; background-color:#FAD163;'>
                                    <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px;  color:#444444;"><?php echo __("Employee Name") ?></label>
                                </div>

                                <div class="centerCol" style='width:260px;  background-color:#FAD163;'>
                                    <label class="languageBar" style="padding-left:2px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Comment") ?></label>
                                </div>
                                <div class="centerCol" style='width:100px;  background-color:#FAD163;'>
                                    <label class="languageBar" style="width:100px; padding-left:8px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Training History") ?></label>
                                </div>
                                <div class="centerCol" style='width:150px;   background-color:#FAD163;'>
                                    <label class="languageBar" style="width:100px; padding-left:20px; padding-top:2px;padding-bottom: 1px; background-color:#FAD163; margin-top: 0px; color:#444444; text-align:inherit"><?php echo __("Remove") ?></label>
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

                        <div class="centerCol"  style='padding-left:1px;'>
                            <br class="clear"/>
                            <textarea name="gencomment_en" rows="3" cols="5" id="gencomment_en" <?php echo $disabled ?>><?php if (is_object($GenerealComment)

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
                                 <input type="button" class="savebutton" id="empRepPopBtn" value="<?php echo __("Add Employee") ?>" tabindex="8" <?php echo $disabled; ?>/>
                             </div>
                         </form>
                     </div>

                 </div>

                 <script type="text/javascript">
                     // <![CDATA[
                     //ajax start to load to the grid ///
                     var courseId="";
                     var empIDMaster;
                     var myArray2= new Array();

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

                                     $.ajax({
                                         type: "POST",
                                         async:false,
                                         url: "<?php echo url_for('training/AjaxEncryption') ?>",
                                         data: { empId: cId },
                                         dataType: "json",
                                         success: function(data){cId = data;}
                                     });
                                     $.ajax({
                                         type: "POST",
                                         async:false,
                                         url: "<?php echo url_for('training/AjaxEncryption') ?>",
                                         data: { empId: inst },
                                         dataType: "json",
                                         success: function(data){inst = data;}
                                     });


                                     alert("<?php echo __('Successfully Deleted') ?>");
                                     window.location = "<?php echo url_for('training/assigntrain?id=') ?>"+cId+"?insid="+inst+"&hideBtnFlg=1";

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
                         insid=$("#instName").val();

                         $.post(

                         "<?php echo url_for('training/checkcourse') ?>", //Ajax file

                         { id: id },  // create an object will all values

                         //function that is called when server returns a value.
                         function(data){
                             $.ajax({
                                 type: "POST",
                                 async:false,
                                 url: "<?php echo url_for('training/AjaxEncryption') ?>",
                                 data: { empId: id },
                                 dataType: "json",
                                 success: function(data){id = data;}
                             });
                             $.ajax({
                                 type: "POST",
                                 async:false,
                                 url: "<?php echo url_for('training/AjaxEncryption') ?>",
                                 data: { empId: insid },
                                 dataType: "json",
                                 success: function(data){insid = data;}
                             });


                            // window.location = "<?php echo url_for('training/assigntrain?id=') ?>"+id+"?insid="+insid;
                             window.location = "<?php echo url_for('training/assigntrain?id=') ?>"+id+"?insid="+insid+"&hideBtnFlg=1";
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
                             ;

                             if(jQuery.inArray(value, arraycp)!=-1)
                             {

                                 // ie of array index find bug sloved here//
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
                                 //// Find the index

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

                                 // ie of array index find bug sloved here//
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
                                 var word=value.split("|");

                                 childdiv="<div id='row_"+i+"' style='padding-top:5px;  height:100%; display:inline-block;'>";
                                 childdiv+="<div class='centerCol' id='master' style='width:150px; '>";
                                 childdiv+="<div id='employeename' style='padding-left:3px;'>"+word[1]+"</div>";
                                 childdiv+="</div>";

                                 childdiv+="<div class='centerCol' id='master' style='width:220px;'>";
                                 childdiv+="<div id='child' style='padding-left:3px;'><input style='width:220px;' type='text' id='commentGrid' name='commentgrid_"+courseId1+"_"+word[3]+"_"+i+"' style='width:125px;' maxlength='200' onkeypress='return onkeyUpevent(event)' onblur='return validationComment(event,this.id)'/></div>";
                                 childdiv+="</div>";
                                 childdiv+="<div class='centerCol' id='master' style='width:150px;'>";
                                 childdiv+="<div id='child' name='delete_"+courseId1+"_"+word[3]+"_"+i+"' style='padding-left:50px;'><a href='#' style='width:50px;' onclick='trainingHistoryPopup("+word[3]+")'><?php echo __('Training History') ?></a></div>";
                                 childdiv+="</div>";
                                 childdiv+="<div class='centerCol' id='master' style='width:100px;'>";
                                 childdiv+="<div id='child' name='delete_"+courseId1+"_"+word[3]+"_"+i+"' style='padding-left:5px;'><a href='#' style='width:50px;' onclick='deleteCRow("+i+","+word[3]+")'><?php echo __('Remove') ?></a></div>";
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
                     //ajax close to load the grid///////

                     //Ajax Start to Load the Courses//////////

                     function getCo(cid){
                         
                         $('#txtyear').val("");
                         var instiname=$('#instName').val();

                         $.post(

                         "<?php echo url_for('training/ajaxloadcourse') ?>", //Ajax file

                         { cid: cid },  // create an object will all values

                         //function that is called when server returns a value.
                         function(data){



                             var selectbox="<select name='courseid' id='courseid' class='formSelect'  onchange='getCourseId(this.value,"+instiname+")'>";
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

                     function validationComment(e,id){


                         if($('#'+id).val().length==200){
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
                     
//                     alert("<?php $lockMode ?>");
                     //--
                     var hideBtn="<?php echo $hideBtnFlag; ?>";
                   
                    if(hideBtn!=1){
 
                        $("#editBtn").hide();
                        $("#empRepPopBtn").hide();
                    }else{

                        $("#editBtn").show();
                        $("#empRepPopBtn").show();
                    }
                     //--
                             $('#frmSave :input').removeAttr('disabled');
                             "<?php //$editMode == 0  ?>";
<?php if ($editMode == true && $hideBtnFlag!=0) { ?>

    
                            
                            $('#frmSave :input').attr('disabled', true);
                            $('#editBtn').removeAttr('disabled');
                            
//                             $("#editBtn").show();
//                             buttonSecurityCommon(null,null,"editBtn",null);
//                             buttonSecurityCommonMultiple(null,null,null,"deleteLinks");
<?php } else { ?>
    
                            
//                             $("#editBtn").show();
//                             buttonSecurityCommon(null,"editBtn",null,null);

<?php } ?>


                         var cname=$('#courseid').val();


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
                                 //instName: { required: true },
                                 //courseid: { required: true },
                                 //txtyear: { required: true},
                                 gencomment_en: { noSpecialCharsOnly: true,maxlength:200 }
   
                             },
                             messages: {
                                 //instName: "<?php echo __("This Field is required") ?>",
                                 //courseid: "<?php echo __("This Field is required") ?>",
                                 //txtyear: "<?php echo __("This Field is required") ?>",
                                 gencomment_en: {noSpecialCharsOnly:"<?php echo __("No Special characters allowed") ?>",maxlength:"<?php echo __("Maximum length should be 200 characters") ?>"}
                                 
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
                                 
                                 location.href="<?php echo url_for('training/assigntrain?insid=' . $encrypt->encrypt($instituteId) . '&id=' . $encrypt->encrypt($cID) . '&hideBtnFlg=1&lock=' . $encrypt->encrypt(1)) ?>";
                             }
                             else {
//                              
                                 if($("#instName").val()==''){
                                     alert("<?php echo __('Please select an Institute Name') ?>");
                                     return false;
                                 }    
                                 if($("#courseid").val()==''){
                                     alert("<?php echo __('Please select a Training Name') ?>");
                                     return false;
                                 }    
                                 if($("#txtyear").val()==''){
                                     alert("<?php echo __('Please select a Training Calendar Year') ?>");
                                     return false;
                                 }
                                 
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
                             var cid="<?php echo $cID; ?>";
                             var instituteId="<?php echo $instituteId; ?>";
                             if(cid!="" && instituteId!=""){
                            location.href="<?php echo url_for('training/assigntrain?insid=' . $encrypt->encrypt($instituteId) . '&id=' . $encrypt->encrypt($cID) . '&hideBtnFlg=1&lock=' . $encrypt->encrypt(0)) ?>";
                             }else{
                             location.href="<?php echo url_for('training/assigntrain?insid=' . $encrypt->encrypt($instituteId) . '&id=' . $encrypt->encrypt($cID) . '&hideBtnFlg=0&lock=' . $encrypt->encrypt(0)) ?>";
                             }
                         });

                         //When Click back button
                         $("#btnBack").click(function() {
                             location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/trainsummery')) ?>";
        });



    });
    // ]]>
</script>
