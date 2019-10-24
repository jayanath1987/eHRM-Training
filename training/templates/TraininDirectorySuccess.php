<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.autocomplete.js') ?>"></script>

<div class="outerbox">
    <div class="maincontent">

        <div class="mainHeading"><h2><?php echo __("Training List") ?></h2></div>
        <?php echo message() ?>
        <form name="frmSearchBox" id="frmSearchBox" method="post" action="" onsubmit="return validateform()">
            <input type="hidden" name="mode" value="search">
            <div class="searchbox">
                <label for="searchMode"><?php echo __("Search By") ?></label>


                <select name="searchMode" id="searchMode">
                    <option value="all"><?php echo __("--Select--") ?></option>


                    <option value="name" <?php
        if ($searchMode == 'name') {
            echo "selected";
        }
        ?>><?php echo __("Training Name") ?></option>
                    <option value="institute" <?php
                            if ($searchMode == 'institute') {
                                echo "selected";
                            } ?>><?php echo __("Institute") ?></option>
                    <option value="year" <?php
                            if ($searchMode == 'year') {
                                echo "selected";
                            }
        ?>><?php echo __("Year") ?></option>
                    <option value="Venue" <?php
                            if ($searchMode == 'Venue') {
                                echo "selected";
                            }
        ?>><?php echo __("Venue") ?></option>

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

            <div class="noresultsbar"></div>
            <div class="pagingbar"><?php echo is_object($pglay) ? $pglay->display() : ''; ?></div>

        </div>
        <br class="clear" />
        <form name="standardView" id="standardView" method="post" action="<?php echo url_for('training/DeleteCourse') ?>">
            <input type="hidden" name="mode" id="mode" value="">
            <table cellpadding="0" cellspacing="0" class="data-table">
                <thead>
                    <tr>
                        <td width="50">



                        </td>


                        <td scope="col">
                            <?php
                            if ($culture == "en")
                                $feildName = "t.td_course_name_en";
                            else
                                $feildName="t.td_course_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feildName, __('Training Name'), '@trainDirectory', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == "en")
                                $feildName = "i.td_inst_name_en";
                            else
                                $feildName="i.td_inst_name_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feildName, __('Institute'), '@trainDirectory', ESC_RAW); ?>

                        </td>
                        <td scope="col">


                            <?php echo $sorter->sortLink('t.td_course_year', __('Year'), '@trainDirectory', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php
                            if ($culture == "en")
                                $feildName = "t.td_course_venue_en";
                            else
                                $feildName="t.td_course_venue_" . $culture;
                            ?>
                            <?php echo $sorter->sortLink($feildName, __('Venue'), '@trainDirectory', ESC_RAW); ?>

                        </td>
                        <td scope="col">
                            <?php echo __('Apply') ?>

                        </td>

                    </tr>
                </thead>

                <tbody>
                    <?php
                            $row = 0;
                            foreach ($listCourse as $lc) {
                                $cssClass = ($row % 2) ? 'even' : 'odd';
                                $row = $row + 1;
                    ?>
                                <tr class="<?php echo $cssClass ?>">
                                    <td>

                                    </td>

                                    <td class="">

                            <?php
                                $abc = "getTd_course_name_" . $culture;
                                if ($lc->$abc() == "") {
                                    echo $lc->getTd_course_name_en();
                                } else {
                                    echo $lc->$abc();
                                }
                            ?>
                            </td>
                            <td class="">

                            <?php
                                $abc = "getTd_inst_name_" . $culture;
                                if ($lc->TrainingInstitute->$abc() == "") {
                                    echo $lc->TrainingInstitute->getTd_inst_name_en();
                                } else {
                                    echo $lc->TrainingInstitute->$abc();
                                }
                            ?>
                            </td>
                            <td class="">
                            <?php echo $lc->getTd_course_year(); ?>
                            </td>
                            <td class="">

                            <?php
                                $abc = "getTd_course_venue_" . $culture;
                                if ($lc->$abc() == "") {
                                    echo $lc->getTd_course_venue_en();
                                } else {
                                    echo $lc->$abc();
                                }
                            ?>
                            </td>

                            <td class="">
                                <input type="button" class="plainbtn editbtnclass" value="<?php echo __('Apply') ?> " onclick="loadwindow(<?php echo $lc->TrainingInstitute->getTd_inst_id() ?>,<?php echo $lc->getTd_course_id() ?>);"/>

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

            function loadwindow(insid,cid){


                window.location = "<?php echo url_for('training/SaveTrainRequest?insid=') ?>"+insid+"?cid1="+cid;

            }

            $(document).ready(function() {


                buttonSecurityCommonMultiple(null,null,"editbtnclass",null);

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
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/SaveCourse')) ?>";

                });

                //When click resetBtn button
                $("#resetBtn").click(function() {
                    location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/TraininDirectory')) ?>";

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





    });


</script>

