<?php $encrypt = new EncryptionHandler(); ?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Employee Training History Summary") ?></h2></div>
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




                        <td scope="col">
                            <?php
                            if ($culture == "en") {
                                $feild = "e.emp_display_name";
                            }
                            else
                                $feild="e.emp_display_name_" . $culture;
                            ?>
                            <?php echo __('Employee Name')//echo $sorter->sortLink($feild, __('Employee Name'), '@trainsummryHistory', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == "en") {
                                $feild = "i.td_inst_name_en";
                            }
                            else
                                $feild="i.td_inst_name_" . $culture;
                            ?>
                            <?php echo __('Institute')//echo $sorter->sortLink($feild, __('Institute'), '@trainsummryHistory', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == "en") {
                                $feild = "c.td_course_name_en";
                            }
                            else
                                $feild="c.td_course_name_" . $culture;
                            ?>
                            <?php echo __('Training Name')//echo $sorter->sortLink($feild, __('Training Name'), '@trainsummryHistory', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php echo __('Year') ?>
                            <?php //echo $sorter->sortLink('t.td_asl_year', __('Training Calender year'), '@trainsummryHistory', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php echo __('Approved (Yes/No)') //echo $sorter->sortLink('t.td_asl_isattend', __('Attend to training (Yes/No/Reject)'), '@trainsummryHistory', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php echo __('Participated (Yes/No)') //echo $sorter->sortLink('t.td_asl_isattend', __('Attend to training (Yes/No/Reject)'), '@trainsummryHistory', ESC_RAW); ?>

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
                        ?><?php
                        ?>
                        <tr class="<?php echo $cssClass ?>">



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
                                        echo $rest
                                        ?>.<span title="<?php echo $dd ?>">...</span> <?php
                        } else {
                            echo $rest;
                        }
                    } else {


                        if (strlen($dd) > 100) {
                            echo $rest
                                        ?>.<span  title="<?php echo $dd ?>">...</span> <?php
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
                                        echo $rest
                                        ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
                        } else {
                            echo $rest;
                        }
                    } else {

                        if (strlen($dd) > 100) {
                            echo $rest
                                        ?>.<a href="" title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</a> <?php
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
                                        echo $rest
                                        ?>.<span  title="<?php echo $dd ?>">...</span> <?php
                        } else {
                            echo $rest;
                        }
                    } else {

                        if (strlen($dd) > 100) {
                            echo $rest
                                        ?>.<span title="<?php echo $dd ?>" onclick="javascript:disableAnchor(this, true)">...</span> <?php
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
                                if ($trainlist->td_asl_isapproved == 1){
                                    echo __("Yes");
                                }else if ($trainlist->td_asl_isapproved == -1){
                                    echo __("Reject");
                                }else if ($trainlist->td_asl_status < 5){
                                    echo __("Pending");
                                }
                                ?>
                            </td>
                            <td class="">
                                <?php
                                if ($trainlist->td_asl_isattend == 0)
                                    echo __("No");
                                else 
                                    echo __("Yes");

                                
                                ?>
                            </td>
                            <td class="">

                                <?php
                                $dd = $trainlist->WfMain->wfmain_comments;
                                $rest = substr($trainlist->WfMain->wfmain_comments, 0, 100);

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
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/trainingHistory')) ?>";

        });

        $("#resetBtn").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/trainingHistory?empId=')) ?>"+"<?php echo $encrypt->encrypt($emp); ?>";

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

