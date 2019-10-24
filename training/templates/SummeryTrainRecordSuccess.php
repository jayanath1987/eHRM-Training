<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Training Record Summary") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform()">
            <input type="hidden" name="mode" value="search">
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
                <?php if ($userType == "Ess") {
 ?>
                                            <input type="button" class="plainbtn" id="buttonAdd"
                                                   value="<?php echo __("Add") ?>" />
<?php } ?>

                                 <input type="button" class="plainbtn" id="buttonRemove"
                                        value="<?php echo __("Delete") ?>" />

                             </div>
                             <div class="noresultsbar"></div>
                             <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?></div>
                             <br class="clear" />
                         </div>
                         <br class="clear" />
                         <form name="standardView" id="standardView" method="post" action="<?php echo url_for('training/DeleteTrainRecord?userType=' . $userType) ?>">

                             <table cellpadding="0" cellspacing="0" class="data-table">
                                 <thead>
                                     <tr>


                                         <td width="50">
                            <?php
                                        foreach ($trainSummeryList as $trainlist) {
                                            if ($trainlist->getTd_asl_isadcommented() == 1 && $userType != 'Admin') {
                                                $i = 1;
                                            }
                                        }
                            ?>
                                        <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" <?php if ($i == 1
                                            )echo "disabled" ?>/>

                                        </td>


                                        <td scope="col">
                            <?php
                                            if ($culture == "en") {
                                                $feild = "e.emp_display_name";
                                            }
                                            else
                                                $feild="e.emp_display_name_" . $culture;
                            ?>
<?php echo $sorter->sortLink($feild, __('Employee Name'), '@trainRecordSummery', '', 'user=' . $userType, ESC_RAW); ?>

                                        </td>
                                        <td scope="col">
                            <?php
                                            if ($culture == "en") {
                                                $feild = "i.td_inst_name_en";
                                            }
                                            else
                                                $feild="i.td_inst_name_" . $culture;
                            ?>
<?php echo $sorter->sortLink($feild, __('Institute'), '@trainRecordSummery', '', 'user=' . $userType, ESC_RAW); ?>

                                        </td>
                                        <td scope="col">
                            <?php
                                            if ($culture == "en") {
                                                $feild = "c.td_course_name_en";
                                            }
                                            else
                                                $feild="c.td_course_name_" . $culture;
                            ?>
<?php echo $sorter->sortLink($feild, __('Training Name'), '@trainRecordSummery', '', 'user=' . $userType, ESC_RAW); ?>

                                        </td>
                                        <td scope="col">

<?php echo $sorter->sortLink('t.td_asl_year', __('Training Calender year'), '@trainRecordSummery', '', 'user=' . $userType, ESC_RAW); ?>

                                        </td>
                                        <td scope="col">
<?php echo __('Effectiveness') ?>

                                        </td>
                                        <td scope="col">
<?php echo __('Admin Remarks') ?>

                                        </td>



                                    </tr>
                                </thead>

                                <tbody>
                    <?php
                                            $encryptObj = new EncryptionHandler();
                                            $row = 0;
                                            foreach ($trainSummeryList as $trainlist) {
                                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                                $row = $row + 1;
                    ?><?php ?>
                                                <tr class="<?php echo $cssClass ?>">

                                                    <td >
                                                        <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $trainlist->getTd_course_id() . "_" . $trainlist->Employee->getEmp_number() ?>' <?php if ($trainlist->getTd_asl_isadcommented() == 1 && $userType != 'Admin')
                                                    echo "disabled" ?>/>
                                                        </td>

                                                        <td class="">
                                                            <a href="<?php echo url_for('training/UpdateTrainRecord?empid=' . $encryptObj->encrypt($trainlist->Employee->getEmp_number()) . '&corsid=' . $encryptObj->encrypt($trainlist->getTd_course_id()) . '&mode=edit&userType=' . $userType) ?>">

                                <?php
                                                    if ($culture == 'en') {
                                                        $abc = "getEmp_display_name";
                                                    } else {
                                                        $abc = "getEmp_display_name_" . $culture;
                                                    }
                                                    if ($trainlist->Employee->$abc() == "") {
                                                        echo $trainlist->Employee->getEmp_display_name();
                                                    } else {
                                                        echo $trainlist->Employee->$abc();
                                                    }
                                ?>
                                                </a>
                                            </td>
                                            <td class="">
                            <?php
                                                    $abc = "getTd_inst_name_" . $culture;
                                                    if ($trainlist->TrainingCourse->TrainingInstitute->$abc() == "")
                                                        echo $trainlist->TrainingCourse->TrainingInstitute->getTd_inst_name_en(); else
                                                        echo ($trainlist->TrainingCourse->TrainingInstitute->$abc());
                            ?>

                                                </td>
                                                <td class="">
                            <?php
                                                    $abc = "getTd_course_name_" . $culture;
                                                    if ($trainlist->TrainingCourse->$abc() == "")
                                                        echo $trainlist->TrainingCourse->getTd_course_name_en(); else
                                                        echo $trainlist->TrainingCourse->$abc();
                            ?>
                                                </td>
                                                <td class="">
<?php echo $trainlist->getTd_asl_year(); ?>
                                                </td>
                                                <td class="">
<?php echo $trainlist->getTd_asl_effectiveness(); ?>
                                                </td>
                                                <td class="">
                    <?php echo $trainlist->getTd_asl_adminremarks(); ?>
                                                        </td>


                                                    </tr>
<?php } ?>

                                            </tbody>
                                        </table>
                                        <br class="clear" />


                                        <br class="clear" />
                                    </form>
                                </div>
                            </div>

                            <script type="text/javascript">

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



<?php if ($userType == "Ess") { ?>
                                                $("buttonRemove").show();
                                                buttonSecurityCommon("buttonAdd",null,null,"buttonRemove");

<?php } else { ?>
                                                $("buttonRemove").show();
                                                buttonSecurityCommon(null,null,null,"buttonRemove");
<?php } ?>

                                            //When click add button
                                            $("#buttonAdd").click(function() {
                                                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/NewEmpTrainRecord?user=')) . $userType ?>";

                                            });

                                            //When click resetBtn button
                                            $("#resetBtn").click(function() {
                                                location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/SummeryTrainRecord?user=')) . $userType ?>";

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
                                                    alert("<?php echo __("Select at least one check box to delete") ?>");

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

