<?php
if ($lockMode == '1') {
    $editMode = false;
    $disabled = '';
} else {
    $editMode = true;
    $disabled = 'disabled="disabled"';
}
$encrypt = new EncryptionHandler();
?>
<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("Update Institute Name") ?></h2></div>
   <?php echo message() ?>
        <form name="frmSave" id="frmSave" method="post"  action="">
            <div class="leftCol">
                &nbsp;
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("English") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Sinhala") ?></label>
            </div>
            <div class="centerCol">
                <label class="languageBar"><?php echo __("Tamil") ?></label>
            </div>
            <br class="clear"/>
            <div class="leftCol">
                <label class="controlLabel" for="txtLocationCode"><?php echo __("Institute Name") ?> <span class="required">*</span></label>
            </div>
            <div class="centerCol">
                <input id="txten"  name="txten" type="text"  class="formInputText" value="<?php echo $transIns->getTd_inst_name_en() ?>" tabindex="1" maxlength="75" <?php echo $disabled ?> />
            </div>
            <div class="centerCol">
                <input id="txtsi"  name="txtsi" type="text"  class="formInputText" value="<?php echo $transIns->getTd_inst_name_si() ?>" tabindex="1" maxlength="75" <?php echo $disabled ?>/>
            </div>
            <div class="centerCol">
                <input id="txtta"  name="txtta" type="text"  class="formInputText" value="<?php echo $transIns->getTd_inst_name_ta() ?>" tabindex="1" maxlength="75" <?php echo $disabled ?>/>
            </div>
            <br class="clear"/>

        </form>



        <div class="formbuttons">
            <input type="button" class="<?php echo $editMode ? 'editbutton' : 'savebutton'; ?>" name="EditMain" id="editBtn"
                   value="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   title="<?php echo $editMode ? __("Edit") : __("Save"); ?>"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"/>
            <input type="reset" class="clearbutton" id="btnClear" tabindex="5"
                   onmouseover="moverButton(this);" onmouseout="moutButton(this);"	<?php echo $disabled; ?>
                   value="<?php echo __("Reset"); ?>" />
            <input type="button" class="backbutton" id="btnBack"
                   value="<?php echo __("Back") ?>" tabindex="18"  onclick="goBack();"/>
        </div>

    </div>

</div>
<div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<script type="text/javascript">




    $(document).ready(function() {


        buttonSecurityCommon(null,null,"editBtn",null);
        // When click edit button
        $("#frmSave").data('edit', <?php echo $editMode ? '1' : '0' ?>);

        $("#editBtn").click(function() {

            var editMode = $("#frmSave").data('edit');
            if (editMode == 1) {
                // Set lock = 1 when requesting a table lock

                location.href="<?php echo url_for('training/Updateinstitute?id=' . $encrypt->encrypt($transIns->getTd_inst_id()) . '&lock=' . $encrypt->encrypt(1)) ?>";
            }
            else {

                $('#frmSave').submit();
            }


        });
                    



        //Disable all fields



        //Validate the form
        $("#frmSave").validate({

            rules: {

                txten: { required: true,maxlength: 75,noSpecialCharsOnly: true },
                txtsi: { maxlength: 75,noSpecialCharsOnly: true },
                txtta: { maxlength: 75,noSpecialCharsOnly: true }

            },
            messages: {
                txten:{required:"<?php echo __('This field is required') ?>",maxlength: "<?php echo __('Maximum length should be 75 characters') ?>",noSpecialCharsOnly: "<?php echo __('No invalid characters are allowed') ?>"},
                txtsi:{maxlength: "<?php echo __('Maximum length should be 75 characters') ?>",noSpecialCharsOnly: "<?php echo __('No invalid characters are allowed') ?>"},
                txtta:{maxlength: "<?php echo __('Maximum length should be 75 characters') ?>",noSpecialCharsOnly: "<?php echo __('No invalid characters are allowed') ?>"}

            },
            submitHandler: function(form) {
                $('#editBtn').unbind('click').click(function() {return false}).val("<?php echo __('Wait..'); ?>");
                form.submit();
            }
        });

			

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/defineinstitute')) ?>";
        });

        //When click reset buton
        $("#btnClear").click(function() {
            // Set lock = 0 when resetting table lock
            location.href="<?php echo url_for('training/Updateinstitute?id=' . $encrypt->encrypt($transIns->getTd_inst_id()) . '&lock=' . $encrypt->encrypt(0)) ?>";
        });


    });
</script>
