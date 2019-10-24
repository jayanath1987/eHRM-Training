<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Employee Training summery") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform();">
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

                                <input type="button" class="plainbtn" id="buttonAdd"
                                       value="<?php echo __("Add") ?>" />


                            </div>
                            <div class="noresultsbar"></div>
                            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?></div>
                            <br class="clear" />
                        </div>
                        <br class="clear" />
                        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('Transfer/deleteTransfer') ?>">
                            <input type="hidden" name="mode" id="mode" value=""/>
                            <table cellpadding="0" cellspacing="0" class="data-table">
                                <thead>
                                    <tr>
                                        <td width="50">


                                        </td>



                                        <td scope="col">
                            <?php
                            if ($culture == 'en') {
                                $feild = "e.emp_display_name";
                            } else {
                                $feild = "e.emp_display_name_" . $culture;
                            }
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Employee Name'), '@newtrainingSummery', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == "en") {
                                $feild = "i.td_inst_name_en";
                            }
                            else
                                $feild="i.td_inst_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feild, __('Institute'), '@newtrainingSummery', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == "en")
                                $feildName = "c.td_course_name_en";
                            else
                                $feildName="c.td_course_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feildName, __('Course'), '@newtrainingSummery', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php echo $sorter->sortLink('t.td_asl_year', __('Training Calender year'), '@newtrainingSummery', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php echo $sorter->sortLink('t.td_asl_isattend', __('Attend to training (Yes/No)'), '@newtrainingSummery', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php echo $sorter->sortLink('t.td_asl_isapproved', __('Approved training (Yes/No)'), '@newtrainingSummery', ESC_RAW); ?>

                        </td>
                        <td scope="col">
<?php echo __('Comment') ?>

                        </td>



                    </tr>
                </thead>

                <tbody>
                    <?php
                            $row = 0;
                            foreach ($trainSummeryList as $trainlist) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                    ?><?php ?>
                                <tr class="<?php echo $cssClass ?>">

                                    <td>
                                    </td>

                                    <td class="">
                                        <a href="<?php ?>">

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

                            </a>
                        </td>
                        <td class="">
<?php $abc = "getTd_inst_name_" . $culture;
                                if ($trainlist->TrainingCourse->TrainingInstitute->$abc() == "")
                                    echo $trainlist->TrainingCourse->TrainingInstitute->getTd_inst_name_en(); else
                                    echo ($trainlist->TrainingCourse->TrainingInstitute->$abc()); ?>

                            </td>
                            <td class="">
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
                            <td class="">
<?php echo $trainlist->getTd_asl_year(); ?>
                            </td>
                            <td class="">
<?php if ($trainlist->getTd_asl_isattend() == 0)
                                    echo __("No"); else
                                    echo __("Yes"); ?>
                            </td>
                            <td class="">
                            <?php if ($trainlist->gettd_asl_ispending() == 0)
                                    echo __("No"); else
                                    echo __("Yes"); ?>
                            </td>
                            <td class="">

                            <?php
                                $dd = $trainlist->getTd_asl_comment();
                                $rest = substr($trainlist->getTd_asl_comment(), 0, 100);

                                if (strlen($dd) > 100) {
                                    echo $rest
                            ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                                } else {
                                    echo $rest;
                                }
                            ?>

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



            function confirmdelet(){
                alert("sdsd");
                return false;

            }


            $(document).ready(function() {

                //When click add button


                $("#buttonAdd").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/SaveTrainRequest')) ?>";

                });
                $("#resetBtn").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/Newregister')) ?>";

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

