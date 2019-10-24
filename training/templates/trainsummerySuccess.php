<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<?php
$encrypt = new EncryptionHandler();
?>
<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Employee Training summary") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform()">
            <input type="hidden" name="mode" value="search"/>
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>

                    <option value="ename" <?php if ($searchMode == 'ename')
            echo 'selected' ?>><?php echo __("Employee Name") ?></option>
                    <option value="institute" <?php if ($searchMode == 'institute')
                                echo 'selected' ?>><?php echo __("Institute") ?></option>
                        <option value="course" <?php if ($searchMode == 'course')
                                    echo 'selected' ?>><?php echo __("Training Name") ?></option>
                            <option value="year" <?php if ($searchMode == 'year')
                                        echo 'selected' ?>><?php echo __("Year") ?></option>
                                <option value="startDate" <?php if ($searchMode == 'startDate')
                                            echo 'selected' ?>><?php echo __("Start Date") ?></option>
                                    <option value="endDate" <?php if ($searchMode == 'endDate')
                                                echo 'selected' ?>><?php echo __("End Date") ?></option>
                                    </select>

                                    <label for="searchValue"><?php echo __("Search For") ?>:</label>
                                    <input type="text" size="20" name="searchValue" id="searchValue" value="<?php echo $searchValue ?>" />
                                    <input type="submit" class="plainbtn"
                                           value="<?php echo __("Search") ?>" />
                                    <input type="reset" class="plainbtn"
                                           value="<?php echo __("Reset") ?>" id="resetBtn" />
                                    <br class="clear"/>
                                </div>
                            </form>
                            <div class="actionbar">
                                <div class="actionbuttons">




                                    <input type="button" class="plainbtn" id="buttonRemove"
                                           value="<?php echo __("Delete") ?>" />

                                </div>
                                <div class="noresultsbar"></div>
                                <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?></div>
                                <br class="clear" />
                            </div>
                            <br class="clear" />
                            <form name="standardView" id="standardView" method="post" action="<?php echo url_for('training/Deletetrainassiged') ?>">
                                <input type="hidden" name="mode" id="mode" value=""/>
                                <table cellpadding="0" cellspacing="0" class="data-table">
                                    <thead>
                                        <tr>
                                            <td width="50">

                                                <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />

                                            </td>



                                            <td scope="col">
                            <?php
                                                if ($culture == "en") {
                                                    $feild = "e.emp_display_name";
                                                }
                                                else
                                                    $feild="e.emp_display_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Employee Name'), '@trainsummry', ESC_RAW); ?>

                                            </td>
                                            <td scope="col">
                            <?php
                                                if ($culture == "en") {
                                                    $feild = "i.td_inst_name_en";
                                                }
                                                else
                                                    $feild="i.td_inst_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Institute'), '@trainsummry', ESC_RAW); ?>

                                            </td>
                                            <td scope="col">
                            <?php
                                                if ($culture == "en") {
                                                    $feild = "c.td_course_name_en";
                                                }
                                                else
                                                    $feild="c.td_course_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Training Name'), '@trainsummry', ESC_RAW); ?>

                                            </td>
                                            <td scope="col" >

                            <?php echo $sorter->sortLink('t.td_asl_year', __('Year'), '@trainsummry', ESC_RAW); ?>

                                            </td>
                                            <td scope="col">
                            <?php echo __('Status'); //$sorter->sortLink('t.td_asl_isapproved', __('Approved (Yes/No)'), '@trainsummry', ESC_RAW); ?>

                                            </td>
                                            <td scope="col">
                            <?php echo $sorter->sortLink('c.td_course_fromdate', __('Start Date'), '@trainsummry', ESC_RAW); ?>

                                            </td>
                                            <td scope="col">
                            <?php echo $sorter->sortLink('c.td_course_todate', __('End Date'), '@trainsummry', ESC_RAW); ?>

                                            </td>
                                            <td scope="col">
                            <?php echo __('Comment') ?>

                                            </td>
                                            <td scope="col">
                            <?php echo __('Training History') ?>

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
                                                    <tr class="<?php echo $cssClass ?>">

                                                        <td>
                                                            <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $trainlist->getTd_course_id() . "_" . $trainlist->Employee->getEmpNumber() ?> ' />
                                                        </td>

                                                        <td class="">


