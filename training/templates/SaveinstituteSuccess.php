<script type="text/javascript" src="<?php echo public_path('../../scripts/jquery/jquery.validate.js') ?>"></script>
<div class="formpage4col">
    <div class="navigation">

        <?php echo message() ?>

    </div>
    <div id="status"></div>
    <div class="outerbox">
        <div class="mainHeading"><h2><?php echo __("New Institute Define") ?></h2></div>
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
                <input id="txten"  name="txten" type="text"  class="formInputText" value="" tabindex="1" maxlength="75"/>
            </div>
            <div class="centerCol">
                <input id="txtsi"  name="txtsi" type="text"  class="formInputText" value="" tabindex="1" maxlength="75"/>
            </div>
            <div class="centerCol">
                <input id="txtta"  name="txtta" type="text"  class="formInputText" value="" tabindex="1" maxlength="75"/>
            </div>
            <br class="clear"/>
            <div class="formbuttons">
                <input type="button" class="savebutton" id="editBtn"

                       value="<?php echo __("Save") ?>" tabindex="8" />
                <input type="button" class="clearbutton"  id="resetBtn"
                       value="<?php echo __("Reset") ?>" tabindex="9" />
                <input type="button" class="backbutton" id="btnBack"
                       value="<?php echo __("Back") ?>" tabindex="10" />
            </div>
        </form>
    </div>

</div>
<div class="requirednotice"><?php echo __("Fields marked with an asterisk") ?><span class="required"> * </span> <?php echo __("are required") ?></div>
<script type="text/javascript">

    $(document).ready(function() {
                    
        buttonSecurityCommon(null,"editBtn",null,null);


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

        var mode	=	'edit';

        //Disable all fields
       
        $("#editBtn").click(function() {

          
            
            $('#frmSave').submit();

          
        });

        //When click reset buton
        $("#resetBtn").click(function() {
            document.forms[0].reset('');
        });

        //When Click back button
        $("#btnBack").click(function() {
            location.href = "<?php echo url_for(public_path('../../symfony/web/index.php/training/defineinstitute')) ?>";
        });

    });
</script>
<?
?>