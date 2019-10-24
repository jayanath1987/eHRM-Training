
<table cellpadding="0" cellspacing="0" class="data-table">
    <tr>
        <td>
            ID 
        </td>
        <td>
            APPROVAL LEVEL
        </td>
        <td>
            WorkFlow Type Code
        </td>

        <td>
            Test ID
        </td>

        <td>
            TestComment
        </td>
    </tr>
    <tr>
        <?php
        $row = 0;
        foreach ($workFlowRecordDetails as $wfDetails) {
            $cssClass = ($row % 2) ? 'even' : 'odd';
            $row = $row + 1;
            ?>
        <tr class="<?php echo $cssClass ?>">

            <td>

                <?php
                $wfMainID=$wfDetails[ID];
                echo $wfDetails[ID];
                ?>
            </td>
            <td>
                <?php
                $approLevel=$wfDetails['APPROVAL LEVEL']; 
                echo $wfDetails['APPROVAL LEVEL']; 
                ?>
            </td>
            <td>
                <?php 
                $wftypeCode=$wfDetails['WorkFlow Type Code'];
                echo $wfDetails['WorkFlow Type Code']; ?>
            </td>
            <td>
                <?php 
                
                echo $wfDetails['Test ID']; ?>
            </td>
            <td>
                <?php echo $wfDetails['TestComment']; ?>
            </td>
        </tr>

    <?php } ?>
</tr>        

</table>
<form name="frmApprove" id="frmApprove" style="float: left" method="post" action="<?php echo url_for('training/TestWorkFlow'); ?>">
    <input type="hidden" name="hiddenWftypeID" value="<?php echo $wftypeCode ?>" />
    <input type="hidden" name="hiddenWfMainID" value="<?php echo $wfMainID ?>" />
    <input type="hidden" name="hiddenAppLevel" value="<?php echo $approLevel ?>" />
    
<input type="submit" class="plainbtn" id="buttonRemove"
       value="<?php echo __("Approve") ?>" />
</form>
<form name="frmReject" id="frmReject" method="post" action="<?php echo url_for('training/TestWorkFlow'); ?>">
    <input type="hidden" name="hiddenWftypeID" value="<?php echo $wftypeCode ?>" />
    <input type="hidden" name="hiddenWfMainID" value="<?php echo $wfMainID ?>" />
    <input type="hidden" name="hiddenAppLevel" value="<?php echo $approLevel ?>" />
<input type="submit" class="plainbtn" id="buttonRemove"
       value="<?php echo __("Reject") ?>" />
</form>