<?php
                                                    if ($culture == 'en') {
                                                        $abc = "getEmp_display_name";
                                                    } else {
                                                        $abc = "getEmp_display_name_" . $culture;
                                                    }

                                                    $dd = $trainlist->Employee->getEmp_display_name();
                                                    $rest = substr($trainlist->Employee->getEmp_display_name(), 0, 100);
                                                    if ($trainlist->Employee->$abc() == "") {
                                                        if (strlen($dd) > 100) {
                                                            echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                                        } else {
                                                            echo $rest;
                                                        }
                                                    } else {

                                                        $dd = $trainlist->Employee->$abc();
                                                        $rest = substr($trainlist->Employee->$abc(), 0, 100);

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
                                                    $abc = "getTd_inst_name_" . $culture;
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
                                                <td class="" style="width:100px;">
<?php
                                                    $abc = "getTd_course_name_" . $culture;
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
                                                <td class="" style="width:50px;">
                            <?php echo $trainlist->getTd_asl_year(); ?>
                                                </td>
                                                <td class="" style="width:50px;"><a href="javascript:void(0);" onclick="trainingStatusPopup(<?php echo $trainlist->wfmain_id ?>)" >
                            <?php
                                                    if ($trainlist->getTd_asl_isapproved() == 0){
                                                    if($trainlist->td_asl_status== 1){
                                                        $Person="Divisional Secretary";
                                                    }elseif($trainlist->td_asl_status== 2){
                                                        $Person="District Secretary";
                                                    }elseif($trainlist->td_asl_status== 3){
                                                        $Person="HR Team";
                                                    }elseif($trainlist->td_asl_status== 4){
                                                        $Person="HR Admin";
                                                    }
                                                        echo __($Person);
                                                        echo __("- Pending");
                                                    }else if ($trainlist->getTd_asl_isapproved() == 1){
                                                        echo __("Approved");
                                                    }else if ($trainlist->getTd_asl_isapproved() == -1){
                                                    if($trainlist->td_asl_status== 1){
                                                        $Person="Divisional Secretary";
                                                    }elseif($trainlist->td_asl_status== 2){
                                                        $Person="District Secretary";
                                                    }elseif($trainlist->td_asl_status== 3){
                                                        $Person="HR Team";
                                                    }elseif($trainlist->td_asl_status== 4){
                                                        $Person="HR Admin";
                                                    }
                                                        echo __($Person);
                                                        echo __("- Rejected");    
                                                    }?>                          
                                                    </a> </td>
                                                <td class="">
                            <?php
                                                    echo LocaleUtil::getInstance()->formatDate($trainlist->TrainingCourse->getTd_course_fromdate());
                            ?>
                                                </td>
                                                <td class="">
                            <?php
                                                    echo LocaleUtil::getInstance()->formatDate($trainlist->TrainingCourse->getTd_course_todate());
                            ?>
                                                </td>

                                                <td class="">

                            <?php
                                                    $dd = $trainlist->getTd_asl_comment();
                                                    $rest = substr($trainlist->getTd_asl_comment(), 0, 100);

                                                    if (strlen($dd) > 100) {
                                                        echo $rest ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                                    } else {
                                                        echo $rest;
                                                    }
                            ?>
                                                </td>
                                                <td class="">
                                                    <a href="javascript:void(0);" onclick="trainingHistoryPopup(<?php echo $trainlist->Employee->getEmpNumber() ?>)" >
                            <?php
                                                    echo __("Training History");
                            ?></a>
                                                </td>


                                            </tr>
                                <?php } ?>

                                </tbody>
                            </table>
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
                  function trainingStatusPopup(wfId){
                        $.ajax({
                            type: "POST",
                            async:false,
                            url: "<?php echo url_for('training/AjaxEncryption') ?>",
                                        data: { empId: wfId },
                                        dataType: "json",
                                        success: function(data){wfId = data;}
                                    });
                                    window.open( "<?php echo url_for('workflow/ShowWorkflowHistory?mainId=') ?>"+wfId, "myWindow", "status = 1, height = 300, width = 825, resizable = 0" );
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
                                function validateform(){

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
                                        $("#frmSearchBox").submit();
                                    }

                                }

                                function confirmdelet(){
                                    alert("sdsd");
                                    return false;

                                }


                                $(document).ready(function() {

                                    buttonSecurityCommon(null,null,null,"buttonRemove");

                                    //When click add button
                                    $("#buttonAdd").click(function() {
                                        location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/assigntrain')) ?>";

                                    });

                                    $("#resetBtn").click(function() {
                                        location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/trainsummery')) ?>";

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
                                        if($('input[name=chkLocID[]]').is(':checked')){
                                            answer = confirm("<?php echo __("Do you really want to Delete?") ?>");
                                        }


                                        else{
                                            alert("<?php echo __("select at least one check box to delete") ?>");

            }

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

