<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Edit Admin Approved List") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return checkValue();">
            <input type="hidden" name="mode" value="search"/>
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>

                    <option value="ename" <? if ($searchMode == 'ename')
            echo 'selected' ?>><?php echo __("Employee Name") ?></option>
                    <option value="institute" <? if ($searchMode == 'institute')
                                echo 'selected' ?>><?php echo __("Institute") ?></option>
                        <option value="course" <? if ($searchMode == 'course')
                                    echo 'selected' ?>><?php echo __("Training Name") ?></option>
                            <option value="year" <? if ($searchMode == 'year')
                                        echo 'selected' ?>><?php echo __("Year") ?></option>

                            </select>

                            <label for="searchValue"><?php echo __("Search For") ?>:</label>
                            <input type="text" size="20" name="searchValue" id="searchValue" value="<?php echo $searchValue ?>" />
                            <input type="submit" class="plainbtn"
                                   value="<?php echo __("Search") ?>" />
                            <input type="reset" class="plainbtn"
                                   value="<?php echo __("Reset") ?>" />
                            <br class="clear"/>
                        </div>

                    </form>
                    <div class="actionbar">

                    </div>
                    <div class="noresultsbar"></div>
                    <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?></div>
                    <br class="clear" />
                    <br/>
                    <form name="standardView" id="standardView" method="post" action="<?php echo url_for('training/Adminapp') ?>">

                        <table cellpadding="0" cellspacing="0" class="data-table">
                            <thead>
                                <tr>


                                    <td>

                                    </td>

                                    <td scope="col">
                            <?php
                                        if ($culture == "en") {
                                            $feild = "e.emp_display_name";
                                        }
                                        else
                                            $feild="e.emp_display_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Employee Name'), '@edittrainapprove', ESC_RAW); ?>

                                    </td>
                                    <td scope="col">
                            <?php
                                        if ($culture == "en") {
                                            $feild = "i.td_inst_name_en";
                                        }
                                        else
                                            $feild="i.td_inst_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Institute'), '@edittrainapprove', ESC_RAW); ?>

                                    </td>
                                    <td scope="col">
                            <?php
                                        if ($culture == "en") {
                                            $feild = "c.td_course_name_en";
                                        }
                                        else
                                            $feild="c.td_course_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Training Name'), '@edittrainapprove', ESC_RAW); ?>

                                    </td>
                                    <td scope="col">

                            <?php echo $sorter->sortLink('t.td_asl_year', __('Training Calender year'), '@edittrainapprove', ESC_RAW); ?>

                                    </td>
                                    <td scope="col">
                            <?php echo $sorter->sortLink('t.td_asl_isapproved', __('Approved (Yes/No)'), '@edittrainapprove', ESC_RAW); ?>

                                    </td>
                                    <td scope="col">
                            <?php echo __('Comment') ?> <?php ?>

                                    </td>
                                    <td scope="col">
                            <?php echo __('Edit') ?>

                                    </td>



                                </tr>
                            </thead>

                            <tbody>
                    <?php
                                        $row = 0;
                                        foreach ($trainSummeryList as $trainlist) {
                                            $cssClass = ($row % 2) ? 'even' : 'odd';
                                            $row = $row + 1;
                    ?><?php
                    ?>
                                            <tr class="<?php echo $cssClass ?>" id="<?php echo $row; ?>">

                                                <td>

                                                </td>

                                                <td class="">

<?php
                                            if ($culture == 'en') {
                                                $abc = "getEmp_display_name";
                                            } else {
                                                $abc = "getEmp_display_name_" . $culture;
                                            }

                                            $dd = $trainlist->Employee->$abc();

                                            $rest = substr($trainlist->Employee->$abc(), 0, 100);

                                            if ($trainlist->Employee->$abc() == "") {
                                                $dd = $trainlist->Employee->getEmp_display_name();
                                                $rest = substr($trainlist->Employee->getEmp_display_name(), 0, 100);

                                                if (strlen($dd) > 100) {
                                                    echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                                } else {
                                                    echo $rest;
                                                }
                                            } else {

                                                if (strlen($dd) > 100) {
                                                    echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                                } else {
                                                    echo $rest;
                                                }
                                            }
?>

                                        </td>
                                        <td class="">
<?php
                                            if ($culture == 'en') {
                                                $abc = "getTd_inst_name_en";
                                            } else {
                                                $abc = "getTd_inst_name_" . $culture;
                                            }


                                            $dd = $trainlist->TrainingCourse->TrainingInstitute->$abc();
                                            $rest = substr($trainlist->TrainingCourse->TrainingInstitute->$abc(), 0, 100);
                                            if ($trainlist->TrainingCourse->TrainingInstitute->$abc() == "") {

                                                $dd = $trainlist->TrainingCourse->TrainingInstitute->getTd_inst_name_en();
                                                $rest = substr($trainlist->TrainingCourse->TrainingInstitute->getTd_inst_name_en(), 0, 100);
                                                if (strlen($dd) > 100) {
                                                    echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                                } else {
                                                    echo $rest;
                                                }
                                            } else {

                                                if (strlen($dd) > 100) {
                                                    echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                                } else {
                                                    echo $rest;
                                                }
                                            }
?>

                                        </td>
                                        <td class="">
<?php
                                            if ($culture == 'en') {
                                                $abc = "getTd_course_name_en";
                                            } else {
                                                $abc = "getTd_course_name_" . $culture;
                                            }

                                            $dd = $trainlist->TrainingCourse->$abc();
                                            $rest = substr($trainlist->TrainingCourse->$abc(), 0, 100);
                                            if ($trainlist->TrainingCourse->$abc() == "") {

                                                $dd = $trainlist->TrainingCourse->getTd_course_name_en();
                                                $rest = substr($trainlist->TrainingCourse->getTd_course_name_en(), 0, 100);
                                                if (strlen($dd) > 100) {
                                                    echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                                } else {
                                                    echo $rest;
                                                }
                                            } else {

                                                if (strlen($dd) > 100) {
                                                    echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                                } else {
                                                    echo $rest;
                                                }
                                            }
?>
                                        </td>
                                        <td class="">
                            <?php echo $trainlist->getTd_asl_year(); ?>
                                        </td>
                                        <td class="">
                            <?php
                                            if ($trainlist->getTd_asl_isapproved() == "1") {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                            ?>

                                            <select id='parti11_<?php echo $row ?>' name='isappr_<?php echo $trainlist->Employee->getEmp_number() . "_" . $trainlist->TrainingCourse->getTd_course_id() ?>' style='width:50px;'><option value="-1" <?php echo $selected ?>><?php echo __('No') ?></option><option value="1" <?php echo $selected ?>><?php echo __('Yes') ?></option></select>
                                        </td>
                                        <td class="">
<?php
                                            $dd = $trainlist->getTd_asl_comment();
                                            $rest = substr($trainlist->getTd_asl_comment(), 0, 100);

                                            if (strlen($dd) > 100) {
                                                echo $rest; ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                            } else {
                                                echo $rest;
                                            }
?>
                                        </td>
                                        <td class="">
                                            <input type="button" class="plainbtn editBtn" id="editBtn_<?php echo $row ?>"  value="<?php echo __("Edit") ?>"  onclick='save1(this.id,$("#parti11_<?php echo $row ?>").val(),<?php echo $trainlist->Employee->getEmpNumber() ?>,<?php echo $trainlist->TrainingCourse->getTd_course_id() ?>,<?php echo $row ?>)' />

                                        </td>

                                    </tr>
<?php } ?>

                            </tbody>
                        </table>
                        <br class="clear" />
                        <div class="actionbuttons">





                        </div>
                        <br/>
                    </form>
                </div>
            </div>

            <script type="text/javascript">
                function disableAnchor(obj, disable){
                    if(disable){
                        var href = obj.getAttribute("href");
                        if(href && href != "" && href != null){
                            obj.setAttribute('href_bak', href);
                        }
                        obj.removeAttribute('href');
                        obj.style.color="gray";
                    }
                    else{
                        obj.setAttribute('href', obj.attributes
                        ['href_bak'].nodeValue);
                        obj.style.color="blue";
                    }
                }
                function checkValue(){
                    if($("#searchValue").val()=="")
                    {

                        alert("<?php echo __('Please enter search value') ?>");
                                return false;

                            }
                            if($("#searchMode").val()=="all"){
                                alert("<?php echo __('Please select the search mode') ?>");
                                return false;
                            }
                            else{
                                $("#standardView").submit();
                            }

                        }




                        mode='edit';

                        $('#standardView :input').attr('disabled', true);
                        $('#standardView :button').removeAttr('disabled');
                        function save1(id,value,empId,cId,row){

                            $('#standardView :input').attr('disabled', true);

                            $('#'+id).removeAttr('disabled');
                            $('#parti11_'+row).removeAttr('disabled');


                            if(mode=='edit'){


                                $.post(

                                "<?php echo url_for('training/ajaxTableLock') ?>", //Ajax file

                                { lock : 1 , empId : empId,cId:cId },  // create an object will all values

                                //function that is called when server returns a value.
                                function(data){


                                    if(data.lockMode==0){
                                        alert("<?php echo __("Can not Update Record Lock") ?>");
                                        $('#standardView :button').removeAttr('disabled');
                                        $('#parti11_'+row).attr('disabled', true);
                                    }
                                    else{
                                        mode='save';
                                        $('#'+id).attr('value', '<?php echo __("Save") ?>');

                                    }

                                },


                                "json"

                            );


                            }
                            else{
                                //alert('save');
                                $.post(
                                "<?php echo url_for('training/SaveAdminApp') ?>", //Ajax file

                                { lock : 0,empId : empId , cId : cId , value : value },  // create an object will all values

                                //function that is called when server returns a value.
                                function(data){


                                    if(data.isupdated=="true"){

                                        mode='edit';
                                        $('#'+id).attr('value', '<?php echo __("Edit") ?>');
                                        alert("<?php echo __("Successfully Updated") ?>");
                                        $('#standardView :button').removeAttr('disabled');
                                        $('#parti11_'+row).attr('disabled', true);
                                        $.post(

                                        "<?php echo url_for('training/ajaxTableLock') ?>", //Ajax file

                                        { lock : 0 , empId : empId,cId:cId },  // create an object will all values

                                        //function that is called when server returns a value.
                                        function(data){


                                            if(data.lockMode==0){
                                                mode='edit';
                                            }
                                            else{
                                                mode='edit';
                                                $('#'+id).attr('value', '<?php echo __("Save") ?>');

                                            }

                                        },


                                        "json"

                                    );




                                    }
                                    else{
                                        alert("<?php echo __("Error") ?>");
                                    }

                                },


                                "json"

                            );




                            }




                        }
















                        $(document).ready(function() {

                            buttonSecurityCommonMultiple(null,null,"editBtn",null);
                            //var mode	=	'edit';
                            //When click add button
                            $("#buttonAdd").click(function() {
                                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/assigntrain')) ?>";

                            });




                            // When Click Main Tick box
                            $("#allCheck").click(function() {
                                if ($('#allCheck').attr('checked')){

                                    $('.innercheckbox').attr('checked','checked');
                                }else{
                                    $('.innercheckbox').removeAttr('checked');
                                }
                            });

                            $(".innercheckbox").click(function() {
                                if($(this).attr('checked'))
                                {

                                }else
                                {
                                    $('#allCheck').removeAttr('checked');
                                }
                            });



                            //When click remove button

                            $("#buttonRemove").click(function() {
                                $("#mode").attr('value', 'delete');
                                answer = confirm("<?php echo __("Do you really want to Delete?") ?>");

            if (answer !=0)
            {

                $("#standardView").submit();

            }
            else{
                return false;
            }

        });

        //When click Save Button
        $("#buttonRemove").click(function() {
            $("#mode").attr('value', 'save');
            
        });



    });


</script>

