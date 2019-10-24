<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">
        <input type="button" class="backbutton" id="btnBack"
               value="<?php echo __("Back") ?>" tabindex="10" />
               <?php echo message() ?>
    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Update Assigned  Training") ?></h2></div>
        <form name="frmSave" id="frmSave" method="post"  action="">


            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Institute") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <select name="instName" id="instName" class="formSelect" style="width: 150px;" tabindex="4" onchange="getCo(this.value);">

                    <option value=""><?php echo __("--Select--") ?></option>
                    <?php foreach ($instList as $list) {
                    ?>
                        <option value="<?php echo $list->getTd_inst_id() ?>"><?php
                        $abc = "getTd_inst_name_" . $culture;
                        if ($list->$abc() == "")
                            echo $list->getTd_inst_name_en(); else
                            echo $list->$abc(); ?></option>
<?php } ?>

                </select>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Year") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">

                <input id="txten"  name="txtyear" type="text"  class="formInputText" value="" tabindex="1" maxlength="4"/>


            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Training Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol" id="courselist">
                <select name="instName" id="instName" class="formSelect" style="width: 150px;" tabindex="4" onchange="">

                    <option value=""><?php echo __("--Select--") ?></option>


                </select>

            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Employee List") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol" id="courselist" style="width:150px;">
                <div id="master">


                </div>
            </div>
            <div class="centerCol" id="courselist" style="width:100px;">
                <div id="test">

                </div>
            </div>
            <div class="centerCol" id="courselist" style="width:100px;">
                <div id="partimaster">

                </div>
            </div>
            <div class="centerCol" id="courselist" style="width:100px;">
                <div id="approveMaster">

                </div>
            </div>
            <div class="centerCol" id="courselist" style="width:150px;">
                <div id="commentmaster">

                </div>
            </div>
            <div class="centerCol" id="courselist" style="width:100px;">
                <div id="deletetmaster">

                </div>
            </div>

            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Comment") ?> </label>
            </div>
            <div class="centerCol" id="courselist" style="width:100px;">
                <textarea name="genaralcomment" id="gencomment">

                </textarea>
            </div>
            <br class="clear"/>
            <div class="formbuttons">

                <input type="hidden" name="hiddeni" id="hiddeni" value="0"/>
                <input type="button" class="savebutton" id="editBtn"

                       value="<?php echo __("Edit") ?>" tabindex="8" />
                <input type="button" class="clearbutton"  id="resetBtn"
                       value="<?php echo __("Reset") ?>" tabindex="9" />
                <input type="button" class="savebutton" id="addemp" value="<?php echo __("Add Employee") ?>" tabindex="8" onclick="addtoGrid()" />
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">
    //ajax start to load to the grid ///
    var courseId="";
    var empIDMaster

    function getCourseId(id){

        courseId=id;

        $.post(

        "<?php echo url_for('training/checkcourse') ?>", //Ajax file

        { id: id },  // create an object will all values

        //function that is called when server returns a value.
        function(data){

            if(data.isCo=="yes"){
                window.location = "<?php echo url_for('training/UpdateAssigntrain?id=') ?>"+id;
            }
            else{
                window.location = "<?php echo url_for('training/assigntrain') ?>";
            }



        },

        //How you want the data formated when it is returned from the server.
        "json"

    );


    }
    function addtoGrid(empid){



        var myArray2= new Array();

        myArray2[0] = 8;
        myArray2[1] = 6;
        myArray2[2] = 5;


        $.post(

        "<?php echo url_for('training/LoadGrid') ?>", //Ajax file



        { 'empid[]' : myArray2 },  // create an object will all values

        //function that is c    alled when server returns a value.
        function(data){


            //var childDiv;
            var childDiv="";
            var testDiv="";
            var participated="";
            var testDiv="";
            var approved="";
            var comment="";
            var delete1="";


            $.each(data, function(key, value) {
                i=Number($('#hiddeni').val())+1;


                childDiv="<div id='child' style='height:25px;'>"+key+"</div>";
                testDiv="<div id='child' style='height:25px;'>"+value+"</div>";
                participated="<div id='child' style='height:25px;'><select id='parti' name='parti_"+courseId+"_"+value+"_"+i+"' style='width:50px;'><option id='1'>Yes</option><option id='0'>No</option></select></div>";
                approved="<div id='child' style='height:25px;'><select id='parti' name='appro_"+courseId+"_"+value+"_"+i+"' style='width:50px;'><option id='1'>Yes</option><option id='0'>No</option></select></div>";
                comment="<div id='child' style='height:25px;'><input type='text' name='commentgrid_"+courseId+"_"+value+"_"+i+"' style='width:125px;'/></div>";
                delete1="<div id='child' style='height:25px;'><a href='#' style='width:50px;'>Delete</a></div>";
                $('#master').append(childDiv);
                $('#test').append(testDiv);
                $('#partimaster').append(participated);
                $('#approveMaster').append(approved);
                $('#commentmaster').append(comment);
                $('#deletetmaster').append(delete1);
                $('#hiddeni').val(i);

            });



        },

        //How you want the data formated when it is returned from the server.
        "json"

    );


    }

    //ajax close to load the grid///////

    //Ajax Start to Load the Courses//////////

    function getCo(cid){

        // post(file, data, callback, type); (only "file" is required)
        $.post(

        "<?php echo url_for('training/ajaxloadcourse') ?>", //Ajax file

        { cid: cid },  // create an object will all values

        //function that is called when server returns a value.
        function(data){



            var selectbox="<select name='courseid' id='courseid' class='formSelect' style='width: 150px;' tabindex='4' onchange='getCourseId(this.value)'>";
            selectbox=selectbox +"<option value='-1'><?php echo __('--Select--') ?></option>";
            $.each(data, function(key, value) {

                selectbox=selectbox +"<option value="+key+">"+value+"</option>";
            });
            selectbox=selectbox +"</select>";
            $('#courselist').html(selectbox);


            //$("#datehiddne1").val(data.message);
        },

        //How you want the data formated when it is returned from the server.
        "json"

    );


    }



    //Ajax End to Load Courses//


    $(document).ready(function() {

        //Validate the form
        $("#frmSave").validate({

            rules: {
                txten: { required: true }

            },
            messages: {
                txten: "<?php echo __("Institute name is required") ?>"

            },
            submitHandler: function(form) {
                $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                form.submit();
            }
        });

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
                $('#frmSave').submit();

            }
        });

        //When click reset buton
        $("#resetBtn").click(function() {
            document.forms[0].reset('');
        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/admin/listJobTitle')) ?>";
        });

    });
</script>
<? ?>