<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>
<?php
$encrypt = new EncryptionHandler();
?>
<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Training Plan") ?></h2></div>
        <?php echo message(); ?>

        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform()">
            <input type="hidden" name="mode" value="search"/>
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>


                    <option value="month" <?php
        if ($searchMode == 'month') {
            echo "selected";
        } ?>>
                                <?php echo __("Month") ?>
                    </option>
                    <option value="name" <?php
                                if ($searchMode == 'name') {
                                    echo "selected";
                                } ?>>
                                <?php echo __("Training Name") ?>
                    </option>
                    <option value="institute" <?php
                                if ($searchMode == 'institute') {
                                    echo "selected";
                                } ?>>
                                <?php echo __("Institute") ?>
                    </option>


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

                <input type="button" class="plainbtn" id="buttonAdd"
                       value="<?php echo __("Add") ?>" />


                <input type="button" class="plainbtn" id="buttonRemove"
                       value="<?php echo __("Delete") ?>" />

            </div>
            <div class="noresultsbar"></div>
            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?></div>
            <br class="clear" />
        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('training/DeleteTrainingPlan') ?>">
            <input type="hidden" name="mode" id="mode" value="">
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">

                            <input type="checkbox" class="checkbox" name="allCheck" value="" id="allCheck" />

                        </td>


                        <td scope="col">

                            <?php echo $sorter->sortLink('t.td_plan_month', __('Month'), '@planList', ESC_RAW); ?>



                            </td>

                            <td scope="col">
                            <?php
                                if ($culture == "en") {
                                    $feild = "i.td_inst_name_en";
                                } else {
                                    $feild = "i.td_inst_name_" . $culture;
                                }
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Institute Name'), '@planList', ESC_RAW); ?>



                            </td>
                            <td scope="col">
                            <?php
                                if ($culture == "en") {
                                    $feild = "c.td_course_name_en";
                                } else {
                                    $feild = "c.td_course_name_" . $culture;
                                }
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Training Name'), '@planList', ESC_RAW); ?>



                            </td>
                            <td scope="col">

                            <?php echo $sorter->sortLink('t.td_plan_training_summery', __('Training Summary'), '@planList', ESC_RAW); ?>



                            </td>
                            <td scope="col">

                            <?php echo $sorter->sortLink('t.td_plan_training_frowhom', __('For whom'), '@planList', ESC_RAW); ?>



                            </td>

                        </tr>
                    </thead>

                    <tbody>
                    <?php
                                $row = 0;

                                foreach ($listMonth as $lists) {

                                    $cssClass = ($row % 2) ? 'even' : 'odd';
                                    $row = $row + 1;
                    ?>
                                    <tr class="<?php echo $cssClass ?>">
                                        <td>
                                            <input type='checkbox' class='checkbox innercheckbox' name='chkLocID[]' id="chkLoc" value='<?php echo $lists->td_plan_id ?>' />
                                        </td>

                                        <td class="">
                                            <a href="<?php echo url_for('training/TraininPlan?id=' . $encrypt->encrypt($lists->td_plan_id)) ?>">
                                <?php
                                    echo $lists->td_plan_month;
                                ?>
                                </a>
                            </td>
                            <td>

                                <a href="<?php echo url_for('training/TraininPlan?id=' . $encrypt->encrypt($lists->td_plan_id)) ?>">
<?php
                                    if ($culture == "en") {
                                        echo $lists->TrainingInstitute->td_inst_name_en;
                                    } else {
                                        $abc = "td_inst_name_" . $culture;
                                        if ($lists->TrainingInstitute->$abc == "") {
                                            echo $lists->TrainingInstitute->td_inst_name_en;
                                        } else {
                                            echo $lists->TrainingInstitute->$abc;
                                        }
                                    }
?>
                                </a>

                            </td>
                            <td>

                                <a href="<?php echo url_for('training/TraininPlan?id=' . $encrypt->encrypt($lists->td_plan_id)) ?>">
<?php
                                    if ($culture == "en") {
                                        echo $lists->TrainingCourse->getTd_course_name_en();
                                    } else {
                                        $abc = "getTd_course_name_" . $culture;
                                        if ($lists->TrainingCourse->$abc() == "") {
                                            echo $lists->TrainingCourse->getTd_course_name_en();
                                        } else {
                                            echo $lists->TrainingCourse->$abc();
                                        }
                                    }
?>
                                </a>

                            </td>
                            <td>

                                <a href="<?php echo url_for('training/TraininPlan?id=' . $encrypt->encrypt($lists->td_plan_id)) ?>">
                                <?php
                                    echo $lists->td_plan_training_summery;
                                ?>
                                </a>

                            </td>
                            <td>

                                <a href="<?php echo url_for('training/TraininPlan?id=' . $encrypt->encrypt($lists->td_plan_id)) ?>">
                                <?php
                                    echo $lists->td_plan_training_frowhom;
                                ?>
                                </a>

                            </td>


                        </tr>
<?php } ?>
                </tbody>
            </table>
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

                $(document).ready(function() {


                    buttonSecurityCommon("buttonAdd",null,null,"buttonRemove");

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

                    //When click add button
                    $("#buttonAdd").click(function() {
                        location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/TraininPlan')) ?>";

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

                    $("#resetBtn").click(function() {
                        document.forms[0].reset('');
                        location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/TrainingPlanList')) ?>";
        });






    });


</script>


